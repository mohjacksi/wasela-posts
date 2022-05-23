<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyPostStatusRequest;
use App\Http\Requests\StorePostStatusRequest;
use App\Http\Requests\UpdatePostStatusRequest;
use App\Models\PostStatus;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class PostStatusController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('post_status_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = PostStatus::query()->select(sprintf('%s.*', (new PostStatus())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'post_status_show';
                $editGate = 'post_status_edit';
                $deleteGate = 'post_status_delete';
                $crudRoutePart = 'post-statuses';

                return view('partials.datatablesActions', compact(
                'viewGate',
                'editGate',
                'deleteGate',
                'crudRoutePart',
                'row'
            ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.postStatuses.index');
    }

    public function create()
    {
        abort_if(Gate::denies('post_status_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.postStatuses.create');
    }

    public function store(StorePostStatusRequest $request)
    {
        $postStatus = PostStatus::create($request->all());

        return redirect()->route('admin.post-statuses.index');
    }

    public function edit(PostStatus $postStatus)
    {
        abort_if(Gate::denies('post_status_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.postStatuses.edit', compact('postStatus'));
    }

    public function update(UpdatePostStatusRequest $request, PostStatus $postStatus)
    {
        $postStatus->update($request->all());

        return redirect()->route('admin.post-statuses.index');
    }

    public function show(PostStatus $postStatus)
    {
        abort_if(Gate::denies('post_status_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.postStatuses.show', compact('postStatus'));
    }

    public function destroy(PostStatus $postStatus)
    {
        abort_if(Gate::denies('post_status_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $postStatus->delete();

        return back();
    }

    public function massDestroy(MassDestroyPostStatusRequest $request)
    {
        PostStatus::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
