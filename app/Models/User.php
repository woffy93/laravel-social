<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Contracts\CanBeFollowedContract;
use App\Contracts\CanFollowContract;
use App\Contracts\Likable;
use App\Events\UserLikedALink;
use App\Models\Concerns\CanBeFollowed;
use App\Models\Concerns\CanFollow;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements CanFollowContract, CanBeFollowedContract
{
    use HasApiTokens, HasFactory, Notifiable, CanFollow, CanBeFollowed;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function links()
    {
        return $this->hasMany(Link::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function hasLiked(Likable $likable): bool
    {
        if(!$likable->exists){
            return false;
        }
        return $likable->likes()
            ->whereHas('user', fn($q) => $q->whereId($this->id))
            ->exists();
    }

    public function like(Likable $likable): self
    {
        if ($this->hasLiked($likable)) {
            return $this;
        }


        $like = new Like();
        $like->user()->associate($this);
        $like->likeable()->associate($likable);
        $like->save();
        if ($likable instanceof Link) {
            event(new UserLikedALink($this, $likable));
        }

        return $this;
    }

    public function removeLike(Likable $likable): self
    {
        if(!$this->hasLiked($likable)){
            return $this;
        }

        $likable->likes()
            ->whereHas('user', fn($q) => $q->whereId($this->id))
            ->delete();
        return $this;
    }
}
