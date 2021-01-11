<?php

namespace andyp\pagebuilder\flickity\components\moustache;


// ┌─────────────────────────────────────────────────────────────────────────┐
// │                                                                         │
// │          USED FOR BOTH YOUTUBE AND INSTAGRAM MIXED RESULTS              │
// │                                                                         │
// └─────────────────────────────────────────────────────────────────────────┘
class mixed_link {


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

        //  YouTube
        $yt = get_post_meta($cell->ID, 'videoId', true);
        if ($yt) {
            $output = 'https://www.youtube.com/watch?v=' . $yt; // If there IS a 'channelTitle' field, then it's an youtube post.
        }

        // Instagram
        $ig = get_post_meta($cell->ID, 'shortcode', true);
        if ($ig)
        {
            $output = 'https://instagram.com/p/' . $ig; // If there IS a 'shortcode' field, then it's an instagram post.
        }

        // iTunes
        $it = get_post_meta($cell->ID, 'audioLink', true);
        if ($it)
        {
            $output = get_post_meta($cell->ID, 'link', true);
        }

        $this->result =  $output;
    }

}