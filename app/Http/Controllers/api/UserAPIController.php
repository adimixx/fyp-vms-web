<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Status;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use PDO;

class UserAPIController extends Controller
{
    private function uniqueUserVal($query, $request)
    {
        if ($request->input('id')) {
            $query = $query->where('id', '!=', $request->input('id'));
        }

        return $query;
    }

    public function store(Request $request)
    {
        $validated = (object) Validator::make($request->all(), [
            'id' => [Rule::exists('users')],
            'staff_no' => ['required', Rule::unique('users')->where(fn ($query) => $this->uniqueUserVal($query, $request))],
            'nric' => ['required','max:12',Rule::unique('users')->where(fn ($query) => $this->uniqueUserVal($query, $request))],
            'roles' => 'required',
            'roles.*' => 'exists:roles,id',
            'email' => ['nullable', Rule::unique('users')->where(fn ($query) => $this->uniqueUserVal($query, $request))],
            'name' => 'nullable'
        ])->validate();

        $data = [
            'email' => $validated->email ?? null,
            'name' => $validated->name ?? null,
            'nric' => $validated->nric,
            'staff_no' => $validated->staff_no,
            'phone' => $validated->phone ?? null
        ];

        if (!isset($validated->id)) {
            $data = array_merge([
                'status_id' => Status::user('pending registration')->id
            ], $data);

            $user = User::create($data);
            $user->assignRole($validated->roles);
        } else {
            $user = User::find($validated->id)->update($data);
        }

        return $user;
    }

    public function destroy($id, Request $request)
    {
        $user = User::find($id);

        if (!isset($user)) {
            return response(["message" => "invalid user"], status: 500);
        } else if ($user == $request->user()) {
            return response(["message" => "cannot self delete user"], status: 500);
        }

        $user->delete();

        return response(status: 200);
    }


    public function verifyUser(Request $request)
    {
        $validated = (object) Validator::make($request->all(), [
            'staff_no' => ['required',],
            'nric' => ['required', 'max:12', 'min:12']
        ])->validate();

        $user = User::where('staff_no', $validated->staff_no)->where('nric', $validated->nric)?->first();

        if (!$user) {
            return response(['message' => 'Invalid Staff Credentials. Please Contact Admin'], 500);
        } else if ($user->status->name != 'pending registration') {
            return response(['message' => 'You have registered your account. Please log in with your credentials'], 500);
        }
        return $user;
    }
}
