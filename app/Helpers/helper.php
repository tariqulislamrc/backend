<?php

if (! function_exists('gv')){
    function gv($params, $key, $default = null) {
        return (isset($params[$key]) && $params[$key]) ? $params[$key] : $default;
    }
}
