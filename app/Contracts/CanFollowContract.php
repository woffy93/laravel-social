<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Collection;

interface CanFollowContract
{

    public function followingEntities();


    public function isFollowingSomething();


    public function isFollowing(CanBeFollowedContract $entity);


    public function follow(CanBeFollowedContract $entity);


    public function followMany(Collection $entities);


    public function unfollow(CanBeFollowedContract $entity);


    public function unfollowMany(Collection $entities);


    public function getFollowingEntity(CanBeFollowedContract $entity);

}
