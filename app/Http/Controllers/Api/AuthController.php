<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\StudentResource;
use App\Http\Resources\AdminResource;
use App\Models\Student;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Student login
     */
    public function studentLogin(Request $request): JsonResponse
    {
        $request->validate([
            'nim' => 'required|string',
            'password' => 'required|string',
        ]);

        $student = Student::where('nim', $request->nim)->first();

        if (!$student || !Hash::check($request->password, $student->password)) {
            throw ValidationException::withMessages([
                'nim' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $student->createToken('student-token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'data' => [
                'user' => new StudentResource($student),
                'token' => $token,
                'token_type' => 'Bearer'
            ],
            'meta' => [
                'timestamp' => now()->toISOString(),
                'version' => 'v1'
            ]
        ]);
    }

    /**
     * Student register
     */
    public function studentRegister(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nim' => 'required|string|unique:students,nim',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:students,email',
            'password' => 'required|string|min:8|confirmed',
            'major' => 'required|string|max:255',
            'semester' => 'required|string|max:10',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $student = Student::create($validated);
        $token = $student->createToken('student-token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Registration successful',
            'data' => [
                'user' => new StudentResource($student),
                'token' => $token,
                'token_type' => 'Bearer'
            ],
            'meta' => [
                'timestamp' => now()->toISOString(),
                'version' => 'v1'
            ]
        ], 201);
    }

    /**
     * Admin login
     */
    public function adminLogin(Request $request): JsonResponse
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $admin = Admin::where('username', $request->username)->first();

        if (!$admin || !Hash::check($request->password, $admin->password)) {
            throw ValidationException::withMessages([
                'username' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $admin->createToken('admin-token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'data' => [
                'user' => new AdminResource($admin),
                'token' => $token,
                'token_type' => 'Bearer'
            ],
            'meta' => [
                'timestamp' => now()->toISOString(),
                'version' => 'v1'
            ]
        ]);
    }

    /**
     * Logout (revoke token)
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logout successful',
            'data' => null,
            'meta' => [
                'timestamp' => now()->toISOString(),
                'version' => 'v1'
            ]
        ]);
    }

    /**
     * Get authenticated user
     */
    public function me(Request $request): JsonResponse
    {
        $user = $request->user();
        
        if ($user instanceof Student) {
            $resource = new StudentResource($user);
        } elseif ($user instanceof Admin) {
            $resource = new AdminResource($user);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'User type not recognized',
                'data' => null,
                'meta' => [
                    'timestamp' => now()->toISOString(),
                    'version' => 'v1'
                ]
            ], 400);
        }

        return response()->json([
            'success' => true,
            'message' => 'User data retrieved successfully',
            'data' => $resource,
            'meta' => [
                'timestamp' => now()->toISOString(),
                'version' => 'v1'
            ]
        ]);
    }
}