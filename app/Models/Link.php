<?php

namespace App\Models;

use App\Contracts\Likable;
use App\Models\Concerns\Likes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model implements Likable
{
    use Likes;
    use HasFactory;

    protected $fillable = [
        'title',
        'url',
    ];

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }
}
