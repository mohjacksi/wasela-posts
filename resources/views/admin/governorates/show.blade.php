@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.governorate.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.governorates.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.governorate.fields.id') }}
                        </th>
                        <td>
                            {{ $governorate->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.governorate.fields.name') }}
                        </th>
                        <td>
                            {{ $governorate->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.city.fields.default_price') }}
                        </th>
                        <td>
                            {{ $governorate->default_price }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.governorates.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        {{ trans('global.relatedData') }}
    </div>
    <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
        <li class="nav-item">
            <a class="nav-link" href="#governorate_posts" role="tab" data-toggle="tab">
                {{ trans('cruds.post.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="governorate_posts">
            @includeIf('admin.governorates.relationships.governoratePosts', ['posts' => $governorate->governoratePosts])
        </div>
    </div>
</div>

@endsection