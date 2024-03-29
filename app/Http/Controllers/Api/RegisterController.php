<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Laravel\Passport\Client;

class RegisterController
{
    public function store(Request $request)
    {
        $this->validate($request);
        $this->createUser($request);

        return $this->authenticate($request);
    }

    protected function validate(Request $request)
    {
        return validator($request->all(), [
            'client_id' => ['required', Rule::exists(Client::class, 'id')->where('password_client', true)],
            'client_secret' => ['required', 'string'],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email:rfc,filter', 'max:255', 'unique:users'],
            'institution' => ['nullable', 'string'],
            'password' => ['required', 'string', 'min:8'],
        ])->after(function ($validator) use ($request) {
            if (isset($validator->failed()['client_id'])) {
                return;
            }

            $client = Client::find($request->client_id);

            if ($client->secret !== $request->client_secret) {
                $validator->errors()->add('client_secret', __('Client secret is not valid.'));
            }
        })->validate();
    }

    protected function createUser(Request $request)
    {
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'institution' => $request->institution,
            'password' => Hash::make($request->password),
            'settings' => [
                'language' => app()->getLocale(),
            ],
        ]);

        event(new Registered($user));
    }

    protected function authenticate(Request $request)
    {
        $client = Client::find($request->client_id);

        return app(Kernel::class)->handle(Request::create(route('passport.token'), 'POST', [
            'grant_type' => 'password',
            'client_id' => $client->id,
            'client_secret' => $client->secret,
            'username' => $request->email,
            'password' => $request->password,
            'scope' => '',
        ]));
    }
}
