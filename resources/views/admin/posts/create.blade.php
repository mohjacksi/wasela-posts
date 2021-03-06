[@extends('layouts.admin')
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
                                            name="sender_id" id="sender_id"
                                            onchange="deliveryPrice()" required>
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
                                            type="number" name="sender_total" id="sender_total" onchange="new_price()"
                                            value="{{ old('sender_total', '') }}" required>
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
                                            type="number" name="delivery_price" id="delivery_price" onchange="new_price()" {{-- isChangable="true" $('#delivery_price').attr('isChangable','false');" --}}
                                            value="{{ old('delivery_price', '') }}" required>
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
                                            onchange="new_price()" value="{{ old('customer_invoice_total', '') }}"
                                            required>
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
                                            name="governorate_id" id="governorate_id"
                                            onchange="changeCity(); deliveryPrice()">
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
                                            name="city_id" id="city_id">
                                            <option value {{ old('city_id') == $id ? 'selected' : '' }}>الرجاء الإختيار
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
                                        <label for="delivery_address">{{ trans('cruds.post.fields.delivery_address') }}</label>
                                        <input
                                            class="form-control {{ $errors->has('delivery_address') ? 'is-invalid' : '' }}"
                                            type="text" name="delivery_address" id="delivery_address"
                                            value="{{ old('delivery_address', '') }}">
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
                                    <div class="form-group col-lg-6">
                                        <div class="form-group">
                                            <label for="type">{{ trans('cruds.post.fields.type') }}</label>
                                            <input class="form-control {{ $errors->has('type') ? 'is-invalid' : '' }}"
                                                type="text" name="type" id="type" step="1">
                                            @if ($errors->has('type'))
                                                <span class="text-danger">{{ $errors->first('type') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <div class="form-group">
                                            <label for="quantity">{{ trans('cruds.post.fields.quantity') }}</label>
                                            <input
                                                class="form-control {{ $errors->has('quantity') ? 'is-invalid' : '' }}"
                                                type="number" name="quantity" id="quantity" step="1">
                                            @if ($errors->has('quantity'))
                                                <span class="text-danger">{{ $errors->first('quantity') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @php 
                                    $statement = DB::select("SHOW TABLE STATUS LIKE 'posts'");
                                    $nextId = $statement[0]->Auto_increment;
                                    // $barcode = sprintf('%06d', mt_rand(1, 9999999));
                                    $barcode = 'E'.str_pad($nextId, 5, '0', STR_PAD_LEFT);
                                @endphp
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="required"
                                                for="barcode">{{ trans('cruds.post.fields.barcode') }}</label>
                                            <input class="form-control {{ $errors->has('barcode') ? 'is-invalid' : '' }}"
                                                type="text" name="barcode" id="barcode"
                                                value="{{ $barcode }}" step="1" required>
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
                                                readonly name="status_id" id="status_id">
                                                @foreach ($statuses as $id => $entry)
                                                    <option value="{{ $id }}"
                                                        {{ 1 == $id ? 'selected' : '' }}>
                                                        {{-- {{ old('status_id') == $id ? 'selected' : '' }}> --}}
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
                                            <textarea class="form-control {{ $errors->has('notes') ? 'is-invalid' : '' }}" name="notes" id="notes">{{ old('notes') }}</textarea>
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
        function new_price() {
            var price = Number($('#customer_invoice_total').val()) - Number($('#delivery_price').val());
            $('#sender_total').val(price);
        }
        // function totalPrice(){
        //     var total = Number($('#sender_total').val()) + Number($('#delivery_price').val());
        //     $('#customer_invoice_total').val(total);
        // }
        function deliveryPrice() {
            var gov_id = $('#governorate_id').find(":selected").val();
            var sender_id = $('#sender_id').find(":selected").val();
            if(!gov_id){gov_id=0;}
            if(!sender_id){sender_id=0;}
            // var isChangable = $('#delivery_price').attr('isChangable');
            $.ajax({
                method: 'GET',
                url: "{{ route('admin.post.deliveryPrice') }}" + '/' + gov_id + '/' + sender_id,
                success: function(data) {
                    if (data) {
                        $('#delivery_price').val(data);
                        new_price();
                    }

                }
            })
        }

        function changeCity() {
            var id = $('#governorate_id').find(":selected").val();
            var city = $('#city_id');
            if (id != '') {
                $.ajax({
                    method: 'GET',
                    url: "{{ route('admin.post.changeCity') }}" + '/' + id,
                    success: function(data) {
                        city.empty();
                        city.append('<option value>الرجاء الإختيار</option>');
                        for (var i = 0; i < data.length; i++) {
                            city.append('<option value=' + data[i].id + '>' + data[i].name + '</option>');
                        };
                    }
                })
            } else {
                city.empty();
                city.append('<option value>الرجاء الإختيار</option>');
            }
        }

        // $('#status_id').select2('destroy').attr("readonly", true)
    </script>
@endsection
