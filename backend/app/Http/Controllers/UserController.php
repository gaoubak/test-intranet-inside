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
    /**
     * @OA\Get(
     *     path="/users",
     *     summary="Get list of users",
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="position_held",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="user_service",
     *         in="query",
     *         required=false,
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *     )
     * )
     */
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

    /**
     * @OA\Get(
     *     path="/users/{user}",
     *     summary="Get a user by ID",
     *     @OA\Parameter(
     *         name="user",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found"
     *     )
     * )
     */
    public function show(User $user): UserResource
    {
        $user->load('services');

        return UserResource::make($user);
    }

    /**
     * @OA\Put(
     *     path="/users/{user}",
     *     summary="Update a user by ID",
     *     @OA\Parameter(
     *         name="user",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found"
     *     )
     * )
     */
    public function update(User $user, updateUserRequest $request): UserResource
    {
        $validated = $request->validated();

        $user->update($validated);

        return UserResource::make($user);
    }

    /**
     * @OA\Delete(
     *     path="/users/{user}",
     *     summary="Delete a user by ID",
     *     @OA\Parameter(
     *         name="user",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Successful operation"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found"
     *     )
     * )
     */
    public function destroy(User $user): Response
    {
        $user->delete();

        return response()->noContent();
    }
}
