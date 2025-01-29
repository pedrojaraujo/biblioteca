<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use Smarty\Smarty;

function getSmarty()
{
    $smarty = new Smarty();
    
    // Caminhos absolutos para os diretórios do Smarty
    $baseDir = __DIR__ . '/..';
    
    $smarty->setTemplateDir($baseDir . '/views/templates/');
    $smarty->setCompileDir($baseDir . '/views/templates_c/');
    $smarty->setCacheDir($baseDir . '/views/cache/');
    $smarty->setConfigDir($baseDir . '/views/configs/');

    // Configurações de debug
    $smarty->debugging = true;
    $smarty->caching = false;
    $smarty->force_compile = true;

    // Debug
    error_log("Smarty template dir: " . print_r($smarty->getTemplateDir(), true));
    error_log("Smarty compile dir: " . $smarty->getCompileDir());
    error_log("Smarty cache dir: " . $smarty->getCacheDir());
    error_log("Smarty config dir: " . print_r($smarty->getConfigDir(), true));
    
    return $smarty;
}
