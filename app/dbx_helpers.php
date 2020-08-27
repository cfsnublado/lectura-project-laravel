<?php

use Spatie\Dropbox\Client as DbxClient;
use Spatie\Dropbox\Exceptions\BadRequest as DbxException;


/**
 *
 */
function get_dbx_object($dbxToken)
{
    $dbx = new DbxClient($dbxToken);

    return $dbx;
}

/**
 * Get url of shared link.
 */
function get_dbx_shared_link(DbxClient $dbx, $path)
{
    $sharedLinkUrl = '';

    try {
        $sharedLink = $dbx->createSharedLinkWithSettings($path);
        $sharedLinkUrl = $sharedLink['url'];
    } catch (DbxException $exception) {
        $response = json_decode((string) $exception->response->getBody());
        if ($response->error->{'.tag'} == 'shared_link_already_exists') {

            if ($response->error->shared_link_already_exists->{'.tag'} == 'metadata') {
                $sharedLinkUrl = $response->error->shared_link_already_exists->metadata->url;
            } else {
                abort(response()->json(['message' => $exception], 400));
            }
        }
    }

    return $sharedLinkUrl;
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
function upload_to_dbx(DbxClient $dbx, $localFilepath, $dbxFilepath)
{
    $fileMetadata = [];

    if (Storage::exists($localFilepath)) {
        $contents = Storage::get($localFilepath);
        $fileMetadata = $dbx->upload($dbxFilepath, $contents, 'overwrite');
    }

    return $fileMetadata;
}

/**
 *
 */
function delete_from_dbx(DbxClient $dbx, $dbxFilepath)
{
    $fileMetadata = $dbx->delete($dbxFilepath);

    return $fileMetadata;
}
