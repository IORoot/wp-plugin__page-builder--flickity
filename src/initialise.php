<?php

namespace andyp\pagebuilder\flickity;

class initialise
{
    public function __construct()
    {

        // ┌─────────────────────────────────────────────────────────────────────────┐
        // │                Register filter for page builder to use.    		     │
        // └─────────────────────────────────────────────────────────────────────────┘
        new filters\filter_module;
    }



}