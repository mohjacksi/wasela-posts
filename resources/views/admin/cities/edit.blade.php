@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.city.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.cities.update", [$city->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.city.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $city->name) }}" required>
                @if($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.city.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="governorate_id">{{ trans('cruds.city.fields.governorate') }}</label>
                <select class="form-control select2 {{ $errors->has('governorate') ? 'is-invalid' : '' }}" name="governorate_id" id="governorate_id" required>
                    @foreach($governorates as $id => $entry)
                        <option value="{{ $id }}" {{ (old('governorate_id') ? old('governorate_id') : $city->governorate->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('governorate'))
                    <span class="text-danger">{{ $errors->first('governorate') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.city.fields.governorate_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="default_price">{{ trans('cruds.city.fields.default_price') }}</label>
                <input class="form-control {{ $errors->has('default_price') ? 'is-invalid' : '' }}" type="number" name="default_price" id="default_price" value="{{ old('default_price', $city->default_price) }}" step="0.01">
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