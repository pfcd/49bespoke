<?php

if (!function_exists('dipi_log')) {
    function dipi_log(...$args)
    {
        if (!defined('DIPI_DEBUG_LOG') || constant('DIPI_DEBUG_LOG') !== true || empty($args)) {
            return;
        }
        dipi_log_internal('Log', ...$args);
    }
}

if (!function_exists('dipi_info')) {
    function dipi_info(...$args)
    {
        if (!defined('DIPI_DEBUG_LOG') || constant('DIPI_DEBUG_LOG') !== true || empty($args)) {
            return;
        }
        dipi_log_internal('Info', ...$args);
    }
}

if (!function_exists('dipi_err')) {
    function dipi_err(...$args)
    {
        if (!defined('DIPI_DEBUG_LOG') || constant('DIPI_DEBUG_LOG') !== true || empty($args)) {
            return;
        }
        dipi_log_internal('Error', ...$args);
    }
}

if (!function_exists('dipi_log_internal')) {
    function dipi_log_internal(...$args)
    {
        if (!defined('DIPI_DEBUG_LOG') || constant('DIPI_DEBUG_LOG') !== true || empty($args)) {
            return;
        }

        $prefix = $args[0];

        foreach (array_slice($args, 1) as $arg) {
            if (is_array($arg) || is_object($arg)) {
                error_log("Divi Pixel $prefix: " . print_r($arg, true));
            } else {
                error_log("Divi Pixel $prefix: " . $arg);
            }
        }
    }
}