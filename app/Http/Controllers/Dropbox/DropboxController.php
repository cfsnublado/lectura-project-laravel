<?php

namespace App\Http\Controllers\Dropbox;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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
        $data = json_decode($request->getContent(), true);

        if (!array_key_exists('dbx_path', $data)) {
            abort(response()->json(['message' => 'dbx_path required'], 400));
        }

        $dbxToken = config('third_party.dbx_access_token');
        $dbx = get_dbx_object($dbxToken);
        $sharedLink = get_dbx_shared_link($dbx, $data['dbx_path']);

        return response()->json(['shared_link' => $sharedLink], 200);
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

        $file = $request->file('file');
        $mimeType = $file->getClientMimeType();

        if (!in_array($mimeType, $allowedMimeTypes)) {
            abort(response()->json(['message' => 'Invalid mimetype'], 400));
        }

        $dbxToken = config('third_party.dbx_access_token');
        $dbx = get_dbx_object($dbxToken);
        $tmpFilepath = $file->store('tmp');
        $dbxFilepath = '/' . Auth::user()->id . '/' . $file->getClientOriginalName();
        $fileMetadata = upload_file_to_dbx($dbx, $tmpFilepath, $dbxFilepath);

        return response()->json(['file_metadata' => $fileMetadata], 200);
    }
}
