<?php

namespace mf;

class options {

    public $shortcode;
    public $theme;
    
    public function __construct()
    {
        return $this;
    }

    public function get_options($id)
    {
        $this->get_all_repeater_options('mf_flickity_shortcode', 'shortcode');
        $this->set_single_shortcode($id);

        $this->get_all_repeater_options('mf_flickity_theme', 'theme');
        $this->set_single_theme();
        
        return $this;
    }



    public function get_all_repeater_options($repeater_field_name, $result_parameter, $id = null)
    {
        // If field exists as an option
        if (have_rows($repeater_field_name, 'option')) {

            // Go through all rows of 'repeater' genimage_filters
            while (have_rows($repeater_field_name, 'option')): $row = the_row(true);

            $this->get_repeater_row($row, $result_parameter);

            endwhile;
        }
    }

    public function get_repeater_row($row, $result_parameter)
    {

        $this->$result_parameter[] = $row;

        return $this;
    }


    public function set_single_shortcode($id)
    {
        foreach ($this->shortcode as $shortcode)
        {
            if ($shortcode['mf_shortcode_header']['mf_shortcode_slug'] != $id)
            {
                continue;
            }
            $this->shortcode = $shortcode;
        }
        return;
    }


    public function set_single_theme()
    {
        foreach ($this->theme as $theme)
        {
            if ($theme['mf_theme_id'] != $this->shortcode["mf_cell_theme"])
            {
                continue;
            }
            $this->theme = $theme;
        }
        return;
    }

}