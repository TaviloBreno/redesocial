<?php

namespace App\Core;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class View
{
    protected $twig;

    public function __construct()
    {
        $loader = new FilesystemLoader('../app/Views');
        $this->twig = new Environment($loader, [
            'cache' => false,  // Altere para 'cache' => 'path/to/cache' em produção
        ]);
    }

    public function render($view, $data = [])
    {
        echo $this->twig->render($view . '.twig', $data);
    }
}