@if (isset($statusGate))
    @if ($row->invoice_id == null)
        <a @if ($row->status->id == 3) class="btn btn-xs btn-success disabled"
    @else
    class="btn btn-xs btn-success" @endif
            onclick="changeStatus({{ $row->id }},3)" href="#">
            {{ trans('cruds.post.fields.delivered') }}
        </a>
        <a @if ($row->status->id == 2) class="btn btn-xs btn-warning disabled"
    @else
    class="btn btn-xs btn-warning" @endif
            onclick="changeStatus({{ $row->id }},2)" href="#">
            {{ trans('cruds.post.fields.rejected') }}
        </a>
    @endif
@endif
@can($viewGate)
    <a class="btn btn-xs btn-primary" href="{{ route('admin.' . $crudRoutePart . '.show', $row->id) }}">
        {{ trans('global.view') }}
    </a>
@endcan
@if (!isset($statusGate) && $row->invoice_id == null)
@can($editGate)
    <a class="btn btn-xs btn-info" href="{{ route('admin.' . $crudRoutePart . '.edit', $row->id) }}">
        {{ trans('global.edit') }}
    </a>
@endcan
@endif
@can($deleteGate)
    @if ($row->invoice_id == null)
        <form action="{{ route('admin.' . $crudRoutePart . '.destroy', $row->id) }}" method="POST"
            onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
        </form>
    @endif
@endcan
