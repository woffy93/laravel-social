<?php

namespace App\Service;

use App\Models\User;
use App\Notifications\NewFollowerNotification;
use Illuminate\Support\Facades\Auth;

class FollowService implements FollowServiceInterface
{

    public function follow(User $targetUser)
    {
        $user = Auth::user();
        $user->follow($targetUser);
        $targetUser->notify(new NewFollowerNotification($user));
    }

    public function unfollow(User $targetUser)
    {
        Auth::user()->unfollow($targetUser);
    }
}
