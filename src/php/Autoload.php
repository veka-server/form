<?php

namespace VekaServer\TableForm;

use VekaServer\Interfaces\PluginInterface;

class Autoload implements PluginInterface
{

    public static function getPathView():array {
        return [ 'TableForm' => dirname(__DIR__).DIRECTORY_SEPARATOR.'view'];
    }

    public static function getPathJS():string {
        return dirname(__DIR__).DIRECTORY_SEPARATOR.'js';
    }

    public static function getPathCSS():string {
        return dirname(__DIR__).DIRECTORY_SEPARATOR.'css';
    }

}
