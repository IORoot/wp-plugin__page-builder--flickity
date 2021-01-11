<?php

class andyp_grid_tax_shortcode {

    public $options = [];

    public $results = [];

    public $output;

    public $slug;

    /**
     * __construct
     *
     * @return void
     */
    public function __construct($slug){

        $this->slug = $slug;

        $this->get_options();
        $this->get_results();
        $this->enqueue_css();

        return $this;
    }


    /**
     * get_options
     *
     * @return void
     */
    public function get_options(){

        $result = []; 

        // // If field exists as an option
        if( have_rows('grid_shortcode', 'option') ) {

            // Go through all rows of 'repeater'
            while( have_rows('grid_shortcode', 'option') ): $row = the_row();

                // Fields to retrieve from repeater
                $result = array ( 
                    'slug'              => get_sub_field('shortcode_slug'),
                    'title'             => get_sub_field('shortcode_title'),
                    'viewport_cells'    => get_sub_field('viewport_cells'),
                    'vertical_grid'     => get_sub_field('viewport_vertical_grid'),
                    'vertical_stacking' => get_sub_field('vertical_stacking'),
                    'tax_args'          => $this->lb(get_sub_field('args')), 
                    'flickity_args'     => $this->lb(get_sub_field('flickity_args')), 
                    'flickity_css'      => $this->lb(get_sub_field('flickity_css')), 
                );

                // push onto result array if the right slug is being used.
                if ($result['slug'] == $this->slug){                   
                    $this->options = $result;
                }
                
            endwhile;
        }

        return $this;

    }


    /**
     * remove_linebreaks
     *
     * @param mixed $in
     * @return void
     */
    public function lb($in){

        return preg_replace( "/\r|\n/", "", $in );

    }


    /**
     * get_results
     *
     * @return void
     */
    public function get_results(){

        $tax_args = preg_replace( "/\r|\n/", "", $this->options['tax_args'] );

        $args = eval("return $tax_args;");

        $this->results = get_categories($args);

        return $this;

    }



    /**
     * render_results
     *
     * @return void
     */
    public function render_results(){

        ob_start();

        $output = '<div class="andyp-grid '.$this->options['slug'].'">';

            $output .= $this->render_title();

            $flickity = '';
            if ($this->options['flickity_args'] != ''){
                $flickity = 'data-flickity=\' '.$this->options['flickity_args'].' \'';
            }

            $output .= '<div class="andyp-grid__main-carousel main-carousel" '.$flickity.'>';

            // Check if any results exist
            if ( ! empty( $this->results ) && is_array( $this->results ) ) {

                $col = 1;

                if (!empty($this->options['vertical_stacking'])){
                    $output .= '<div class="andyp-grid__cell carousel-cell">';
                }
                

                foreach ( $this->results as $cell ) {

                    $output .= $this->render_cell($cell);
                    
                    // add a wrapper around every 3 items.

                    if (!empty($this->options['vertical_stacking'])){

                        if($col % $this->options['vertical_stacking'] == 0) {
                            $output .= '</div><div class="andyp-grid__cell carousel-cell">';
                        }

                    }

                    

                    $col++;

                }

                if (isset($this->options['flickity_args'])){
                    $output .= '</div>';
                }
                
            }
            
            $output .= '</div>';

        $output .= '</div>';

        echo $output;

        return ob_end_flush();
    }



    /**
     * render_title
     *
     * @return void
     */
    public function render_title(){

        if ($this->options['title'] != ''){
            return '<h3 class="andyp-grid__header">'.$this->options['title'].'</h3>';
        }

        return;
    }



    /**
     * render_cell
     *
     * @return void
     */
    public function render_cell($cell){
        
        if (empty($this->options['vertical_stacking'])){
            $output = '<div class="andyp-grid__cell carousel-cell pushin">';
        } else {
            $output = '<div class="pushin" >';
        }
        
            $output .= '<a class="andyp-grid__cell-link" href="' . esc_url( get_term_link($cell->term_id) ) . '">';

                $output .= '<div class="andyp-grid__cell-meta andyp-grid__cell-overlay"><i class="andyp-grid__cell-icon material-icons">remove_red_eye</i></div>';

                $output .= '<i class="andyp-grid__cell-icon material-icons" >'.$this->video_or_image($cell).'</i>';

                $image = get_field("article_category_image", 'term_'.$cell->term_id);
                $output .= '<div class="andyp-grid__cell-meta andyp-grid__cell-image lazyload" data-bg="'.$image['url'].'"></div>';

                // Category name
                $output .= '<div class="andyp-grid__cell-meta andyp-grid__cell-title">'.apply_filters('andyp-grid__cell-title', $cell->cat_name).'</div>';

                // Category Count
                $output .= '<div class="andyp-grid__cell-meta andyp-grid__cell-count">'.apply_filters('andyp-grid__cell-count', $cell->count).'</div>';

            $output .= '</a>';
        $output .= '</div>';

        return $output; 

    }


    /**
     * video_or_image
     *
     * @param mixed $cell
     * @return void
     */
    public function video_or_image($cell){
        return 'list';
    }



    /**
     * enqueue_css
     *
     * @return void
     */
    public function enqueue_css(){

        $css = '';
        $default_viewport_cells = 4;
        $default_vertical_grid = 5;

        // Add resizing Number of Cells for CSS.
        if ($this->options['viewport_cells'] != ''){
            $css .= '.'.$this->options['slug'] . ' .andyp-grid__cell { ';         
                $css .= 'width: '. 100 / $this->options['viewport_cells'] . '%; ';
            $css .= '}';
        }

        if (empty($this->options['vertical_stacking'])){ $this->options['vertical_stacking'] = 1;}

        // Add resizing Height of Cell Image for CSS.
        if ($this->options['vertical_grid'] != ''){ 

            $css .= '.'.$this->options['slug'] . ' .andyp-grid__main-carousel { ';         
                $css .= 'height: '. (29 * $this->options['vertical_grid']) * $this->options['vertical_stacking'] . 'px !important; ';
            $css .= '}';

            $css .= '.'.$this->options['slug'] . ' .andyp-grid__cell-image { ';         
                $css .= 'height: '. 29 * $this->options['vertical_grid'] . 'px !important; '; 
            $css .= '}';

            $css .= '.'.$this->options['slug'] . ' .flickity-viewport { ';         
                $css .= 'height: '. (29 * $this->options['vertical_grid']) * $this->options['vertical_stacking'] . 'px !important; ';
            $css .= '}';
        }

        // Add any rules included in the ACF CSS Field.
        $css .= $this->options['flickity_css'];

        wp_add_inline_style( 'andyp_grid_css' , $css );

        // Finally enqueue the grid css.
        wp_enqueue_style( 'flickity_css' );
        wp_enqueue_script('flickity_js');
        wp_enqueue_style( 'andyp_grid_css' );

        return $this;
    }


}



/**
 * Create the class and return results.
 */
function andyp_grid_tax($atts){

    // Extract the 'slug' attribute
    $a = shortcode_atts( 
        array(
            'slug' => ''
        ), $atts );

    $grid = new andyp_grid_tax_shortcode($a['slug']);

    $grid->render_results();

    return;
}

add_shortcode( 'andyp_grid_tax', 'andyp_grid_tax' );