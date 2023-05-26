<?php

if (! function_exists('dateFormat')) {
    function dateFormat($date = '', $format = '/')
    {
        if ($date) {
            $date = implode($format, array_reverse(explode('-', $date)));
        }

        return $date;
    }
}
