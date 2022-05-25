@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.invoice.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.invoices.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>

                <a class="btn btn-success" href="#" onclick="newInvoice()">
                    {{ trans('cruds.invoice.download') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.invoice.fields.id') }}
                        </th>
                        <td>
                            {{ $invoice->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.invoice.fields.customer') }}
                        </th>
                        <td>
                            {{ $invoice->customer->email ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.invoice.fields.amount') }}
                        </th>
                        <td>
                            {{ $invoice->amount }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.invoice.fields.created_at') }}
                        </th>
                        <td>
                            {{ $invoice->created_at }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.invoice.fields.updated_at') }}
                        </th>
                        <td>
                            {{ $invoice->updated_at }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.invoices.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        {{ trans('global.relatedData') }}
    </div>
    <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
        <li class="nav-item">
            <a class="nav-link" href="#invoice_posts" role="tab" data-toggle="tab">
                {{ trans('cruds.post.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="invoice_posts">
            @includeIf('admin.invoices.relationships.invoicePosts', ['posts' => $invoice->invoicePosts])
        </div>
    </div>
</div>

<script>
    function newInvoice(){
        $.ajax({
            method: 'GET',
            url: "{{ route('admin.invoices.newCreate', $invoice->id) }}",
            })
            .done(function () { location.reload() })

    }
</script>
@endsection