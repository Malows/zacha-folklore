<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  Request  $request
     *
     * @return mixed
     */
    public function show(Request $request): mixed
    {
        return $request->user();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateUserRequest  $request
     *
     * @return mixed
     */
    public function update(UpdateUserRequest $request): mixed
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
     *
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
