@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.governorate.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.governorates.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.governorate.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                @if($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.governorate.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="default_price">{{ trans('cruds.city.fields.default_price') }}</label>
                <input class="form-control {{ $errors->has('default_price') ? 'is-invalid' : '' }}" type="number" name="default_price" id="default_price" value="{{ old('default_price', '') }}" step="0.01">
                @if($errors->has('default_price'))
                    <span class="text-danger">{{ $errors->first('default_price') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.city.fields.default_price_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection