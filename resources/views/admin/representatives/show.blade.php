@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.representative.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.representatives.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.representative.fields.id') }}
                        </th>
                        <td>
                            {{ $representative->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.representative.fields.name') }}
                        </th>
                        <td>
                            {{ $representative->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.representative.fields.phone_number') }}
                        </th>
                        <td>
                            {{ $representative->phone_number }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.representatives.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection