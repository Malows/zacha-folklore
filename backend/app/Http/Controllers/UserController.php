<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Collection<int, User>
     */
    public function index()
    {
        return User::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreUserRequest  $request
     * @return User
     */
    public function store(StoreUserRequest $request): User
    {
        $user = new User($request->all());

        $user->password = Hash::make($request->password);

        $user->save();

        return $user;
    }

    /**
     * Display the specified resource.
     *
     * @param  User  $user
     * @return User
     */
    public function show(User $user): User
    {
        return $user;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateUserRequest  $request
     * @param  User  $user
     * @return User
     */
    public function update(UpdateUserRequest $request, User $user): User
    {
        $user
            ->fill($request->all())
            ->save();

        return $user;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User  $user
     * @return User
     */
    public function destroy(User $user): User
    {
        $user->delete();

        return $user;
    }
}
