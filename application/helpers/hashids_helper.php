<?php

use Hashids\Hashids;

if (!function_exists('hashids_encode')) {
    function hashids_encode($text)
    {
        $hashids = new Hashids('your-secret-key', 10);
        return $hashids->encodeHex(bin2hex($text));
    }
}

if (!function_exists('hashids_decode')) {
    function hashids_decode($encoded)
    {
        $hashids = new Hashids('your-secret-key', 10);
        $hex = $hashids->decodeHex($encoded);
        return hex2bin($hex);
    }
}
