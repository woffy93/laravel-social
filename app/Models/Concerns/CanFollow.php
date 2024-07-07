<?php

namespace App\Models\Concerns;

use App\Contracts\CanBeFollowedContract;
use App\Models\Follower;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

trait CanFollow
{
    public static function bootCanFollow()
    {
        //cleanup polymorphic relation table on delete
        static::deleted(function (Model $entityModel) {
            $entityModel->followingEntities()->delete();
        });
    }

    public function followingEntities()
    {
        return $this->morphMany(Follower::class, 'follower');
    }


    public function isFollowingSomething()
    {
        return (bool)$this->followingEntities()->count();
    }


    public function isFollowing(CanBeFollowedContract $entity)
    {
        return (bool)$this->getFollowingEntity($entity);

    }


    public function getFollowingEntity(CanBeFollowedContract $entity)
    {
        return $this->followingEntities()->whereFollowableEntity($entity)->first();
    }

    public function followMany(Collection $entities)
    {
        $batchSize = 1000;
        $follows = [];

        $entities->each(function ($entity) use (&$follows) {
            $follows[] = [
                'follower_id' => $this->id,
                'follower_type' => $this->getMorphClass(),
                'followable_id' => $entity->id,
                'followable_type' => $entity->getMorphClass(),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        });

        // Insert in batches
        foreach (array_chunk($follows, $batchSize) as $batch) {
            DB::table('followers')->insert($batch);
        }

    }


    public function follow(CanBeFollowedContract $entity)
    {
        $follower = new Follower();
        $follower->followable_id = $entity->getKey();
        $follower->followable_type = $entity->getMorphClass();

        $this->followingEntities()->save($follower);
    }


    public function unfollowMany(Collection $entities)
    {
        $entities->each(function (CanBeFollowedContract $entity) {
            $this->unfollow($entity);
        });
    }


    public function unfollow(CanBeFollowedContract $entity)
    {
        $following = $this->getFollowingEntity($entity);

        if ($following) {
            $this->followingEntities()->whereFollowableEntity($entity)->delete();
        }
    }


}
