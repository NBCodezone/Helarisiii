<?php

if (!function_exists('format_currency')) {
    /**
     * Format a number as Japanese Yen currency
     *
     * @param float $amount
     * @param int $decimals
     * @return string
     */
    function format_currency($amount, $decimals = 2)
    {
        return '¥' . number_format($amount, $decimals);
    }
}

if (!function_exists('currency_symbol')) {
    /**
     * Get the currency symbol
     *
     * @return string
     */
    function currency_symbol()
    {
        return '¥';
    }
}
