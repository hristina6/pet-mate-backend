<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(LoginRequest $request): JsonResource
    {
        $user = User::query()
            ->firstWhere('email', $request->get('email'));

        if (! $user || ! Hash::check($request->get('password'), $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken('token')->plainTextToken;

        return JsonResource::make($user)->additional(['token' => $token]);
    }

    public function register(RegisterRequest $request): JsonResource
    {
        $data = $request->validated();
        $data['password'] = bcrypt($data['password']);
        $user = User::query()->create($data);

        event(new Registered($user));

        $token = $user->createToken('token')->plainTextToken;

        return JsonResource::make($user)->additional(['token' => $token]);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['success' => true]);
    }
}
