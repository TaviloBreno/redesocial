<?php

require_once __DIR__ . '/../vendor/autoload.php';

use ScssPhp\ScssPhp\Compiler;
use ScssPhp\ScssPhp\CompilerException;

$scss = new Compiler();

$scss->setFormatter('ScssPhp\ScssPhp\Formatter\Compressed');

try {
    $inputFile = __DIR__ . '/scss/style.scss';
    $outputFile = __DIR__ . '/css/style.css';

    $scssContent = file_get_contents($inputFile);
    $cssContent = $scss->compile($scssContent);
    file_put_contents($outputFile, $cssContent);

    echo "SCSS compilado com sucesso!";
} catch (CompilerException $e) {
    echo "Erro ao compilar SCSS: ", $e->getMessage();
}
