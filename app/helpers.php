<?php

use Illuminate\Support\Facades\Storage;

if (! function_exists('build_parsed_url')) {
    /**
     * A "reverse" parse_url.
     */
    function build_parsed_url(array $parts)
    {
        $scheme = isset($parts['scheme']) ? ($parts['scheme'] . '://') : '';
        $host = $parts['host'] ?? '';
        $port = isset($parts['port']) ? (':' . $parts['port']) : '';
        $user = $parts['user'] ?? '';
        $pass = isset($parts['pass']) ? (':' . $parts['pass'])  : '';
        $pass = ($user || $pass) ? ($pass . '@') : '';
        $path = $parts['path'] ?? '';
        $query = empty($parts['query']) ? '' : ('?' . $parts['query']);
        $fragment = empty($parts['fragment']) ? '' : ('#' . $parts['fragment']);

        return implode('', [$scheme, $user, $pass, $host, $port, $path, $query, $fragment]);
    }
}
