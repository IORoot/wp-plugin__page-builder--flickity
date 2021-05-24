<?php

namespace andyp\pagebuilder\flickity\components;

class theme
{
    public $theme;

    public $cell_data;

    public $moustache_functions;

    public function __construct()
    {
        return $this;
    }

    public function set_theme($theme)
    {
        $this->theme = $theme;
    }

    public function set_cell_data($cell_data)
    {
        $this->cell_data = $cell_data;
    }

    public function result()
    {
        return $this->theme;
    }

    public function convert_moustaches()
    {
        if (empty($this->theme)){ return; }

        preg_match_all('/\{\{([\S|\s]*?)\}\}/', $this->theme, $matches);
        
        foreach ($matches[1] as $match) {

            $this->search_through_post($match);
            $this->search_through_meta($match);
            $this->search_through_extra($match);
        }

        return;
    }




    public function search_through_post($match)
    {
        if (!isset($match)) {
            return;
        }
        if (!isset($this->cell_data['post']->$match)) {
            return;
        }

        $value = $this->cell_data['post']->$match;

        $this->theme = str_replace('{{'.$match.'}}', $value, $this->theme);

        return;
    }



    public function search_through_meta($match)
    {
        if (!isset($match)) {
            return;
        }
        if (!isset($this->cell_data['meta'][$match])) {
            return;
        }

        $value = $this->cell_data['meta'][$match][0];

        $this->theme = str_replace('{{'.$match.'}}', $value, $this->theme);

        return;
    }




    public function search_through_extra($match)
    {
        $match_parts = explode(':', $match);

        $this->get_moustache_list();

        foreach ($this->moustache_functions as $moustache) {

            if ($moustache != $match_parts[0]){ continue; }

            $instance = '\\andyp\\pagebuilder\\flickity\\components\\moustache\\'. $moustache;

            $obj = new $instance;
            $obj->set_match($match);
            $obj->set_theme($this->theme);
            $obj->set_data($this->cell_data);

            /**
             * If there is a {{image_url:full}}
             * send the 'full' to set_args()
             */
            if ($match_parts[1] != '' || !empty($match_parts[1])){
                $obj->set_args($match_parts[1]);
            }

            $obj->match();
            $this->theme = $obj->result();
        }
    }




    public function get_moustache_list()
    {
        $files = scandir(__DIR__ . '/moustache');

        foreach ($files as $file) {
            $file = str_replace('.php', '', $file);
            $file_array["${file}"] = $file;
        }

        unset($file_array['.']);
        unset($file_array['..']);

        $this->moustache_functions = $file_array;

        return;
    }
}
