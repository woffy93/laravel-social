<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Service\FollowServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    public function __construct(
        private FollowServiceInterface $followService
    )
    {
    }


    public function index(Request $request)
    {
        $user = Auth::user();
        $followers = $user->followers()->paginate(10);

        $followers->load('follower');

        return response()->json($followers);
    }

    public function followByEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = Auth::user();
        $targetUser = User::where('email', $request->email)->first();

        if (!$targetUser) {
            return response()->json(['message' => 'User not found'], 404);
        }

        if ($targetUser->followers()->where('follower_id', $user->id)->exists()) {
            return response()->json(['message' => 'You are already following this user'], 409);
        }

        $this->followService->follow($targetUser);

        return response()->json(['message' => 'Successfully followed the user'], 200);
    }
}
