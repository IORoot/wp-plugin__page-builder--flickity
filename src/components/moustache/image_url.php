<?php

namespace andyp\pagebuilder\flickity\components\moustache;

class image_url {


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
        $post = $this->data['post'];

        $this->result = get_the_post_thumbnail_url($post, 'full');

        return;
    }

    

}