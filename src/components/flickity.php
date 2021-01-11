<?php

namespace mf;

use \mf\options;
use \mf\render;
use \mf\template;

class andyp_flickity
{
    public $slug;

    public $term;

    public $tax;

    public $options = [];

    public $results = [];

    public $output;


    /**
     * __construct
     *
     * @return void
     */
    public function __construct($slug, $tax = null, $term = null)
    {
        $this->slug = $slug;
        $this->tax = $tax;
        $this->term = $term;

        $this->get_options();
        $this->parse_textareas();
        $this->cast_digits();

        $this->get_results();
        $this->get_metadata();

        $this->render_results();
        $this->enqueue_css();

        return $this;
    }


    /**
     * get_options
     *
     * @return void
     */
    public function get_options()
    {
        $options = new options;
        $this->options = $options->get_options($this->slug);

        return $this;
    }



    public function parse_textareas()
    {
        $this->options->shortcode['mf_query']           = $this->lb($this->options->shortcode['mf_query']);
        $this->options->shortcode['mf_arguments']       = $this->lb($this->options->shortcode['mf_arguments']);
        $this->options->shortcode['mf_override_css']    = $this->lb($this->options->shortcode['mf_override_css']);
        $this->options->theme['mf_theme_cell_html']     = $this->lb($this->options->theme['mf_theme_cell_html']);
    }

    public function cast_digits()
    {
        $this->options->shortcode["mf_viewport_cells"]          = (float) $this->options->shortcode["mf_viewport_cells"];
        $this->options->shortcode["mf_viewport_vertical_grid"]  = (float) $this->options->shortcode["mf_viewport_vertical_grid"];
        $this->options->shortcode["mf_vertical_stacking"]       = (float) $this->options->shortcode["mf_vertical_stacking"];
    }

    /**
     * remove_linebreaks
     *
     * @param mixed $in
     * @return void
     */
    public function lb($in)
    {
        return preg_replace("/\r|\n/", "", $in);
    }

    /**
     * get_results
     *
     * @return void
     */
    public function get_results()
    {
        $post_query = $this->options->shortcode['mf_query'];
        $args = eval("return $post_query;");

        $this->results = get_posts($args);

        return $this;
    }


    public function get_metadata()
    {
        foreach ($this->results as $key => $WP_Post) {
            $this->results[$key] = [];
            $this->results[$key]['post'] = $WP_Post;
            $this->results[$key]['meta'] = get_metadata('post', $WP_Post->ID);
        }
    }




    /**
     * render_results
     *
     * @return void
     */
    public function render_results()
    {
        $out = new render;
        $out->set_options($this->options);

        ob_start();

        $output = $out->open_wrapper();

        $output .= $out->title();

        $output .= $out->open_flickity_arguments();

        // Check if any results exist
        if (!isset($this->results)) {
            return ;
        }

        $col = 1;

        $output .= $out->open_vertical_stack();
                
        // Loop the results array.
        foreach ($this->results as $cell) {
            $cell = $this->convert_theme($cell);

            $output .= $out->open_cell($cell);

            $output .= $cell;

            $output .= $out->close_cell();

            $output .= $out->close_and_open_next_vertical_stack($col);     

            $col++;
        }

        $output .= $out->close_vertical_stack();

        $output .= $out->close_flickity_arguments();
        
        $output .= $out->highlight_button();
        $output .= $out->delete_button();
        $output .= $out->last_ran($this->results);

        $output .= $out->close_wrapper();

        echo $output;

        return ob_end_flush();
    }



    public function convert_theme($cell)
    {
        $theme = new theme;
        $theme->set_theme($this->options->theme["mf_theme_cell_html"]);
        $theme->set_cell_data($cell);
        $theme->convert_moustaches();
        return $theme->result();
    }






    /**
     * enqueue_css
     *
     * @return void
     */
    public function enqueue_css()
    {

        // Load and enqueue now, before everything else.
        wp_register_style( 'andyp_grid_immediate_css', ANDYP_FLICKITY_PATH . 'src/sass/immediate.css' );
        wp_enqueue_style( 'andyp_grid_immediate_css' );

        wp_register_style( 'flickity_css', 'https://unpkg.com/flickity@2/dist/flickity.min.css' );
        wp_register_script( 'flickity_js', 'https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js' );

        wp_register_style( 'andyp_grid_css', ANDYP_FLICKITY_PATH . 'src/sass/style.css' );

        $css = '';
        $default_viewport_cells = 4;
        $default_vertical_grid = 5;
        $meta_lines = 1;

        if ($this->options->shortcode["mf_meta_fields"] != '') {
            $meta_lines = $this->options->shortcode["mf_meta_fields"];
        }


        // Add resizing Number of Cells for CSS.
        if ($this->options->shortcode["mf_viewport_cells"] != '') {
            $css .= '.'.$this->options->shortcode["mf_shortcode_header"]["mf_shortcode_slug"] . ' .andyp-grid__cell { ';
            $css .= 'width: '. 100 / $this->options->shortcode["mf_viewport_cells"] . '%; ';
            $css .= '}';
        }

        if (empty($this->options->shortcode["mf_vertical_stacking"])) {
            $this->options->shortcode["mf_vertical_stacking"] = 1;
        }

        // Add resizing Height of Cell Image for CSS.
        if ($this->options->shortcode["mf_viewport_vertical_grid"] != '') {

            // Main carousel height
            $css .= '.'.$this->options->shortcode["mf_shortcode_header"]["mf_shortcode_slug"] . ' .andyp-grid__main-carousel { ';
            $css .= 'height: '. (29 * ($this->options->shortcode["mf_viewport_vertical_grid"] + $meta_lines)) * $this->options->shortcode["mf_vertical_stacking"] . 'px !important; ';
            $css .= '}';

            // Each cell min-height
            $css .= '.'.$this->options->shortcode["mf_shortcode_header"]["mf_shortcode_slug"] . ' .andyp-grid__cell { ';
            $css .= 'min-height: '. 29 * ($this->options->shortcode["mf_viewport_vertical_grid"] + $meta_lines) . 'px !important; ';
            $css .= '}';

            // Each cell image height
            $css .= '.'.$this->options->shortcode["mf_shortcode_header"]["mf_shortcode_slug"] . ' .andyp-grid__cell-image { ';
            $css .= 'height: '. 29 * $this->options->shortcode["mf_viewport_vertical_grid"] . 'px !important; ';
            $css .= '}';

            // Flickity height
            $css .= '.'.$this->options->shortcode["mf_shortcode_header"]["mf_shortcode_slug"] . ' .flickity-viewport { ';
            $css .= 'height: '. (29 * ($this->options->shortcode["mf_viewport_vertical_grid"] + $meta_lines)) * $this->options->shortcode["mf_vertical_stacking"] . 'px !important; ';
            $css .= '}';
        }

        // Add any rules included in the ACF CSS Field.
        $css .= $this->options->shortcode["mf_override_css"];

        wp_add_inline_style('andyp_grid_css', $css);

        
        // Finally enqueue the grid css.
        wp_enqueue_style('flickity_css');
        wp_enqueue_script('flickity_js');
        wp_enqueue_style('andyp_grid_css');

        return $this;
    }
}
