@extends('layouts.admin')
@section('content')

@section('styles')
<style>

    @media print{
        @page {
            size: a5 portrait;
            margin: 50px;
        }
    }
</style>
@endsection

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.post.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.posts.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>

                <a class="btn btn-info" href="#" onclick="printPost()">
                    {{ trans('cruds.post.print') }}
                </a>
            </div>
            <div id="print_post">
            <table class="table">
                <tbody>
                    <tr>
                        <th colspan="2" style="text-align: center;">
                            <img src="{{ asset('vendor/invoices/sample-logo.png') }}" alt="logo" height="150"
                            style="height: 7rem;">
                        </th>
                    </tr>
                    <tr style="border-bottom: 3px solid #000;">
                        <th>
                            <br><br>
                           <h2>{{ trans('global.date') }} :
                                {{ $post->created_at ? $post->created_at->toDateString() : date('Y-m-d') }}</h2>
                        </th>
                        <th>
                            <h2>info@wasela-iq.com</h2>
                            <h2>07700096622</h2>
                            <h2>{{ $post->barcode }}.No</h2> 

                        </th>
                    </tr>
                    <tr>
                        <th colspan="2">
                            <h2 style="display: inline-block;">{{ trans('cruds.post.fields.sender') }} :
                                {{ $post->sender->name ?? '' }}</h2>
                        </th>
                    </tr>
                    <tr>
                        <th colspan="2">
                            <h2 style="display: inline-block;">{{ trans('cruds.post.fields.sender_phone_number') }} :
                                {{ $post->sender->phone ?? '' }}</h2>
                        </th>
                    </tr>
                    <tr>
                        <th colspan="2">
                            <h2 style="display: inline-block;">{{ trans('cruds.post.fields.receiver_name') }} :
                                {{ $post->receiver_name ?? '' }}</h2>
                        </th>
                    </tr>
                    <tr>
                        <th colspan="2">
                            <h2 style="display: inline-block;">{{ trans('cruds.post.fields.receiver_phone_number') }} :
                                {{ $post->receiver_phone_number ?? '' }}</h2>
                        </th>
                    </tr>
                    <tr>
                        <th>
                            <h2 style="display: inline-block;">{{ trans('cruds.post.fields.governorate') }} :
                                {{ $post->governorate->name ?? '' }}</h2>
                        </th>
                        <th style="text-align: right;">
                            <h2 style="display: inline-block;">{{ trans('cruds.post.fields.city') }} :
                                {{ $post->city->name ?? '' }}</h2>
                        </th>
                    </tr>
                    <tr>
                        <th colspan="2">
                            <h2 style="display: inline-block;">{{ trans('cruds.post.fields.delivery_address') }} :
                                {{ $post->delivery_address ?? '' }} </h2>
                        </th>
                    </tr>
                    <tr>
                        <th colspan="2">
                            <h2 style="display: inline-block;">{{ trans('cruds.post.fields.customer_invoice_total') }} :
                                {{ $post->customer_invoice_total ?? '' }}</h2>
                        </th>
                    </tr>
                    <tr>
                        <th>
                            <h2 style="display: inline-block;">{{ trans('cruds.post.fields.type') }} :
                                {{ $post->type ?? '' }}</h2>
                        </th>
                        <th style="text-align: right;">
                            <h2 style="display: inline-block;">{{ trans('cruds.post.fields.quantity') }} :
                                {{ $post->quantity ?? '' }}</h2>
                        </th>
                    </tr>
                    <tr style="border-bottom: 3px solid #000;">
                        <th colspan="2">
                            <h2 style="display: inline-block;">{{ trans('cruds.post.fields.notes') }} :
                                {{ $post->notes ?? '' }}</h2>
                        </th>
                    </tr>
                    <tr>
                        <th>
                            <h2 style="display: inline-block;">نفق الشرطة, الشارع الخدمى , بجانب بسكولاتة.</h2>
                        </th>
                        <th>
                            <h2 style="display: inline-block;">www.wasela-iq.com</h2>
                        </th>
                    </tr>
                </tbody>
            </table>
            </div>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.posts.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    function printPost() {
        var printContents = document.getElementById("print_post").innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;

    }
</script>


@endsection