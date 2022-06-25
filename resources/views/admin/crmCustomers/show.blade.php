@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.crmCustomer.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.crm-customers.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.crmCustomer.fields.id') }}
                        </th>
                        <td>
                            {{ $crmCustomer->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.crmCustomer.fields.name') }}
                        </th>
                        <td>
                            {{ $crmCustomer->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.crmCustomer.fields.status') }}
                        </th>
                        <td>
                            {{ $crmCustomer->status->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.crmCustomer.fields.email') }}
                        </th>
                        <td>
                            {{ $crmCustomer->email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.crmCustomer.fields.phone') }}
                        </th>
                        <td>
                            {{ $crmCustomer->phone }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.crmCustomer.fields.address') }}
                        </th>
                        <td>
                            {{ $crmCustomer->address }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.crmCustomer.fields.description') }}
                        </th>
                        <td>
                            {{ $crmCustomer->description }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.crmCustomer.fields.capital_default_price') }}
                        </th>
                        <td>
                            {{ $crmCustomer->capital_default_price }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.crmCustomer.fields.other_default_price') }}
                        </th>
                        <td>
                            {{ $crmCustomer->other_default_price }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.crm-customers.index') }}">
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
            <a class="nav-link" href="#customer_crm_notes" role="tab" data-toggle="tab">
                {{ trans('cruds.crmNote.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#customer_invoices" role="tab" data-toggle="tab">
                {{ trans('cruds.invoice.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#sender_posts" role="tab" data-toggle="tab">
                {{ trans('cruds.post.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="customer_crm_notes">
            @includeIf('admin.crmCustomers.relationships.customerCrmNotes', ['crmNotes' => $crmCustomer->customerCrmNotes])
        </div>
        <div class="tab-pane" role="tabpanel" id="customer_invoices">
            @includeIf('admin.crmCustomers.relationships.customerInvoices', ['invoices' => $crmCustomer->customerInvoices])
        </div>
        <div class="tab-pane" role="tabpanel" id="sender_posts">
            @includeIf('admin.crmCustomers.relationships.senderPosts', ['posts' => $posts])
        </div>
    </div>
</div>

@endsection