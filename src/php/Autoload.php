<?php

namespace VekaServer\TableForm;

use VekaServer\Abstract\PluginAbstract;

class Autoload extends PluginAbstract
{

    protected static function getAllRequiredPlugin():array {
        return [\VekaServer\Jquery\Autoload::class, \VekaServer\Popin\Autoload::class];
    }

    protected static function getCSS():array {
        return [dirname(__DIR__).DIRECTORY_SEPARATOR.'css'];
    }

    protected static function getJS():array {
        return [dirname(__DIR__).DIRECTORY_SEPARATOR.'js'];
    }

    protected static function getVIEW():array {
        return [ 'TableForm' => dirname(__DIR__).DIRECTORY_SEPARATOR.'view'];
    }

}
