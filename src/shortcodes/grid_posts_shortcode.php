<?php

/**
 * Create the class and return results.
 */
function andyp_flickity_callback($atts){

    $a = shortcode_atts( 
        array(
            'slug' => '',
            'tax'  => null,
            'term' => null
        ), $atts );

    $grid = new \mf\andyp_flickity($a['slug'], $a['tax'], $a['term']);
    // $results = $grid->render_results();

    return;
}

add_shortcode( 'andyp_flickity', 'andyp_flickity_callback' );