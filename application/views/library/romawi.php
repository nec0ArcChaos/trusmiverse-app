<?php

function romawi($bln)
{
    $romawi = '';
    switch ($bln) {
        case "01":
            $romawi = 'I';
            break;
        case "02":
            $romawi = 'II';
            break;
        case "03":
            $romawi = 'III';
            break;
        case "04":
            $romawi = 'IV';
            break;
        case "05":
            $romawi = 'V';
            break;
        case "06":
            $romawi = 'VI';
            break;
        case "07":
            $romawi = 'VII';
            break;
        case "08":
            $romawi = 'VIII';
            break;
        case "09":
            $romawi = 'IX';
            break;
        case "10":
            $romawi = 'X';
            break;
        case "11":
            $romawi = 'XI';
            break;
        case "12":
            $romawi = 'XII';
            break;
        default:
            $romawi = '-';
    }
    return $romawi;
}
