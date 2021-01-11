<?php

namespace andyp\pagebuilder\flickity\components\moustache;

class youtube_playlist_link {


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
        $this->result = 'https://youtube.com/playlist?list='. $this->data["meta"]["playlistId"][0];
        return;
    }

    

}