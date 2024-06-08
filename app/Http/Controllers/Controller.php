<?php

namespace App\Http\Controllers;

abstract class Controller
{
    protected $models;
    protected $datatable;

    public function __construct()
    {
        $this->models = initialize_models();
        $this->datatable = datatable();
    }
}
