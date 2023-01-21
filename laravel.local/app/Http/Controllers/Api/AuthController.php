<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\UserRegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\UserChangeRequest;
use App\Http\Requests\UserLoginRequest;


class AuthController extends Controller
{

    public function createUser(UserRegisterRequest $request): JsonResponse
    {
        try {
            $request->validated();

            $user = User::create([
                'name' => $request->name,
                'surname' => $request->surname,
                'password' => Hash::make($request->password),
                'login' => $request->login
            ]);

            return response()->json([
                'status' => true,
                'message' => 'User Created Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);

        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }


    public function loginUser(UserLoginRequest $request): JsonResponse
    {
        try {
            $request->validated();


            if(!Auth::attempt($request->only(['login', 'password', 'name', 'surname']))){
                return response()->json([
                    'status' => false,
                    'message' => 'Login & Password does not match with our record.',
                ], 401);
            }

            $user = User::where('login', $request->login)->first();

            return response()->json([
                'status' => true,
                'message' => 'User Logged In Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);

        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function logoutUser(Request $request): JsonResponse
    {
        $user = auth()->user();
        if ($user != null && $user instanceof User) {
            $user->tokens()->delete();
        }
        return response()->json(['message' => 'Logged out successfully']);
    }


    public function changeUserData(UserChangeRequest $request): JsonResponse
    {
        $user = $request->user();
        $request = $request->validated();

        if (!Hash::check($request['old_password'], $user->getAuthPassword())){
            return response()->json(['error' => 'Current password does not match']);
        }

        $user->update([
            'name' => $request['new_name'],
            'surname' => $request['new_surname'],
            'password' => Hash::make($request['new_password']),
        ]);
        $user->refresh();

        return response()->json(['message' => 'Data update successfully']);
    }

    function showUser (Request $request): JsonResponse
    {
        $user = $request->user();
        return response()->json([
            'name' => $user->name,
            'surname' => $user->surname,
            'login' => $user->login,
        ]);
    }
}
