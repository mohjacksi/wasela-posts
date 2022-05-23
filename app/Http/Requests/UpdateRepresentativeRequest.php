<?php

namespace App\Http\Requests;

use App\Models\Representative;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateRepresentativeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('representative_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
            'phone_number' => [
                'string',
                'nullable',
            ],
        ];
    }
}
