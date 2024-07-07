<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface CanBeFollowedContract
{

    public function followers();


    public function hasFollowers();


    public function hasFollower(CanFollowContract $entity);


    public function addFollower(CanFollowContract $entity);


    public function addManyFollowers(Collection $entities);


    public function removeFollower(CanFollowContract $entity);

    public function removeManyFollowers(Collection $entities);

    public function findFollower(CanFollowContract $entity);

}
