<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyRepresentativeRequest;
use App\Http\Requests\StoreRepresentativeRequest;
use App\Http\Requests\UpdateRepresentativeRequest;
use App\Models\Representative;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class RepresentativeController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('representative_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Representative::query()->select(sprintf('%s.*', (new Representative())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'representative_show';
                $editGate = 'representative_edit';
                $deleteGate = 'representative_delete';
                $crudRoutePart = 'representatives';

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
            $table->editColumn('phone_number', function ($row) {
                return $row->phone_number ? $row->phone_number : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.representatives.index');
    }

    public function create()
    {
        abort_if(Gate::denies('representative_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.representatives.create');
    }

    public function store(StoreRepresentativeRequest $request)
    {
        $representative = Representative::create($request->all());

        return redirect()->route('admin.representatives.index');
    }

    public function edit(Representative $representative)
    {
        abort_if(Gate::denies('representative_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.representatives.edit', compact('representative'));
    }

    public function update(UpdateRepresentativeRequest $request, Representative $representative)
    {
        $representative->update($request->all());

        return redirect()->route('admin.representatives.index');
    }

    public function show(Representative $representative)
    {
        abort_if(Gate::denies('representative_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.representatives.show', compact('representative'));
    }

    public function destroy(Representative $representative)
    {
        abort_if(Gate::denies('representative_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $representative->delete();

        return back();
    }

    public function massDestroy(MassDestroyRepresentativeRequest $request)
    {
        Representative::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
