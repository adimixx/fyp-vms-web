<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $roleFormatMap = function ($val) {
            return [
                'value' => $val['id'],
                'label' => ucfirst($val['name'])
            ];
        };
        $rolesList = json_encode(array_map($roleFormatMap, Role::all()->toArray()));

        return view('user.index', compact('rolesList'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
