<?php

if (!function_exists('is_xss_attempt')) {
    function is_xss_attempt($input)
    {
        if (!is_string($input) && !is_array($input)) {
            return false;
        }

        // Normalize: ubah string ke lowercase supaya pattern lebih mudah
        $raw = is_array($input) ? json_encode($input) : $input;
        $raw_lower = strtolower($raw);

        // 1. Deteksi script tag
        $patterns[] = '/<\s*script.*?>/i';

        // 2. Deteksi event handler: onload=, onerror=, onclick=, dll
        $patterns[] = '/on\w+\s*=\s*/i';

        // 3. Deteksi javascript: atau data: URLs
        $patterns[] = '/(javascript:|data:text\/html)/i';

        // 4. Deteksi XSS berbasis SVG (paling sering lolos)
        $patterns[] = '/<\s*svg[^>]*>/i';
        $patterns[] = '/<\s*svg\/onload/i';

        // 5. Deteksi XSS pada img tag
        $patterns[] = '/<\s*img[^>]*onerror\s*=\s*/i';

        // 6. Deteksi iframe, embed, object
        $patterns[] = '/<(iframe|embed|object|base)[^>]*>/i';

        // 7. Deteksi XSS dengan HTML entities, hex, unicode encoding
        $encoded_patterns[] = '/&#x?[0-9a-f]+;?/i';       // hex encoded
        $encoded_patterns[] = '/\\\u[0-9a-f]{4}/i';        // unicode \u003c
        $encoded_patterns[] = '/%3c|%3e|%27|%22|%3b/i';    // URL encoded

        // 8. Deteksi payload XSS polyglot modern
        $patterns[] = '/<\s*\/script\s*>/i';
        $patterns[] = '/<\s*style[^>]*>.*expression\(/i';  // CSS expression

        // 9. Deteksi eval() / Function() (bahaya)
        $patterns[] = '/eval\s*\(/i';
        $patterns[] = '/new\s+function/i';

        // === eksekusi regex ===
        foreach ($patterns as $p) {
            if (preg_match($p, $raw_lower)) {
                return true;
            }
        }

        foreach ($encoded_patterns as $p) {
            if (preg_match($p, $raw_lower)) {
                return true;
            }
        }

        return false;
    }
}
