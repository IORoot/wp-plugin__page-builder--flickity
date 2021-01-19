<?php

namespace andyp\pagebuilder\flickity\components;


class inline_css
{

    public $slug;

    public $organism;

    public $css;



    public function set_slug($slug)
    {
        $this->slug = '.flickity.' . $slug;
    }


    public function set_organism($organism)
    {
        $this->organism = $organism;
    }


    public function get_result()
    {
        return $this->css;
    }
    

    public function create()
    {
        $this->render_custom_css();
    }


    private function render_custom_css()
    {
        $css .= $this->organism["additional_css"];
    }
}