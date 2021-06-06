<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use phpDocumentor\Reflection\Types\Boolean;

class FileControllerAPI extends Controller
{
    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'file' => 'required|file|mimetypes:image/jpeg,image/png,video/mp4'
        ]);
        $validated = (object) $validate->validate();

        $content = file_get_contents($validated->file->getRealPath());
        $tempName = sprintf('temp/%s.%s', time(), $validated->file->extension());

        $upload = Storage::disk('local')->put($tempName, $content);

        if ($upload) {
            return response(basename($tempName))->withHeaders([
                'Content-Type' => 'text/plain'
            ]);
        }

        return response(status: 500);
    }

    public function show($id)
    {
        //
    }

    public function destroy($id)
    {
        if (FileControllerAPI::destroyTempFile($id)){
            return response(['message' => 'File successfully deleted']);
        }

        return response(['message' => 'File not found'], status: 500);
    }

    public static function destroyTempFile($filename)
    {
        $tempName = sprintf('temp/%s', $filename);
        $content = Storage::disk('local')->exists($tempName);

        if ($content) {
            Storage::disk('local')->delete($tempName);
            return true;
        }

        return false;
    }
}
