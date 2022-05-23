<?php

namespace App\Http\Requests;

use App\Models\PostStatus;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StorePostStatusRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('post_status_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'nullable',
            ],
        ];
    }
}
