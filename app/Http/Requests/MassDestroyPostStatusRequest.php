<?php

namespace App\Http\Requests;

use App\Models\PostStatus;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyPostStatusRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('post_status_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:post_statuses,id',
        ];
    }
}
