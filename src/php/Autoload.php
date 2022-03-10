<?php

namespace VekaServer\TableForm;

use VekaServer\Interfaces\PluginInterface;

class Autoload implements PluginInterface
{

    public static function getPathView(){
        return [ 'TableForm' => dirname(__DIR__).DIRECTORY_SEPARATOR.'view'];
    }

    public static function getPathJS(){
        return dirname(__DIR__).DIRECTORY_SEPARATOR.'js';
    }

    public static function getPathCSS(){
        return dirname(__DIR__).DIRECTORY_SEPARATOR.'css';
    }

}
