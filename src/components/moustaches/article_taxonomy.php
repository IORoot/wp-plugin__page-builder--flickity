<?php

namespace mf\moustache;

class article_taxonomy {


    public $match;
    public $theme;
    public $data;
    public $result;


    public function set_match($match)
    {
        $this->match = $match;
    }

    public function set_theme($theme)
    {
        $this->theme = $theme;
    }

    public function set_data($data)
    {
        $this->data = $data;
    }

    public function result()
    {
        return str_replace('{{'.$this->match.'}}', $this->result, $this->theme);
    }



    


    public function match()
    {
        $cell = $this->data['post'];

        if ($cell->post_type != 'article') {
            return;
        }

        $cell_id = $cell->ID;

        // Get the post category.
        $terms = get_the_terms($cell_id, 'articlecategory');
        
        //Use it's ID to get the custom colour.
        $tax_colour = '';
        $tax_colour = get_field('taxonomy_colour', 'articlecategory_' . $terms[0]->term_id);

        $output = '<div class="andyp-grid__cell-meta andyp-grid__cell-tax" style="background-color:'.$tax_colour.'">';

        $terms = get_the_terms($cell_id, 'articlecategory');

        $output .= $terms[0]->name;

        $output .= '</div>';

        $this->result =  $output;
    }

    

}