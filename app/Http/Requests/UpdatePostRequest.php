<?php

namespace App\Http\Requests;

use App\Models\Post;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdatePostRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('post_edit');
    }

    public function rules()
    {
        return [
            'barcode' => [
                'string',
                'required',
                'unique:posts,barcode,' . request()->route('post')->id,
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
            ],
            'delivery_address' => [
                'string',
                'required',
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
