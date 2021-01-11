<?php

function acf_populate_mf_cell_theme_choices($field)
{
    $field['choices'] = [];

    // get the ID value from options page without any formatting
    $choices = get_field('mf_flickity_theme', 'option', true);
    
    // loop through array and add to field 'choices'
    if (is_array($choices)) {
        foreach ($choices as $choice) {
            $choice_name = $choice['mf_theme_id'];
            $field['choices'][ $choice_name ] = $choice_name;
        }
    }

    $field['choices']['default'] = "Default";

    return $field;
}

add_filter('acf/load_field/name=mf_cell_theme', 'acf_populate_mf_cell_theme_choices');
