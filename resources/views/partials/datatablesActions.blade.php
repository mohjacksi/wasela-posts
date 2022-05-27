@can($viewGate)
    <a class="btn btn-xs btn-primary" href="{{ route('admin.' . $crudRoutePart . '.show', $row->id) }}">
        {{ trans('global.view') }}
    </a>
@endcan
@can($editGate)
    <a class="btn btn-xs btn-info" href="{{ route('admin.' . $crudRoutePart . '.edit', $row->id) }}">
        {{ trans('global.edit') }}
    </a>
@endcan
@if(isset($statusGate))
    <a class="btn btn-xs btn-success" href="{{ route('admin.post.editStatus',['id'=>$row->id, 'status'=>3]) }}">
        {{ trans('cruds.post.fields.delivered') }}
    </a>
    <a class="btn btn-xs btn-warning" href="{{ route('admin.post.editStatus', ['id'=>$row->id, 'status'=>2]) }}">
        {{ trans('cruds.post.fields.rejected') }}
    </a>
@endif
@can($deleteGate)
@if($row->invoice_id == null)
    <form action="{{ route('admin.' . $crudRoutePart . '.destroy', $row->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
    </form>
@endif
@endcan