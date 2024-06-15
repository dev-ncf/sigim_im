<?php

if (!function_exists('truncate_name')) {
    function truncate_name($name)
    {
        $words = explode(' ', $name);
        if (count($words) > 3) {
            return implode(' ', array_slice($words, 0, 3)) . '...';
        }
        return $name;
    }
}
