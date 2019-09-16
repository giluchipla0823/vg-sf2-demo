<?php


namespace AppBundle\Helpers;


class AppHelper
{
    public static function getContainerBuilder(){
        global $kernel;

        return $kernel->getContainer();
    }
}