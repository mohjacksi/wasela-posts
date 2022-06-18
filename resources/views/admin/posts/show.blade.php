@extends('layouts.admin')
@section('content')

@section('styles')
<style>

    @media print{
        @page {
            size: a5 portrait;
            margin: 0;
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
                            <img src="{{ asset('vendor/invoices/sample-logo.png') }}" alt="logo" height="100"
                            style="height: 4rem;">
                        </th>
                    </tr>
                    <tr style="border-bottom: 3px solid #000;">
                        <th>
                            <br><br>
                            <p><h5 style="display: inline-block;">{{ trans('global.date') }} :</h5>
                                {{ $post->created_at ? $post->created_at->toDateString() : date('Y-m-d') }}</p>
                        </th>
                        <th>
                            <p><h5 style="display: inline-block;">info@wasela-iq.com</h5></p>
                            <p><h5 style="display: inline-block;">07700096622</h5></p>
                            <p style="display: inline-block"> <h5 style="display: inline-block;">{{ $post->id }}.No</h5></p> 

                        </th>
                    </tr>
                    <tr>
                        <th colspan="2">
                            <p><h5 style="display: inline-block;">{{ trans('cruds.post.fields.sender') }} :</h5>
                                {{ $post->sender->name ?? '' }}</p>
                        </th>
                    </tr>
                    <tr>
                        <th colspan="2">
                            <p><h5 style="display: inline-block;">{{ trans('cruds.post.fields.sender_phone_number') }} :</h5>
                                {{ $post->sender->phone ?? '' }}</p>
                        </th>
                    </tr>
                    <tr>
                        <th colspan="2">
                            <p><h5 style="display: inline-block;">{{ trans('cruds.post.fields.receiver_name') }} :</h5>
                                {{ $post->receiver_name ?? '' }}</p>
                        </th>
                    </tr>
                    <tr>
                        <th colspan="2">
                            <p><h5 style="display: inline-block;">{{ trans('cruds.post.fields.receiver_phone_number') }} :</h5>
                                {{ $post->receiver_phone_number ?? '' }}</p>
                        </th>
                    </tr>
                    <tr>
                        <th>
                            <p><h5 style="display: inline-block;">{{ trans('cruds.post.fields.governorate') }} :</h5>
                                {{ $post->governorate->name ?? '' }}</p>
                        </th>
                        <th style="text-align: right;">
                            <p><h5 style="display: inline-block;">{{ trans('cruds.post.fields.city') }} :</h5>
                                {{ $post->city->name ?? '' }}</p>
                        </th>
                    </tr>
                    <tr>
                        <th>
                            <p><h5 style="display: inline-block;">{{ trans('cruds.post.fields.customer_invoice_total') }} :</h5>
                                {{ $post->customer_invoice_total ?? '' }}</p>
                        </th>
                        <th style="text-align: right;">
                            <p><h5 style="display: inline-block;">{{ trans('cruds.post.fields.delivery_address') }} :</h5>
                                {{ $post->address ?? '' }}</p>
                        </th>
                    </tr>
                    <tr>
                        <th>
                            <p><h5 style="display: inline-block;">{{ trans('cruds.post.fields.type') }} :</h5>
                                {{ $post->type ?? '' }}</p>
                        </th>
                        <th style="text-align: right;">
                            <p><h5 style="display: inline-block;">{{ trans('cruds.post.fields.quantity') }} :</h5>
                                {{ $post->quantity ?? '' }}</p>
                        </th>
                    </tr>
                    <tr style="border-bottom: 3px solid #000;">
                        <th colspan="2">
                            <p><h5 style="display: inline-block;">{{ trans('cruds.post.fields.notes') }} :</h5>
                                {{ $post->notes ?? '' }}</p>
                        </th>
                    </tr>
                    <tr>
                        <th>
                            <p><h5 style="display: inline-block;">نفق الشرطة, الشارع الخدمى , بجانب بسكولاتة.</h5></p>
                        </th>
                        <th>
                            <p><h5 style="display: inline-block;">www.wasela-iq.com</h5></p>
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