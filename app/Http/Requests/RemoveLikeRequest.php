<?php

namespace App\Http\Requests;


class RemoveLikeRequest extends LikeRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('removeLike', $this->likable());
    }
}
