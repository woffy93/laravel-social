<?php

namespace App\Http\Requests;

use App\Contracts\Likable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;

class LikeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('like', $this->likable());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'likable_type' => [
                'bail',
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    if(!class_exists($value)){
                        $fail($attribute . ' is not a valid/existing class!');
                    }
                    if(!in_array(Model::class, class_parents($value))){
                        $fail($value . ' is not a valid/existing model!');
                    }
                    if(!in_array(Likable::class, class_implements($value))){
                        $fail($value . ' is not a likable!');
                    }
                }
            ],

            'likable_id' => [
                'required',
                function ($attribute, $value, $fail) {
                    $class = $this->input('likable_type');
                    if(!$class::whereId($value)->exists()){
                        $fail($value . " does not exist in db");
                    }

                }
            ]

        ];
    }

    public function likable(): Likable
    {
        $class = $this->input('likable_type');
        return $class::findOrFail($this->input('likable_id'));
    }

}
