<?php


add_action('acf/init', 'menu_flickity');

function menu_flickity(){

    if( function_exists('acf_add_options_page') ) {
        
        $args = array(

            'page_title' => '<svg viewBox="0 0 24 24" style="height:1.3em; vertical-align:text-bottom; fill:#FF80AB;" xmlns="http://www.w3.org/2000/svg"><path d="M22,14A2,2 0 0,1 20,16H4A2,2 0 0,1 2,14V10A2,2 0 0,1 4,8H20A2,2 0 0,1 22,10V14M4,14H8V10H4V14M10,14H14V10H10V14M16,14H20V10H16V14Z"/></svg> Metafizzy Flickity',
            'menu_title' => '<svg viewBox="0 0 24 24" style="height:1.3em; vertical-align:text-bottom; fill:#FF80AB;" xmlns="http://www.w3.org/2000/svg"><path d="M22,14A2,2 0 0,1 20,16H4A2,2 0 0,1 2,14V10A2,2 0 0,1 4,8H20A2,2 0 0,1 22,10V14M4,14H8V10H4V14M10,14H14V10H10V14M16,14H20V10H16V14Z"/></svg> Metafizzy Flickity',
            'menu_slug' => 'gridshortcodes',
            'capability' => 'manage_options',
            'position' => 3,
            'parent_slug' => 'andyp',
            'icon_url' => 'dashicons-screenoptions',
            'redirect' => true,
            'post_id' => 'options',
            'autoload' => false,
            'update_button'		=> __('Update', 'acf'),
            'updated_message'	=> __("Options Updated", 'acf'),
        );


        acf_add_options_sub_page($args);
        
    }
}
