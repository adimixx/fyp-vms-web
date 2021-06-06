<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Bayfront\MimeTypes\MimeType;

class ComplaintController extends Controller
{
    public function index()
    {
        return view('complaint.index');
    }

    public function create()
    {
        return view('complaint.create');
    }

    public function show($id)
    {
        $complaint = Complaint::find($id);

        $mapImgUrl = function ($v) {
            $filetype = strstr(MimeType::fromFile($v), '/', true);
            if ($filetype == "image") {
                return [
                    'type' => $filetype,
                    'thumb' => Storage::disk('azure_complaints')->url($v),
                    'src' => Storage::disk('azure_complaints')->url($v)
                ];
            } else {
                return [
                    'type' => $filetype,
                    'sources' => [
                        [
                            'src' => Storage::disk('azure_complaints')->url($v),
                            'type' => MimeType::fromFile($v)
                        ]
                    ],
                    "autoplay" => true
                ];
            }
        };

        $imgLinks = json_encode(array_map($mapImgUrl, $complaint->media));
        // dd($imgLinks);


        return view('complaint.show', compact('complaint', 'imgLinks'));
    }

    public function edit($id)
    {
        //
    }
}
