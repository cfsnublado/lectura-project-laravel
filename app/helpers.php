<?php
use Spatie\Dropbox\Client as DbxClient;

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

/**
 *
 */
function get_dbx_object($dbxToken)
{
    $dbx = new DbxClient($dbxToken);

    return $dbx;
}

/**
 *
 */
function get_dbx_shared_link(DbxClient $dbx, $path)
{
    $sharedLink = $dbx->createSharedLinkWithSettings($path);

    return $sharedLink;
}

/**
 * For relative paths, prepend /, (e.g., '/subfolder').
 */
function get_dbx_files(DbxClient $dbx, $path)
{
    $files = $dbx->listFolder($path);
    return $files['entries'];
}

/**
 *
 */
function upload_file_to_dbx(DbxClient $dbx, $localFilepath, $dbxFilepath)
{
    $file = fopen($localFilepath, 'rb');
    $fileMetadata = [];
    if ($file) {
        $contents = fread($file);
        $fileMetadata = $dbx->upload($dbxFilepath, $contents, 'overwrite');
        fclose($file);
    }

    return $fileMetadata;
}

