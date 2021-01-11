<?php

namespace andyp\pagebuilder\flickity\components;


class inline_css
{

    public $slug;

    public $organism;

    public $css;



    public function set_slug($slug)
    {
        $this->slug = '.flickity ' . $slug;
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

        $this->cell_meta_height();

        $this->cell_meta_height_format();

        $this->stack_height();

        $this->stack_height_format();

        $this->render_image();

        $this->render_cell();
        
        $this->render_carousel();

        $this->render_flickity();

        $this->render_custom_css();

    }

    private function cell_width()
    {
        $this->organism['cell_width'] = 100 / $this->organism["viewport_cells"];
    }

    private function cell_meta_height()
    {
        $this->organism['cell_meta_height'] = $this->organism["cell_height"] + $this->organism["meta_space"];
    }

    private function cell_meta_height_format()
    {
        $this->organism['cell_meta_height_format'] = $this->organism['cell_meta_height'] . $this->organism["format"];
    }

    private function stack_height()
    {
        $this->organism['stack_height'] = $this->organism['cell_meta_height'] * $this->organism["vertical_stack"];
    }

    private function stack_height_format()
    {
        $this->organism['stack_height_format'] = $this->organism['stack_height'] . $this->organism["format"];
    }




    private function render_image()
    {
        $this->css .= '.'.$this->slug . ' .cell-image { ';

            $this->css .= 'height: '. $this->organism["cell_height"] . $this->organism['format'] . '; ';

        $this->css .= '}'. PHP_EOL;
    }


    private function render_cell()
    {
        if (empty($this->organism["viewport_cells"])) { return; }

        $this->css .= '.'.$this->slug . ' .cell { ';

            $this->css .= 'width: '. $this->organism['cell_width'] . '%; ';
            
            $this->css .= 'min-height: '. $this->organism['cell_meta_height_format'] . '; ';

        $this->css .= '}' . PHP_EOL;

    }



    private function render_carousel()
    {
        if (empty($this->organism["stack_height_format"])) { return; }

        $this->css .= '.' . $this->slug . ' .main-carousel { ';

            $this->css .= 'height: '. $this->organism["stack_height_format"]  . '; ';
        
        $this->css .= '}'. PHP_EOL;
    }

    

    private function render_flickity()
    {
        $this->css .= '.'.$this->slug . ' .flickity-viewport { ';

            $this->css .= 'height: '. $this->organism['stack_height_format'] . '; ';
        
        $this->css .= '}'. PHP_EOL;
    }



    private function render_custom_css()
    {
        $css .= $this->organism["additional_css"];
    }
}