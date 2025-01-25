<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use Smarty\Smarty;

function getSmarty()
{
    $smarty = new Smarty();

    // Configuração dos diretórios
    $smarty->setTemplateDir(__DIR__ . '/../views/templates/');
    $smarty->setCompileDir(__DIR__ . '/../views/templates_s/');
    $smarty->setCacheDir(__DIR__ . '/../views/cache/');

    // Defina as permissões adequadas para as pastas
    if (!is_dir($smarty->getCompileDir())) {
        mkdir($smarty->getCompileDir(), 0775, true);
    }

    if (!is_dir($smarty->getCacheDir())) {
        mkdir($smarty->getCacheDir(), 0775, true);
    }

    return $smarty;
}
