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

        $this->cell_width();

        $this->render_cell();

        $this->render_custom_css();

    }

    private function cell_width()
    {
        $this->organism['cell_width'] = 100 / $this->organism["viewport_cells"];
    }


    private function render_cell()
    {
        if (empty($this->organism["viewport_cells"])) { return; }

        $this->css .= $this->slug . ' .carousel-cell { ';

            $this->css .= 'width: '. $this->organism['cell_width'] . '%; ';

        $this->css .= '}' . PHP_EOL;

    }


    private function render_custom_css()
    {
        $css .= $this->organism["additional_css"];
    }
}