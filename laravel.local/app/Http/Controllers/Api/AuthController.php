<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{

    public function createUser(Request $request): JsonResponse
    {
        try {
            $validateUser = Validator::make($request->all(),
                [
                    'name' => 'required|min:3',
                    'surname' => 'required|string|min:3',
                    'password' => 'required|string|min:8',
                    'login' => 'required|string|min:6',
                ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

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


    public function loginUser(Request $request): JsonResponse
    {
        try {
            $validateUser = Validator::make($request->all(),
                [
                    'login' => 'required',
                    'password' => 'required'
                ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

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
        if ($user !== null && $user instanceof \App\Models\User) {
            $user->tokens()->delete();
        }
        return response()->json(['message' => 'Logged out successfully']);
    }


    public function changeUserData(Request $request): JsonResponse
    {
        $request->validate([
            'new_name' => 'required|min:3',
            'new_surname' => 'required|string|min:3',
            'old_password' => 'required|string|min:8',
            'new_password' => 'required|string|min:8',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->old_password, $user->getAuthPassword())){
            return response()->json(['error' => 'Current password does not match']);
        }

        $user->update()([
            'name' => $request->new_name,
            'surname' => $request->new_surname,
            'password' => Hash::make($request->new_password),
        ]);
        $user->refresh();

        return response()->json(['message' => 'Data update successfully']);
    }
}
