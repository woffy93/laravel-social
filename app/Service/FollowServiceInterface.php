<?php

namespace App\Service;

use App\Models\User;

interface FollowServiceInterface
{
    public function follow(User $targetUser);
    public function unfollow(User $targetUser);

}
