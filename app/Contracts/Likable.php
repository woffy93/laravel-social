<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphMany;

interface Likable
{
    public function likes(): MorphMany;
}
