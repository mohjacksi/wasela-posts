@php
if(!isset($posts)){
 $posts = $invoice->invoicePosts->where('status_id', 3);
}
 @endphp
<div class="container">
    <table class="table">
        <tbody>
            <thead>
                <tr>
                    <td style="width: 26%;">
                        <p>
                        <h5 style="display: inline-block;">{{ trans('cruds.crmCustomer.fields.name2') }} :
                        </h5> {{ $invoice->customer ? $invoice->customer->name : '' }}</p>
                        <p>
                        <h5 style="display: inline-block;">{{ trans('global.date') }} :</h5>
                        {{ $invoice->created_at ? $invoice->created_at->toDateString() : date('Y-m-d') }}</p>
                        <p>
                        <h5 style="display: inline-block;">{{ trans('cruds.invoice.invoice_number') }} :
                        </h5> {{ $invoice->id ?? '' }}</p>
                        <p>
                        <h5 style="display: inline-block;">{{ trans('cruds.post.fields.final_amount') }}
                            :</h5> {{ $invoice->amount ?? '' }}</p>
                    </td>
                    <td>
                        <h4>{{ trans('cruds.invoice.customer_invoice') }}</h4>
                        <p>
                        <h5 style="display: inline-block;">{{ trans('cruds.invoice.quantity') }} :</h5>
                        {{ $posts ? $posts->count() : '' }}</p>
                        {{-- assume the capital id = 1 --}}
                        <p>
                        <h5 style="display: inline-block;">{{ trans('cruds.invoice.capital_quantity') }}
                            :</h5>
                        {{ $posts? $posts->where('governorate_id', 1)->count(): '' }}
                        </p>
                        <p>
                        <h5 style="display: inline-block;">{{ trans('cruds.invoice.other_quantity') }} :
                        </h5>
                        {{ $posts? $posts->where('governorate_id', '!=', 1)->count(): '' }}
                        </p>
                    </td>
                    <td><img src="{{ asset('vendor/invoices/sample-logo.png') }}" alt="logo" height="100"
                            style="height: 6rem;"></td>
                </tr>
            </thead>
        </tbody>
    </table>

    <table class="table table-bordered table-striped">
        <thead class="thead-light">
            <tr>
                <th scope="col">#</th>
                <th scope="col">{{ trans('cruds.post.fields.date') }}</th>
                <th scope="col">{{ trans('cruds.post.fields.barcode') }}</th>
                <th scope="col">{{ trans('cruds.post.fields.receiver_phone_number') }}</th>
                <th scope="col">{{ trans('cruds.post.fields.delivery_address') }}</th>
                <th scope="col">{{ trans('cruds.post.fields.customer_invoice_total') }}</th>
                <th scope="col">{{ trans('cruds.post.fields.delivery_price') }}</th>
                <th scope="col">{{ trans('cruds.post.fields.sender_total') }}</th>
                <th scope="col">{{ trans('cruds.post.fields.notes') }}</th>
            </tr>
        </thead>
        <tbody>
            @php $i=0; @endphp
            @foreach ($posts as $key => $post)
                @php $i=$i+1; @endphp
                <tr>
                    <th scope="row">{{ $i }}</th>
                    <td>{{ $post->created_at->toDateString() ?? '' }}</td>
                    <td>{{ $post->barcode ?? '' }}</td>
                    <td>{{ $post->receiver_phone_number ?? '' }}</td>
                    <td>{{ $post->governorate->name ?? '' }} - {{ $post->city->name ?? '' }}</td>
                    <td>{{ $post->customer_invoice_total ?? '' }}</td>
                    <td>{{ $post->delivery_price ?? '' }}</td>
                    <td>{{ $post->sender_total ?? '' }}</td>
                    <td></td>
                </tr>
            @endforeach
            <tr style="background-color: #fff; text-align:center;">
                <th colspan="5" style="text-align:center;">
                    <h5>{{ trans('cruds.post.fields.final_amount') }} :</h5>
                </th>
                <th colspan="4" style="text-align:center;">{{ $invoice->amount ?? '' }}</th>
            </tr>
        </tbody>
    </table>
</div>
