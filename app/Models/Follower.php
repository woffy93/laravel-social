<?php

namespace App\Models;

use App\Contracts\CanBeFollowedContract;
use App\Contracts\CanFollowContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;


class Follower extends Model
{
    use HasFactory;

    public function followable()
    {
        return $this->morphTo();
    }


    public function follower()
    {
        return $this->morphTo();
    }

    /**
     * Finds the entities that are followers for the given type.
     *
     * @param \Illuminate\Database\Eloquent\Model|string $type
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWhereFollowerType(Builder $query, $type)
    {
        // Determine if the given type is a valid class
        if (class_exists($type)) {
            $type = new $type();
        }

        // Determine if the given type is an instance of an
        // Eloquent Model and if it is, we'll obtain the
        // corresponding morphed class name from it.
        if (is_a($type, Model::class)) {
            $type = $type->getMorphClass();
        }

        return $query->where('follower_type', $type);
    }

    /**
     * Finds the entities that are being followed for the given type.
     *
     * @param \Illuminate\Database\Eloquent\Model|string $type
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWhereFollowableType(Builder $query, $type)
    {
        // Determine if the given type is a valid class
        if (class_exists($type)) {
            $type = new $type();
        }

        // Determine if the given type is an instance of an
        // Eloquent Model and if it is, we'll obtain the
        // corresponding morphed class name from it.
        if (is_a($type, Model::class)) {
            $type = $type->getMorphClass();
        }

        return $query->where('followable_type', $type);
    }

    /**
     * Finds the given entity that's following other entities.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWhereFollowerEntity(Builder $query, CanFollowContract $entity)
    {
        return $query
            ->where('follower_id', $entity->getKey())
            ->where('follower_type', $entity->getMorphClass())
            ;
    }

    /**
     * Finds the given entity that's being followed by other entities.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWhereFollowableEntity(Builder $query, CanBeFollowedContract $entity)
    {
        return $query
            ->where('followable_id', $entity->getKey())
            ->where('followable_type', $entity->getMorphClass())
            ;
    }
}
