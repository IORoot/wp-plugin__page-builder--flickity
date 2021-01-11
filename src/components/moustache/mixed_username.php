<?php

namespace andyp\pagebuilder\flickity\components\moustache;


// ┌─────────────────────────────────────────────────────────────────────────┐
// │                                                                         │
// │          USED FOR BOTH YOUTUBE AND INSTAGRAM MIXED RESULTS              │
// │                                                                         │
// └─────────────────────────────────────────────────────────────────────────┘
class mixed_username {


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

        $output = get_post_meta($cell->ID, 'username', true); // If there IS a 'username' field, then it's an instagram post.
        
        if (!$output) {
            $output = get_post_meta($cell->ID, 'channelTitle', true); // If there IS a 'channelTitle' field, then it's an youtube post.
        }

        $this->result =  $output;
    }

}