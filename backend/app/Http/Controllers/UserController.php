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
        $page = request()->page;
        $position_held = request()->position_held;
        $user_service = request()->user_service;

        $users = User::query()->with('services');

        if (isset($page)) {
            if (isset($position_held)) {
                $users = $users->where('position_held', $position_held);
            }

            if (isset($user_service)) {
                $users = $users->whereRelation('services', 'name', '=', $user_service);
            }

            return UserResource::collection($users->paginate(10));
        }
  
        if (isset($position_held)) {
            $users = $users->where('position_held', $position_held);
        }

        if (isset($user_service)) {
            $users = $users->whereRelation('services', 'name', '=', $user_service);
        }

        return UserResource::collection($users->get());
    }

    public function show(User $user): UserResource
    {
        $user->load('services');

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
