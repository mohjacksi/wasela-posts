<div class="m-3">
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
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-cityPosts">
                    <thead>
                        <tr>
                            <th width="10">

                            </th>
                            <th>
                                {{ trans('cruds.post.fields.id') }}
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
                                {{ trans('cruds.post.fields.status') }}
                            </th>
                            <th>
                                {{ trans('cruds.post.fields.notes') }}
                            </th>
                            <th>
                                {{ trans('cruds.post.fields.invoice') }}
                            </th>
                            <th>
                                &nbsp;
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($posts as $key => $post)
                            <tr data-entry-id="{{ $post->id }}">
                                <td>

                                </td>
                                <td>
                                    {{ $post->id ?? '' }}
                                </td>
                                <td>
                                    {{ $post->barcode ?? '' }}
                                </td>
                                <td>
                                    {{ $post->sender->name ?? '' }}
                                </td>
                                <td>
                                    {{ $post->sender->name ?? '' }}
                                </td>
                                <td>
                                    {{ $post->receiver_name ?? '' }}
                                </td>
                                <td>
                                    {{ $post->receiver_phone_number ?? '' }}
                                </td>
                                <td>
                                    {{ $post->governorate->name ?? '' }}
                                </td>
                                <td>
                                    {{ $post->city->name ?? '' }}
                                </td>
                                <td>
                                    {{ $post->delivery_address ?? '' }}
                                </td>
                                <td>
                                    {{ $post->sender_total ?? '' }}
                                </td>
                                <td>
                                    {{ $post->delivery_price ?? '' }}
                                </td>
                                <td>
                                    {{ $post->customer_invoice_total ?? '' }}
                                </td>
                                <td>
                                    {{ $post->status->name ?? '' }}
                                </td>
                                <td>
                                    {{ $post->notes ?? '' }}
                                </td>
                                <td>
                                    {{ $post->invoice->amount ?? '' }}
                                </td>
                                <td>
                                    @can('post_show')
                                        <a class="btn btn-xs btn-primary" href="{{ route('admin.posts.show', $post->id) }}">
                                            {{ trans('global.view') }}
                                        </a>
                                    @endcan

                                    @can('post_edit')
                                        <a class="btn btn-xs btn-info" href="{{ route('admin.posts.edit', $post->id) }}">
                                            {{ trans('global.edit') }}
                                        </a>
                                    @endcan

                                    @can('post_delete')
                                        <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                        </form>
                                    @endcan

                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('post_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.posts.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
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

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-cityPosts:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection