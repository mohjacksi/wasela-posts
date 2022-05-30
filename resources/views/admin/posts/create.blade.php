@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('cruds.post.title_singular') }}
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.posts.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card border--primary mt-3">
                            <h5 class="card-header bg--primary  text-white">معلومات المرسل</h5>
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-lg-12">
                                        <label class="required"
                                            for="sender_id">{{ trans('cruds.post.fields.sender') }}</label>
                                        <select
                                            class="form-control select2 {{ $errors->has('sender') ? 'is-invalid' : '' }}"
                                            name="sender_id" id="sender_id" required>
                                            @foreach ($senders as $id => $entry)
                                                <option value="{{ $id }}"
                                                    {{ old('sender_id') == $id ? 'selected' : '' }}>
                                                    {{ $entry }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('sender'))
                                            <span class="text-danger">{{ $errors->first('sender') }}</span>
                                        @endif
                                        <span class="help-block">{{ trans('cruds.post.fields.sender_helper') }}</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-lg-12">
                                        <label class="required"
                                            for="sender_total">{{ trans('cruds.post.fields.sender_total') }}</label>
                                        <input
                                            class="form-control {{ $errors->has('sender_total') ? 'is-invalid' : '' }}"
                                            type="number" name="sender_total" id="sender_total"
                                            onchange="totalPrice()"
                                            value="{{ old('sender_total', '') }}" step="0.01" required>
                                        @if ($errors->has('sender_total'))
                                            <span class="text-danger">{{ $errors->first('sender_total') }}</span>
                                        @endif
                                        <span
                                            class="help-block">{{ trans('cruds.post.fields.sender_total_helper') }}</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-lg-12">
                                        <label class="required"
                                            for="delivery_price">{{ trans('cruds.post.fields.delivery_price') }}</label>
                                        <input
                                            class="form-control {{ $errors->has('delivery_price') ? 'is-invalid' : '' }}"
                                            type="number" name="delivery_price" id="delivery_price"
                                            onchange="totalPrice()"
                                            value="{{ old('delivery_price', '') }}" step="0.01" required readonly>
                                        @if ($errors->has('delivery_price'))
                                            <span class="text-danger">{{ $errors->first('delivery_price') }}</span>
                                        @endif
                                        <span
                                            class="help-block">{{ trans('cruds.post.fields.delivery_price_helper') }}</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-lg-12">
                                        <label class="required"
                                            for="customer_invoice_total">{{ trans('cruds.post.fields.customer_invoice_total') }}</label>
                                        <input
                                            class="form-control {{ $errors->has('customer_invoice_total') ? 'is-invalid' : '' }}"
                                            type="number" name="customer_invoice_total" id="customer_invoice_total"
                                            value="{{ old('customer_invoice_total', '') }}" step="0.01" required readonly>
                                        @if ($errors->has('customer_invoice_total'))
                                            <span
                                                class="text-danger">{{ $errors->first('customer_invoice_total') }}</span>
                                        @endif
                                        <span
                                            class="help-block">{{ trans('cruds.post.fields.customer_invoice_total_helper') }}</span>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>


                    <div class="col-lg-6">
                        <div class="card border--primary mt-3">
                            <h5 class="card-header bg--primary  text-white">معلومات المستلم</h5>
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-lg-12">
                                        <label for="receiver_name">{{ trans('cruds.post.fields.receiver_name') }}</label>
                                        <input
                                            class="form-control {{ $errors->has('receiver_name') ? 'is-invalid' : '' }}"
                                            type="text" name="receiver_name" id="receiver_name"
                                            value="{{ old('receiver_name', '') }}">
                                        @if ($errors->has('receiver_name'))
                                            <span class="text-danger">{{ $errors->first('receiver_name') }}</span>
                                        @endif
                                        <span
                                            class="help-block">{{ trans('cruds.post.fields.receiver_name_helper') }}</span>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="form-group col-lg-12">
                                        <label class="required"
                                            for="receiver_phone_number">{{ trans('cruds.post.fields.receiver_phone_number') }}</label>
                                        <input
                                            class="form-control {{ $errors->has('receiver_phone_number') ? 'is-invalid' : '' }}"
                                            type="text" name="receiver_phone_number" id="receiver_phone_number"
                                            value="{{ old('receiver_phone_number', '') }}" required>
                                        @if ($errors->has('receiver_phone_number'))
                                            <span
                                                class="text-danger">{{ $errors->first('receiver_phone_number') }}</span>
                                        @endif
                                        <span
                                            class="help-block">{{ trans('cruds.post.fields.receiver_phone_number_helper') }}</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-lg-6">
                                        <label for="governorate_id">{{ trans('cruds.post.fields.governorate') }}</label>
                                        <select
                                            class="form-control select2 {{ $errors->has('governorate') ? 'is-invalid' : '' }}"
                                            name="governorate_id" id="governorate_id" onchange="changeCity()">
                                            @foreach ($governorates as $id => $entry)
                                                <option value="{{ $id }}"
                                                    {{ old('governorate_id') == $id ? 'selected' : '' }}>
                                                    {{ $entry }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('governorate'))
                                            <span class="text-danger">{{ $errors->first('governorate') }}</span>
                                        @endif
                                        <span
                                            class="help-block">{{ trans('cruds.post.fields.governorate_helper') }}</span>
                                    </div>

                                    <div class="form-group col-lg-6">
                                        <label for="city_id">{{ trans('cruds.post.fields.city') }}</label>
                                        <select
                                            class="form-control select2 {{ $errors->has('city') ? 'is-invalid' : '' }}"
                                            name="city_id" id="city_id" onchange="deliveryPrice()">
                                                <option value="0" 
                                                    {{ old('city_id') == $id ? 'selected' : '' }} hidden>
                                                    </option>
                                        </select>
                                        @if ($errors->has('city'))
                                            <span class="text-danger">{{ $errors->first('city') }}</span>
                                        @endif
                                        <span class="help-block">{{ trans('cruds.post.fields.city_helper') }}</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-lg-12">
                                        <label class="required"
                                            for="delivery_address">{{ trans('cruds.post.fields.delivery_address') }}</label>
                                        <input
                                            class="form-control {{ $errors->has('delivery_address') ? 'is-invalid' : '' }}"
                                            type="text" name="delivery_address" id="delivery_address"
                                            value="{{ old('delivery_address', '') }}" required>
                                        @if ($errors->has('delivery_address'))
                                            <span class="text-danger">{{ $errors->first('delivery_address') }}</span>
                                        @endif
                                        <span
                                            class="help-block">{{ trans('cruds.post.fields.delivery_address_helper') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-30">
                    <div class="col-lg-12">
                        <div class="card border--primary mt-3">
                            <h5 class="card-header bg--primary  text-white">معلومات إضافية
                            </h5>
                            <div class="card-body">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="required"
                                            for="barcode">{{ trans('cruds.post.fields.barcode') }}</label>
                                        <input class="form-control {{ $errors->has('barcode') ? 'is-invalid' : '' }}"
                                            type="number" name="barcode" id="barcode" value="{{ sprintf("%06d", mt_rand(1, 9999999)) }}"
                                            step="1" readonly required>
                                        @if ($errors->has('barcode'))
                                            <span class="text-danger">{{ $errors->first('barcode') }}</span>
                                        @endif
                                        <span
                                            class="help-block">{{ trans('cruds.post.fields.barcode_helper') }}</span>
                                    </div>
                                </div>
                            </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="status_id">{{ trans('cruds.post.fields.status') }}</label>
                                            <select
                                                class="form-control select2 {{ $errors->has('status') ? 'is-invalid' : '' }}"
                                                name="status_id" id="status_id">
                                                @foreach ($statuses as $id => $entry)
                                                    <option value="{{ $id }}"
                                                        {{ old('status_id') == $id ? 'selected' : '' }}>
                                                        {{ $entry }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('status'))
                                                <span class="text-danger">{{ $errors->first('status') }}</span>
                                            @endif
                                            <span
                                                class="help-block">{{ trans('cruds.post.fields.status_helper') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="notes">{{ trans('cruds.post.fields.notes') }}</label>
                                            <textarea class="form-control {{ $errors->has('notes') ? 'is-invalid' : '' }}" name="notes"
                                                id="notes">{{ old('notes') }}</textarea>
                                            @if ($errors->has('notes'))
                                                <span class="text-danger">{{ $errors->first('notes') }}</span>
                                            @endif
                                            <span
                                                class="help-block">{{ trans('cruds.post.fields.notes_helper') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn--primary btn-lg btn-block"><i class="fa fa-fw fa-paper-plane"></i>
                        {{ trans('global.save') }}</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function totalPrice(){
            var total = Number($('#sender_total').val()) + Number($('#delivery_price').val());
            $('#customer_invoice_total').val(total);    
        }
        function deliveryPrice(){
            var id = $('#city_id').find(":selected").val();
            $.ajax({
            method: 'GET',
            url: "{{ route('admin.post.deliveryPrice') }}" + '/' + id,
            success: function(data) {
                if(data){
                    $('#delivery_price').val(data);
                }

            }
            })  
        }

        function changeCity(){
            var id = $('#governorate_id').find(":selected").val();
            $.ajax({
            method: 'GET',
            url: "{{ route('admin.post.changeCity') }}" + '/' + id,
            success: function (data) {
            var city=$('#city_id');
            city.empty();
            city.append('<option>الرجاء الإختيار</option>');
            for (var i = 0; i < data.length; i++) {
                city.append('<option value=' + data[i].id + '>' + data[i].name + '</option>');
            };
            }
            })  
        }

       
    </script>
@endsection
