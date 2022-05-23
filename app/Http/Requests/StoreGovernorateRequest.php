<?php

namespace App\Http\Requests;

use App\Models\Governorate;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreGovernorateRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('governorate_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
        ];
    }
}
