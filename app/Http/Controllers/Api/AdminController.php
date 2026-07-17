<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Unit;
use App\Models\UnitRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AdminController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['ÈíÇäÇÊ ÇáÏÎæá ÛíÑ ÕÍíÍÉ'],
            ]);
        }
        if (!$user->hasAnyRole(['Admin', 'Manager', 'admin', 'manager'])) {
            return response()->json(['message' => 'áíÓ áÏíß ÕáÇÍíÉ ÇáÏÎæá'], 403);
        }
        $user->tokens()->delete();
        $token = $user->createToken('admin-token')->plainTextToken;
        return response()->json([
            'user' => ['id' => $user->id, 'name' => $user->name, 'email' => $user->email, 'role' => $user->getRoleNames()->first() ?? 'Admin'],
            'token' => $token,
            'message' => 'Êã ÊÓÌíá ÇáÏÎæá ÈäÌÇÍ'
        ]);
    }
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Êã ÊÓÌíá ÇáÎÑæÌ ÈäÌÇÍ']);
    }
    public function stats(Request $request)
    {
        return response()->json([
            'users_count' => User::count(),
            'units_count' => Unit::count(),
            'requests_count' => UnitRequest::count(),
            'pending_requests' => UnitRequest::where('status', 'pending')->count(),
        ]);
    }
    public function me(Request $request)
    {
        $user = $request->user();
        return response()->json(['user' => ['id' => $user->id, 'name' => $user->name, 'email' => $user->email, 'role' => $user->getRoleNames()->first() ?? 'Admin']]);
    }
}
