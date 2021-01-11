<?php

namespace mf\moustache;

class article_media_type {


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

        if (get_post_meta($cell, 'videoId', true) == '') {
            $output = 'mdi-book-open';
        }

        $output = 'mdi-play-circle-outline';

        $this->result =  $output;
    }

}