<?php

namespace App\Actions\Fortify;

use App\Models\Status;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    private function uniqueUserVal($query, $request)
    {
        if ($request->input('id')) {
        }

        return $query;
    }

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'id' => 'required',
            'staff_no' => 'required',
            'nric' => 'required',
            'email' => [
                'required', 'string', 'email', 'max:255', Rule::unique(User::class)->where(fn ($query) => $query->where('id', '!=', $input['id']))
            ],
            'password' => $this->passwordRules()
        ])->validate();

        $user = User::where('id', $input['id'])->where('staff_no', $input['staff_no'])->where('nric', $input['nric'])->where('status_id', Status::user('pending registration')->id)?->first();

        if (!$user) {
            return response(['message' => 'Invalid Staff Credentials. Please Contact Admin'], 500);
        }

        $user->update([
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'name' => $input['email'],
            'status_id' => Status::user('pending activation')->id
        ]);

        return $user;
    }
}
