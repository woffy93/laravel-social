<?php

namespace App\Models\Concerns;

use App\Contracts\CanFollowContract;
use App\Models\Follower;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

trait CanBeFollowed
{
    public static function bootCanBeFollowed()
    {
        //cleanup polymorphic relation table on delete
        static::deleted(function (Model $entity) {
            $entity->followers()->delete();
        });
    }


    public function followers()
    {
        return $this->morphMany(Follower::class, 'followable');
    }


    public function hasFollowers()
    {
        return (bool)$this->followers()->count();
    }


    public function hasFollower(CanFollowContract $entity)
    {
        return (bool)$this->findFollower($entity);

    }


    public function addFollower(CanFollowContract $entity)
    {
        $follower = new Follower();
        $follower->follower_id = $entity->getKey();
        $follower->follower_type = $entity->getMorphClass();

        $this->followers()->save($follower);

    }


    public function addManyFollowers(Collection $entities)
    {
        //todo: optimize with batch insert, unused at the moment
        $entities->each(function (CanFollowContract $entity) {
            $this->addFollower($entity);
        });

    }


    public function removeFollower(CanFollowContract $entity)
    {
        $followed = $this->findFollower($entity);

        if ($followed) {
            $followed->delete();
        }
    }

    public function removeManyFollowers(Collection $entities)
    {
        //todo: optimize with batch delete, unused at the moment

        $entities->each(function (CanFollowContract $entity) {
            $this->removeFollower($entity);
        });
    }


    public function findFollower(CanFollowContract $entity)
    {
        return $this->followers()->whereFollowerEntity($entity)->first();
    }


}
