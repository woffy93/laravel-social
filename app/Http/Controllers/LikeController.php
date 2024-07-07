<?php

namespace App\Http\Controllers;

use App\Http\Requests\LikeRequest;
use App\Http\Requests\RemoveLikeRequest;

class LikeController extends Controller
{
    public function like(LikeRequest $request)
    {
        $request->user()->like($request->likable());

        return redirect()->back();
    }

    public function removeLike(RemoveLikeRequest $request)
    {
        $request->user()->removeLike($request->likable());

        return redirect()->back();

    }
}
