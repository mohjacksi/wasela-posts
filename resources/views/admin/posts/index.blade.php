@extends('layouts.admin')
@section('content')
@can('post_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.posts.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.post.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.post.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Post">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.post.fields.id') }}
                    </th>
                    <th>
                        {{ trans('global.actions') }}
                        &nbsp;
                    </th>
                    <th>
                        {{ trans('cruds.post.fields.status') }}
                    </th>
                    <th>
                        {{ trans('cruds.post.fields.barcode') }}
                    </th>
                    <th>
                        {{ trans('cruds.post.fields.sender') }}
                    </th>
                    <th>
                        {{ trans('cruds.crmCustomer.fields.name') }}
                    </th>
                    <th>
                        {{ trans('cruds.post.fields.receiver_name') }}
                    </th>
                    <th>
                        {{ trans('cruds.post.fields.receiver_phone_number') }}
                    </th>
                    <th>
                        {{ trans('cruds.post.fields.governorate') }}
                    </th>
                    <th>
                        {{ trans('cruds.post.fields.city') }}
                    </th>
                    <th>
                        {{ trans('cruds.post.fields.delivery_address') }}
                    </th>
                    <th>
                        {{ trans('cruds.post.fields.sender_total') }}
                    </th>
                    <th>
                        {{ trans('cruds.post.fields.delivery_price') }}
                    </th>
                    <th>
                        {{ trans('cruds.post.fields.customer_invoice_total') }}
                    </th>

                    <th>
                        {{ trans('cruds.post.fields.notes') }}
                    </th>
                    <th>
                        {{ trans('cruds.post.fields.invoice') }}
                    </th>

                </tr>
                <tr>
                    <td>
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                    </td>
                    <td>
                        <select class="search">
                            <option value>{{ trans('global.all') }}</option>
                            @foreach($post_statuses as $key => $item)
                                <option value="{{ $item->name }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <select class="search">
                            <option value>{{ trans('global.all') }}</option>
                            @foreach($crm_customers as $key => $item)
                                <option value="{{ $item->name }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <select class="search">
                            <option value>{{ trans('global.all') }}</option>
                            @foreach($governorates as $key => $item)
                                <option value="{{ $item->name }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select class="search">
                            <option value>{{ trans('global.all') }}</option>
                            @foreach($cities as $key => $item)
                                <option value="{{ $item->name }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <select class="search">
                            <option value>{{ trans('global.all') }}</option>
                            @foreach($invoices as $key => $item)
                                <option value="{{ $item->amount }}">{{ $item->amount }}</option>
                            @endforeach
                        </select>
                    </td>

                </tr>
            </thead>
        </table>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    function changeStatus(id,status_id){
        event.preventDefault();
        let table = $('.datatable-Post').DataTable();
        var rowIndex = null;
            table.rows( function ( idx, data, node ) {
            if(data.id === id){
                rowIndex=idx;
            }
            return false;
        });

        if(rowIndex || rowIndex === 0){
            $.ajax({
                method: 'GET',
                url: "{{ route('admin.post.editStatus') }}" + '/' + id + '/' + status_id,
                success: function(data) {
                    if(data){
                        table.cell({row:rowIndex, column:15}).data(data).draw();
                    }

                },
                error: function(e)
                {
                    alert('Error: ' + e);
                }
            })
        }

    }

    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('post_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.posts.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).data(), function (entry) {
          return entry.id
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  let dtOverrideGlobals = {
    buttons: dtButtons,
    processing: true,
    serverSide: true,
    retrieve: true,
    aaSorting: [],
    ajax: "{{ route('admin.posts.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },

{ data: 'actions', name: '{{ trans('global.actions') }}' },
{ data: 'status_name', name: 'status.name' },
{ data: 'barcode', name: 'barcode' },
{ data: 'sender_name', name: 'sender.name' },
{ data: 'sender.name', name: 'sender.name' },
{ data: 'receiver_name', name: 'receiver_name' },
{ data: 'receiver_phone_number', name: 'receiver_phone_number' },
{ data: 'governorate_name', name: 'governorate.name' },
{ data: 'city_name', name: 'city.name' },
{ data: 'delivery_address', name: 'delivery_address' },
{ data: 'sender_total', name: 'sender_total' },
{ data: 'delivery_price', name: 'delivery_price' },
{ data: 'customer_invoice_total', name: 'customer_invoice_total' },
{ data: 'notes', name: 'notes' },
{ data: 'invoice_amount', name: 'invoice.amount' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-Post').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

let visibleColumnsIndexes = null;
$('.datatable thead').on('input', '.search', function () {
      let strict = $(this).attr('strict') || false
      let value = strict && this.value ? "^" + this.value + "$" : this.value

      let index = $(this).parent().index()
      if (visibleColumnsIndexes !== null) {
        index = visibleColumnsIndexes[index]
      }

      table
        .column(index)
        .search(value, strict)
        .draw()
  });
table.on('column-visibility.dt', function(e, settings, column, state) {
      visibleColumnsIndexes = []
      table.columns(":visible").every(function(colIdx) {
          visibleColumnsIndexes.push(colIdx);
      });
  })
});

</script>
@endsection
