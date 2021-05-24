<?php

namespace andyp\pagebuilder\flickity\components;

use andyp\pagebuilder\flickity\acf\options;
use andyp\pagebuilder\flickity\components\render;
use andyp\pagebuilder\flickity\components\theme;
use andyp\pagebuilder\flickity\components\inline_css;

class flickity
{

    private $slug;
    
    private $organism;

    private $results = [];

    private $output;



    public function set_organism($organism)
    {
        $this->organism = $organism;
    }


    public function run()
    {

        if (empty($this->organism['wp_query'])){ return; }

        $this->set_slug();

        $this->prepare();

        $this->query();
        
        $this->metadata();

        $this->render_results();

        $this->register_css();

        $this->inline_css();

        $this->enqueue_css();
    }


    public function get_output()
    {
        return $this->output;
    }



    private function set_slug()
    {
        $this->slug = sanitize_title($this->organism['title']);
    }



    private function prepare()
    {
        $this->lb('wp_query');
        $this->lb('flickity_arguments');
        $this->lb('additional_css');
        $this->lb('template');
        $this->cast_to_float( "viewport_cells" );
        $this->cast_to_float( "cells_in_a_stack" );
    }







    /**
     * query database for results
     */
    private function query()
    {
        if (empty($this->organism['wp_query'])){ return; }

        $post_query = $this->organism['wp_query'];

        $args = eval("return $post_query;");

        $this->results = get_posts($args);
    }





    private function metadata()
    {

        if (empty($this->results)){ return; }

        foreach ($this->results as $key => $WP_Post) {
            $this->results[$key] = [];
            $this->results[$key]['post'] = $WP_Post;
            $this->results[$key]['meta'] = get_metadata('post', $WP_Post->ID);
        }
    }




    private function render_results()
    {
        // Check if any results exist
        if (empty($this->results)) { return; }

        $out = new render;

        $out->set_options($this->organism);


            $output[] = $out->open_wrapper();

            $output[] .= $out->open_flickity_arguments();

            $col = 1;
                    
            // Loop the results array.
            foreach ($this->results as $loop_key => $loop_cell) {

                $output[] = $out->open_vertical_stack($loop_key);

                $output[] = $out->open_cell();

                $output[] = $this->theme($loop_cell);

                $output[] = $out->close_cell();

                // $output[] = $out->close_and_open_next_vertical_stack($col);     

                $output[] = $out->close_vertical_stack($loop_key);

                $col++;

            }

            $output[] = $out->close_flickity_arguments();

            $output[] = $out->close_wrapper();


        $this->output = implode($output);
    }



    private function theme($cell)
    {
        $theme = new theme;

        $theme->set_theme($this->organism["template"]);

        $theme->set_cell_data($cell);

        $theme->convert_moustaches();

        return $theme->result();
    }




    private function register_css()
    {
        // wp_register_script( 'flickity_js', 'https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js' );
        wp_register_script( 'flickity_js', ANDYP_PAGEBUILDER_FLICKITY_URL . '/src/js/flickity.min.js' );

        // wp_register_style(  'flickity_css', 'https://unpkg.com/flickity@2/dist/flickity.min.css' ); 
        wp_register_style(  'flickity_css', ANDYP_PAGEBUILDER_FLICKITY_URL . '/src/css/flickity.css' ); 
        wp_register_style(  'flickity_inline_css', ANDYP_PAGEBUILDER_FLICKITY_URL . '/src/css/style.css' );
    }



    private function inline_css()
    {
        $css = new inline_css;
        $css->set_organism($this->organism);
        $css->set_slug($this->slug);
        $css->create();

        $inline_css = $css->get_result();
        
        // Finally enqueue the grid css.
        wp_add_inline_style('flickity_inline_css', $inline_css);

    }



    private function enqueue_css()
    {
        wp_enqueue_style( 'flickity_inline_css');
        wp_enqueue_script('flickity_js');
        wp_enqueue_style( 'flickity_css');
    }




    /**
     * remove_linebreaks
     */
    private function lb($in)
    {
        $this->organism[$in] = preg_replace("/\r|\n/", "", $this->organism[$in]);
    }


    private function cast_to_float($in)
    {
        if (!array_key_exists($in, $this->organism)){ return; }
        $this->organism[$in] = (float) $this->organism[$in];
    }
}
