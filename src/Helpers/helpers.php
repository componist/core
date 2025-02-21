<?php

use Componist\Core\Facades\Component;

if (! function_exists('setting')) {
    function setting($key)
    {
        return Component::setting($key);
    }
}

if (! function_exists('menu')) {
    /**
     * get menu by name with childrens
     *
     * @return Component
     */
    function menu(string $menuName, ?string $type = null)
    {
        return Component::model('Menu')->display($menuName, $type);
    }
}

if (! function_exists('HTML_Minifier')) {
    function HTML_Minifier($string){
        $string = preg_replace('/\s+/', ' ', $string);
        $string = preg_replace('/\t+/', '', $string);
        $string = preg_replace('/\r+/', '', $string);
        $string = preg_replace('/\n+/', '', $string);
        return $string;
    }
}

if (! function_exists('test')) {
    function test($text)
    {
        return $text;
    }
}