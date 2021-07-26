<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DatatableBackendController extends Controller
{
    public static function returnData($data, $request)
    {
        if ($request->has('ascending') && $request->input('orderBy')) {
            $data = $data->orderBy($request->input('orderBy'), ($request->input('ascending') == 1) ? 'ASC' : 'DESC');
        }

        return $data->jsonPaginate();
    }
}
