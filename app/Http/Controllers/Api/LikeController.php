<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Link;
use App\Models\Like;

class LikeController extends Controller
{
    public function store(Request $request, $linkId)
    {
        $user = Auth::user();
        $link = Link::findOrFail($linkId);

        if ($link->likes()->where('user_id', $user->id)->exists()) {
            return response()->json(['message' => 'You have already liked this link'], 409);
        }

        $user->like($link);

        return response()->json(['message' => 'Link liked successfully'], 200);
    }
}
