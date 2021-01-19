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
    public function open_vertical_stack()
    {
        // Are we going to stack the results vertically?
        if ($this->is_vertical_stack_on()) {
            return '<div class="vertical-stack carousel-cell inline-block">';
        }
    }

    
    /**
     * open_vertical_cell_stack
     *
     * @return void
     */
    public function open_cell()
    {
        return '<div class="sub-cell">';
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
     * close_and_open_next_vertical_stack
     *
     * @param mixed $col
     * @return void
     */
    public function close_and_open_next_vertical_stack($col)
    {
        // add a wrapper around every X items.
        if ($this->is_vertical_stack_on()) {
            if ($col % $this->options["vertical_stack"] == 0) {
                return '</div><div class="vertical-stack carousel-cell '.$this->options['cell_classes'].'">';
            }
        }
    }




    /**
     * close_wrapper
     *
     * @return void
     */
    public function close_vertical_stack()
    {
        if ($this->is_vertical_stack_on()) {
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
