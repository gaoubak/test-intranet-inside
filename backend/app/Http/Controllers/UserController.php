<?php

namespace App\Http\Controllers;

use App\Http\Requests\updateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return UserResource::collection(User::all());
    }

    public function show(User $user): UserResource
    {
        return UserResource::make($user);
    }

    public function update(User $user, updateUserRequest $request): UserResource
    {
        $validated = $request->validated();

        $user->update($validated);

        return UserResource::make($user);
    }

    public function destroy(User $user): Response
    {
        $user->delete();

        return response()->noContent();
    }
}
