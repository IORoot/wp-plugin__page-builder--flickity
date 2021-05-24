<?php

namespace andyp\pagebuilder\flickity\components;

class render
{
    public $options;


    public function set_options($options)
    {
        $this->options = $options;
    }


    /**
     * open_wrapper
     *
     * @return void
     */
    public function open_wrapper()
    {
        return '<div class="flickity '. sanitize_title($this->options["title"]) .' '.$this->options['classes'].'">';
    }
    


    /**
     * open_flickity_arguments
     *
     * @return void
     */
    public function open_flickity_arguments()
    {
        $flickity = '';

        if (isset($this->options["flickity_arguments"])) {
            $flickity = 'data-flickity=\' '.$this->options["flickity_arguments"].' \'';
        }

        return '<div class="main-carousel" '.$flickity.'>';
    }



    /**
     * open_vertical_stack
     *
     * @return void
     */
    public function open_vertical_stack($result_number)
    {
        // Are we going to stack the results vertically?
        if (!$this->is_vertical_stack_on()) {  return; }

        // if $result_number = 2,4,6...
        if($result_number % $this->options["vertical_stack"] == 0)
        {
            return '<div class="vertical-stack carousel-cell inline-block '.$this->options['vertical_stack_classes'].'">';
        }
        
    }

    /**
     * open_vertical_cell_stack
     *
     * @return void
     */
    public function open_cell()
    {
        return '<div class="sub-cell '.$this->options['cell_classes'].'">';
    }

    /**
     * close_vertical_cell_stack
     *
     * @return void
     */
    public function close_cell()
    {
        return '</div>';
    }



    /**
     * close_wrapper
     *
     * @return void
     */
    public function close_vertical_stack($result_number)
    {
        if (!$this->is_vertical_stack_on()) { return; }
        $result_number++;
        $vertical_stack = (int) $this->options["vertical_stack"];

        // if $result_number = 3,6,9...
        if ( $result_number % $vertical_stack == 0) {
            return '</div>';
        }
        
    }



    /**
     * close_flickity_arguments
     *
     * @return void
     */
    public function close_flickity_arguments()
    {
        return '</div>';
    }


    /**
     * close_wrapper
     *
     * @return void
     */
    public function close_wrapper()
    {
        return '</div>';
    }


    /**
     * is_vertical_stack_on
     *
     * @return void
     */
    public function is_vertical_stack_on()
    {
        if (isset($this->options["vertical_stack"]) && $this->options["vertical_stack"] != 0) {
            return true;
        }

        return false;
    }
}
