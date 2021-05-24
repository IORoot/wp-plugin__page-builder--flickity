<?php

namespace andyp\pagebuilder\flickity\components\moustache;

class post_term {


    public $match;
    public $theme;
    public $data;
    public $args;
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

    public function set_args($args)
    {
        $this->args = $args;
    }

    public function result()
    {
        return str_replace('{{'.$this->match.'}}', $this->result, $this->theme);
    }



    
    public function match()
    {
        $term_list = [];
        $post = $this->data['post'];

        $taxonomies = get_object_taxonomies($post);

        foreach($taxonomies as $taxonomy)
        {
            $terms = (array) get_the_terms($post, $taxonomy);
            $term_list = array_merge($term_list, $terms);
        }        

        
        $this->result = $term_list[$this->args]->name;

        return;
    }

    

}