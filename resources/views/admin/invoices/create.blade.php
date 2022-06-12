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
            <div class="form-check">
                <input class="form-check-input" type="radio" name="status_id" id="exampleRadios1" value="3" onchange="getBalance()" checked>
                <label class="form-check-label" for="exampleRadios1">{{ trans('cruds.post.fields.delivered') }}</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="status_id" id="exampleRadios2" value="2" onchange="getBalance()">
                <label class="form-check-label" for="exampleRadios2">{{ trans('cruds.post.fields.rejected') }}</label>
            </div>
            <div class="form-group">
                <label class="required" for="amount">{{ trans('cruds.invoice.fields.amount') }}</label>
                <input class="form-control {{ $errors->has('amount') ? 'is-invalid' : '' }}" type="number" name="amount" id="amount" value="{{ old('amount', '') }}"   required readonly>
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

        <div id="invoiceData">

        </div>
    </div>
</div>

<script>
    function getBalance(){
        var customer_id = $('#customer_id').find(":selected").val();
        var status_id = $('input[name="status_id"]:checked').val();
        $('#amount').val(0);
        $('#invoiceData').html('');
        if(customer_id > 0){
            $.ajax({
                headers: {'x-csrf-token': _token},
                type: "POST",
                url: "{{ route('admin.invoices.getBalance') }}",
                data: { id : customer_id, status_id : status_id }, // serializes the form's elements.
                success: function(data)
                {
                    console.log(data);

                    $('#amount').val(data[0]);
                    $('#invoiceData').html(data[1]);
                    // $('#invoiceData').load(self)
                    // $('#invoiceData').attr("srcdoc",data[1]);
                }
            });
        }
        
        // $.ajax({
        //     method: 'GET',
        //     url: "{{ route('admin.invoices.getBalance') }}" + '/' + customer_id,
        //     success: function(data) {
        //         $('#amount').val(data[0]);
        //         $('#invoiceData').attr("srcdoc",data[1]);
        //     },
        //     error: function(e) 
        //     {
        //         alert('Error: ' + e);
        //     }
        // })

    }
</script>

@endsection