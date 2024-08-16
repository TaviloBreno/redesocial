<?php

namespace App\Core;

class Controller
{
    public function model($model)
    {
        require_once "../app/Models/$model.php";
        return new $model();
    }
}