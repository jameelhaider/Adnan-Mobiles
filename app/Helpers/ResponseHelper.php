<?php

function formatNumber($number)
{
    if ($number >= 1000 && $number < 1000000) {
        return number_format($number / 1000, 1) . 'k';
    } elseif ($number >= 1000000) {
        return number_format($number / 1000000, 1) . 'M';
    } else {
        return $number;
    }
}

function numberToWords($number)
{
    $f = new \NumberFormatter('en', \NumberFormatter::SPELLOUT);
    return ucfirst($f->format($number));
}

