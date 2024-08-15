<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\View;

class HomeController extends Controller
{
    public function index()
    {
        $view = new View();
        $view->render('home/index', ['title' => 'Welcome to Rede Social']);
    }
}