<?php

if (!function_exists('Str'))
{
    /**
     * Shortcut to get string helper instance
     *
     * @param string $string
     *
     * @return \Zver\StringHelper
     */
    function Str($string = '')
    {
        return \Zver\StringHelper::load($string);
    }
}