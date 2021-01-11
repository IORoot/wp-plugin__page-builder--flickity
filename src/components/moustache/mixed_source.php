<?php

namespace andyp\pagebuilder\flickity\components\moustache;


// ┌─────────────────────────────────────────────────────────────────────────┐
// │                                                                         │
// │          USED FOR BOTH YOUTUBE AND INSTAGRAM MIXED RESULTS              │
// │                                                                         │
// └─────────────────────────────────────────────────────────────────────────┘
class mixed_source {


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

        // default
        $output = 'mdi-youtube-tv';

        $ig = get_post_meta($cell->ID, 'username', true); // If there IS a 'username' field, then it's an instagram post.
        $it = get_post_meta($cell->ID, 'audioLink', true); // If there IS a 'audioLink' field, then it's an podcast post.
        
        if ($ig) {
            $output = 'mdi-instagram';
        }
        
        if ($it) {
            $output = 'mdi-google-podcast';
        }

        $this->result =  $output;
    }

}