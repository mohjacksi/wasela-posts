<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyGovernorateRequest;
use App\Http\Requests\StoreGovernorateRequest;
use App\Http\Requests\UpdateGovernorateRequest;
use App\Models\Governorate;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class GovernorateController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('governorate_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Governorate::query()->select(sprintf('%s.*', (new Governorate())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'governorate_show';
                $editGate = 'governorate_edit';
                $deleteGate = 'governorate_delete';
                $crudRoutePart = 'governorates';

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
            $table->editColumn('default_price', function ($row) {
                return $row->default_price ? $row->default_price : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.governorates.index');
    }

    public function create()
    {
        abort_if(Gate::denies('governorate_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.governorates.create');
    }

    public function store(StoreGovernorateRequest $request)
    {
        $governorate = Governorate::create($request->all());

        return redirect()->route('admin.governorates.index');
    }

    public function edit(Governorate $governorate)
    {
        abort_if(Gate::denies('governorate_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.governorates.edit', compact('governorate'));
    }

    public function update(UpdateGovernorateRequest $request, Governorate $governorate)
    {
        $governorate->update($request->all());

        return redirect()->route('admin.governorates.index');
    }

    public function show(Governorate $governorate)
    {
        abort_if(Gate::denies('governorate_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $governorate->load('governoratePosts');

        return view('admin.governorates.show', compact('governorate'));
    }

    public function destroy(Governorate $governorate)
    {
        abort_if(Gate::denies('governorate_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $governorate->delete();

        return back();
    }

    public function massDestroy(MassDestroyGovernorateRequest $request)
    {
        Governorate::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
