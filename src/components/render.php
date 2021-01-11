<?php

namespace mf;

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
        return '<div class="andyp-grid '.  $this->options->shortcode["mf_shortcode_header"]["mf_shortcode_slug"] .'">';
    }

    /**
     * open_form
     *
     * @return void
     */
    public function open_form()
    {
        if (current_user_can('edit_posts')) {

            $url = '/pulse';
            if (isset($_SERVER['REDIRECT_URL'])) {
                $url = $_SERVER['REDIRECT_URL'];
            }

            $slug = $this->options->shortcode["mf_shortcode_header"]["mf_shortcode_slug"];
            return '<form id="'.$slug.'" name="'.$slug.'" method="post" action="'.$url.'">';
        }
    }

    
    /**
     * title
     *
     * @return void
     */
    public function title()
    {
        if (isset($this->options->shortcode["mf_shortcode_header"]["mf_shortcode_title"])) {
            return '<h3 id="'.$this->options->shortcode["mf_shortcode_header"]["mf_shortcode_slug"].'" class="andyp-grid__header">'. $this->options->shortcode["mf_shortcode_header"]["mf_shortcode_title"] . '</h3>';
        }
    }

    /**
     * last ran time
     *
     * @return void
     */
    public function last_ran($results)
    {

        if (!$results[0]){
            return;
        }

        if (!isset($results[0]['meta']['scrapeId'][0]))
        {
            return;
        }

        $output = '<p class="andyp-grid__last-ran">';
            $output .=  do_shortcode('[andyp_scrape_date scrape_id="'.$results[0]['meta']['scrapeId'][0].'" fmt="ago"]');
        $output .= '</p>';

        return $output;
    }

    
    /**
     * delete_button
     *
     * @return void
     */
    public function delete_button()
    {
        $delete_button = '';
        if (current_user_can('edit_posts')) {
            $delete_button = '<input class="andyp-grid__cell-button--delete" type="submit" name="command" value="Delete"/> ';
        }
        return $delete_button;
    }

    /**
     * highlight_button
     *
     * @return void
     */
    public function highlight_button()
    {
        $highlight_button = '';
        if (current_user_can('edit_posts')) {
            $highlight_button = '<input class="andyp-grid__cell-button--highlight" type="submit" name="command" value="Highlight"/> ';
        }
        return $highlight_button;
    }


    /**
     * open_flickity_arguments
     *
     * @return void
     */
    public function open_flickity_arguments()
    {
        $flickity = '';

        if (isset($this->options->shortcode["mf_arguments"])) {
            $flickity = 'data-flickity=\' '.$this->options->shortcode["mf_arguments"].' \'';
        }

        return '<div class="andyp-grid__main-carousel main-carousel" '.$flickity.'>';
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
            return '<div class="andyp-grid__cell vertical-stack carousel-cell">';
        }
    }

    
    /**
     * open_vertical_cell_stack
     *
     * @return void
     */
    public function open_cell()
    {
        return '<div class="andyp-grid__cell carousel-cell">';
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
            if ($col % $this->options->shortcode["mf_vertical_stacking"] == 0) {
                return '</div><div class="andyp-grid__cell vertical-stack carousel-cell">';
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
     * close_form
     *
     * @return void
     */
    public function close_form()
    {
        if (current_user_can('edit_posts')) {
            return '</form>';
        }
    }

    /**
     * is_vertical_stack_on
     *
     * @return void
     */
    public function is_vertical_stack_on()
    {
        if (isset($this->options->shortcode["mf_vertical_stacking"]) && $this->options->shortcode["mf_vertical_stacking"] != 0) {
            return true;
        }

        return false;
    }
}
