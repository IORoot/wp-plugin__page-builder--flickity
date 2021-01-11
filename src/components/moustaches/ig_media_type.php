<?php

namespace mf\moustache;

class ig_media_type { 


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

        $type = get_post_meta($cell->ID, 'type', true); // GraphVideo = videos / GraphSidecar = carousel / GraphImage = images

        $output = 'mdi-camera';

        if ($type == 'GraphVideo') {
            $output = 'mdi-play-circle';
        }
        if ($type == 'GraphSidecar') {
            $output = 'mdi-apps';
        }

        $this->result =  $output;
    }

}