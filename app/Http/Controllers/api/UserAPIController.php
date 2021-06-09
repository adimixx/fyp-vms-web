<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserAPIController extends Controller
{
    public function store(Request $request)
    {
        $uniqueUserVal = function ($query, $request) {
            if ($request->input('id')) {
                $query = $query->where('id', '!=', $request->input('id'));
            }

            return $query;
        };

        $validated = (object) Validator::make($request->all(), [
            'id' => [Rule::exists('users')],
            'name' => 'required',
            'staff_no' => ['required', Rule::unique('users')->where(fn ($query) => $uniqueUserVal($query, $request))],
            'nric' => ['required', Rule::unique('users')->where(fn ($query) => $uniqueUserVal($query, $request))],
            'email' => ['required', Rule::unique('users')->where(fn ($query) => $uniqueUserVal($query, $request))],
            'password' => 'required_if:id,null|min:8|confirmed',
            'roles' => 'required_if:id,null|exclude_unless:id,null|array',
            'roles.*' => 'exists:roles,id'
        ])->validate();

        $data = [
            'email' => $validated->email,
            'name' => $validated->name,
            'nric' => $validated->nric,
            'staff_no' => $validated->staff_no,
            'phone' => $validated->phone ?? null
        ];

        if (!isset($validated->id)){
            $data = array_merge([
                'password' => Hash::make($validated->password)
            ], $data);

            $user = User::create($data);
            $user->assignRole($validated->roles);
        }
        else{
            $user = User::find($validated->id)->update($data);
        }

        return $user;
    }
}
