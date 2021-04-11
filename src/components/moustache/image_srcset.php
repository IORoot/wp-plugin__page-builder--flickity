<?php

namespace andyp\pagebuilder\flickity\components\moustache;

class image_srcset {


    public $match;
    public $theme;
    public $data;
    public $args = 'medium';
    public $result;


    public function set_args($args)
    {
        $this->args = $args;
    }

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
        $attachment_id = get_post_thumbnail_id($post);

        $this->result = wp_get_attachment_image_srcset($attachment_id, $this->args);

        return;
    }

    

}