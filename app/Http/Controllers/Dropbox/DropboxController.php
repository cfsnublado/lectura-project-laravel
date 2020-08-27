<?php

namespace App\Http\Controllers\Dropbox;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Spatie\Dropbox\Client as DbxClient;
use Spatie\Dropbox\Exceptions\BadRequest as DbxException;
use App\Http\Controllers\Controller;

class DropboxController extends Controller
{
    // Web

    /**
     * Main dropbox page to upload and retrieve files.
     */
    public function index()
    {
        return view('dropbox.index');
    }

    // API

    /**
     *
     */
    public function userFiles()
    {
        $dbxToken = config('third_party.dbx_access_token');
        $dbx = get_dbx_object($dbxToken);
        $userPath = '/' . Auth::user()->id;
        $files = get_dbx_files($dbx, $userPath);
        // Do something if empty.
        return response()->json(['files' => $files], 200);
    }


    /**
     * 
     * @param  Request  $request
     */
    public function sharedLink(Request $request)
    {
        $dbxToken = config('third_party.dbx_access_token');
        $dbx = get_dbx_object($dbxToken);
        $data = json_decode($request->getContent(), true);

        if (!array_key_exists('dbx_path', $data)) {
            abort(response()->json(['message' => 'dbx_path required'], 400));
        }

        try {
            $sharedLink = get_dbx_shared_link($dbx, $data['dbx_path']);
        } catch (DbxException $exception) {
            $response = json_decode((string) $exception->response->getBody());
            
            if ($response->error->{'.tag'} == 'shared_link_already_exists') {
                if ($response->error->shared_link_already_exists->{'.tag'} == 'metadata') {
                    return response()->json(
                        ['shared_link' => $response->error->shared_link_already_exists->metadata->url],
                        200
                    );
                }
            }

            abort(response()->json(['message' => $exception], 400));
        }

        return response()->json(['shared_link' => $sharedLink['url']], 200);
    }

    /**
     *
     */
    public function uploadFile(Request $request)
    {
        $allowedMimeTypes = [
            'text/plain', 'text/markdown',
            'application/pdf', 'audio/mpeg'
        ];
        $dbxToken = config('third_party.dbx_access_token');
        $dbx = get_dbx_object($dbxToken);
        $data = $request->file('file');
        $fileMetadata = '';
        // $mime = check_in_memory_mime($file);
        // if (!in_array($mime, $this->allowedMimeTypes)) {
        //     // Throw unsupported mime error.
        //    }

        $tmpFilepath = $request->file('file')->store('tmp');
        $dbxFilepath = '/' . Auth::user()->id . '/' . $file->name;
        $fileMetadata = upload_file_to_dbx($dbx, $tmpFilepath, $dbxFilepath);

        return response()->json(['file_metadata' => $fileMetadata], 200);
    }
}
