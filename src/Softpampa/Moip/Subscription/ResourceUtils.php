<?php namespace Softpampa\Moip\Subscription;

/**
 * Class ResourceUtils
 * @package Softpampa\Moip\Subscription
 */
trait ResourceUtils {

    /**
     * Compiles a string with markup into an interpolation
     *
     * @param $content
     * @param array $data
     * @return mixed
     */
    protected function interpolate($content, array $data = []){

        foreach($data as $key=>$value){
            $content = str_replace('{'.$key.'}', $value, $content);
        }

        return $content;
    }
}