<?php

namespace App\Http\Requests;

use App\Models\Post;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StorePostRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('post_create');
    }

    public function rules()
    {
        return [
            'barcode' => [
                'string',
                'required',
                'unique:posts',
            ],
            'sender_id' => [
                'required',
                'integer',
            ],
            'receiver_name' => [
                'string',
                'nullable',
            ],
            'receiver_phone_number' => [
                'string',
                'required',
                'digits_between:11,22',
            ],
            'sender_total' => [
                'required',
            ],
            'delivery_price' => [
                'required',
            ],
            'customer_invoice_total' => [
                'required',
            ],
        ];
    }
}
