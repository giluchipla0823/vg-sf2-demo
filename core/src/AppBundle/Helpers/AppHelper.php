<?php


namespace AppBundle\Helpers;


class AppHelper
{
    public static function getContainerBuilder(){
        global $kernel;

        return $kernel->getContainer();
    }

    public static function getIncludesToSerializer($relations){
        $container = self::getContainerBuilder();
        $request = $container->get('request');

        $output = array('Default');
        $includes = $request->get('includes');

        if($includes){

            $includes = explode(',', $includes);

            foreach ($includes as $include){
                if(in_array($include, $relations)){
                    $output[] = $include;
                }
            }
        }

        return $output;
    }
}