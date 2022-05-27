@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.invoice.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.invoices.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="customer_id">{{ trans('cruds.invoice.fields.customer') }}</label>
                <select class="form-control select2 {{ $errors->has('customer') ? 'is-invalid' : '' }}" name="customer_id" id="customer_id" required onchange="getBalance()">
                    @foreach($customers as $id => $entry)
                        <option value="{{ $id }}" {{ old('customer_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('customer'))
                    <span class="text-danger">{{ $errors->first('customer') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.invoice.fields.customer_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="amount">{{ trans('cruds.invoice.fields.amount') }}</label>
                <input class="form-control {{ $errors->has('amount') ? 'is-invalid' : '' }}" type="number" name="amount" id="amount" value="{{ old('amount', '') }}" step="0.01" required readonly>
                @if($errors->has('amount'))
                    <span class="text-danger">{{ $errors->first('amount') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.invoice.fields.amount_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>

            <iframe 
                name="invoiceData"
                id="invoiceData" 
                srcdoc=""
                src="#"
                width="100%"
                height="500rem"
            ></iframe>
            
        {{-- <div id="invoiceData"></div> --}}
    </div>
</div>

<script>
    function getBalance(){
        var customer_id = $('#customer_id').find(":selected").val();
        
        $.ajax({
            method: 'GET',
            url: "{{ route('admin.invoices.getBalance') }}" + '/' + customer_id,
            success: function(data) {
                $('#amount').val(data[0]);
                $('#invoiceData').attr("srcdoc",data[1]);
            },
            error: function(e) 
            {
                alert('Error: ' + e);
            }
            })

    }
</script>

@endsection