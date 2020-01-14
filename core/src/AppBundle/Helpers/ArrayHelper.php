<?php


namespace AppBundle\Helpers;


class ArrayHelper
{
    /**
     * Excluir elementos de un array
     *
     * @param array $array
     * @param array $exceptKeys
     * @return array
     */
    public static function exceptItems(array $array, array $exceptKeys) {
        return array_diff_key($array, array_flip($exceptKeys));
    }

    /**
     * Mostrar solo los items especificados
     *
     * @param array $array
     * @param array $includeKeys
     * @return array
     */
    public static function onlyItems(array $array, array $includeKeys) {
        $output = array();

        foreach ($array as $key => $value){
            if(in_array($key, $includeKeys)){
                $output[$key] = $value;
            }
        }

        return $output;
    }
}