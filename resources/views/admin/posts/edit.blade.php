@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.post.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.posts.update", [$post->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="barcode">{{ trans('cruds.post.fields.barcode') }}</label>
                <input class="form-control {{ $errors->has('barcode') ? 'is-invalid' : '' }}" type="text" name="barcode" id="barcode" value="{{ old('barcode', $post->barcode) }}" required>
                @if($errors->has('barcode'))
                    <span class="text-danger">{{ $errors->first('barcode') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.post.fields.barcode_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="sender_id">{{ trans('cruds.post.fields.sender') }}</label>
                <select class="form-control select2 {{ $errors->has('sender') ? 'is-invalid' : '' }}" name="sender_id" id="sender_id" required>
                    @foreach($senders as $id => $entry)
                        <option value="{{ $id }}" {{ (old('sender_id') ? old('sender_id') : $post->sender->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('sender'))
                    <span class="text-danger">{{ $errors->first('sender') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.post.fields.sender_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="receiver_name">{{ trans('cruds.post.fields.receiver_name') }}</label>
                <input class="form-control {{ $errors->has('receiver_name') ? 'is-invalid' : '' }}" type="text" name="receiver_name" id="receiver_name" value="{{ old('receiver_name', $post->receiver_name) }}">
                @if($errors->has('receiver_name'))
                    <span class="text-danger">{{ $errors->first('receiver_name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.post.fields.receiver_name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="receiver_phone_number">{{ trans('cruds.post.fields.receiver_phone_number') }}</label>
                <input class="form-control {{ $errors->has('receiver_phone_number') ? 'is-invalid' : '' }}" type="text" name="receiver_phone_number" id="receiver_phone_number" value="{{ old('receiver_phone_number', $post->receiver_phone_number) }}" required>
                @if($errors->has('receiver_phone_number'))
                    <span class="text-danger">{{ $errors->first('receiver_phone_number') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.post.fields.receiver_phone_number_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="governorate_id">{{ trans('cruds.post.fields.governorate') }}</label>
                <select class="form-control select2 {{ $errors->has('governorate') ? 'is-invalid' : '' }}" name="governorate_id" id="governorate_id">
                    @foreach($governorates as $id => $entry)
                        <option value="{{ $id }}" {{ (old('governorate_id') ? old('governorate_id') : $post->governorate->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('governorate'))
                    <span class="text-danger">{{ $errors->first('governorate') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.post.fields.governorate_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="city_id">{{ trans('cruds.post.fields.city') }}</label>
                <select class="form-control select2 {{ $errors->has('city') ? 'is-invalid' : '' }}" name="city_id" id="city_id">
                    @foreach($cities as $id => $entry)
                        <option value="{{ $id }}" {{ (old('city_id') ? old('city_id') : $post->city->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('city'))
                    <span class="text-danger">{{ $errors->first('city') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.post.fields.city_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="delivery_address">{{ trans('cruds.post.fields.delivery_address') }}</label>
                <input class="form-control {{ $errors->has('delivery_address') ? 'is-invalid' : '' }}" type="text" name="delivery_address" id="delivery_address" value="{{ old('delivery_address', $post->delivery_address) }}" required>
                @if($errors->has('delivery_address'))
                    <span class="text-danger">{{ $errors->first('delivery_address') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.post.fields.delivery_address_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="sender_total">{{ trans('cruds.post.fields.sender_total') }}</label>
                <input class="form-control {{ $errors->has('sender_total') ? 'is-invalid' : '' }}" type="number" name="sender_total" id="sender_total" value="{{ old('sender_total', $post->sender_total) }}"   required>
                @if($errors->has('sender_total'))
                    <span class="text-danger">{{ $errors->first('sender_total') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.post.fields.sender_total_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="delivery_price">{{ trans('cruds.post.fields.delivery_price') }}</label>
                <input class="form-control {{ $errors->has('delivery_price') ? 'is-invalid' : '' }}" type="number" name="delivery_price" id="delivery_price" value="{{ old('delivery_price', $post->delivery_price) }}"   required>
                @if($errors->has('delivery_price'))
                    <span class="text-danger">{{ $errors->first('delivery_price') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.post.fields.delivery_price_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="customer_invoice_total">{{ trans('cruds.post.fields.customer_invoice_total') }}</label>
                <input class="form-control {{ $errors->has('customer_invoice_total') ? 'is-invalid' : '' }}" type="number" name="customer_invoice_total" id="customer_invoice_total" value="{{ old('customer_invoice_total', $post->customer_invoice_total) }}"   required>
                @if($errors->has('customer_invoice_total'))
                    <span class="text-danger">{{ $errors->first('customer_invoice_total') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.post.fields.customer_invoice_total_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="status_id">{{ trans('cruds.post.fields.status') }}</label>
                <select class="form-control select2 {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status_id" id="status_id" {{ $post->invoice_id == null ? '' : 'disabled'}}>
                    @foreach($statuses as $id => $entry)
                        <option value="{{ $id }}" {{ (old('status_id') ? old('status_id') : $post->status->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <span class="text-danger">{{ $errors->first('status') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.post.fields.status_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="type">{{ trans('cruds.post.fields.type') }}</label>
                <input class="form-control {{ $errors->has('type') ? 'is-invalid' : '' }}"
                    type="text" name="type" id="type" value="{{ old('type', $post->type) }}" step="1">
                @if ($errors->has('type'))
                    <span class="text-danger">{{ $errors->first('type') }}</span>
                @endif
            </div>
        
            <div class="form-group">
                <label for="notes">{{ trans('cruds.post.fields.notes') }}</label>
                <textarea class="form-control {{ $errors->has('notes') ? 'is-invalid' : '' }}" name="notes" id="notes">{{ old('notes', $post->notes) }}</textarea>
                @if($errors->has('notes'))
                    <span class="text-danger">{{ $errors->first('notes') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.post.fields.notes_helper') }}</span>
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
