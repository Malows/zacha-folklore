<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  Request  $request
     * @return mixed
     */
    public function show(Request $request): mixed
    {
        $user = $request->user();

        $user->load('roles:name');

        return $user;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateProfileRequest  $request
     * @return mixed
     */
    public function update(UpdateProfileRequest $request): mixed
    {
        $user = $request->user();

        $user
            ->fill($request->all())
            ->save();

        return $user;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdatePasswordRequest  $request
     * @return mixed
     */
    public function password(UpdatePasswordRequest $request): mixed
    {
        $user = $request->user();

        $user->password = Hash::make($request->password);

        $user->save();

        return $user;
    }
}
