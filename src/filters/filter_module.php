<?php

namespace andyp\pagebuilder\flickity\filters;

use andyp\pagebuilder\flickity\components\flickity;

class filter_module
{


    public function __construct()
    {
        add_filter('pagebuilder_flickity', [$this, 'filter_code'], 10, 1);
    }


    public function filter_code($organism)
    {

        $flickity = new flickity;

        $flickity->set_organism($organism);

        $flickity->run();

        return $flickity->get_output();

    }

}