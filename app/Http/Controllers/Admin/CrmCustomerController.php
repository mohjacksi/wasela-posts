<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyCrmCustomerRequest;
use App\Http\Requests\StoreCrmCustomerRequest;
use App\Http\Requests\UpdateCrmCustomerRequest;
use App\Models\CrmCustomer;
use App\Models\CrmStatus;
use App\Models\Post;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class CrmCustomerController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('crm_customer_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = CrmCustomer::with(['status'])->select(sprintf('%s.*', (new CrmCustomer())->table));
            $table = Datatables::of($query);

            $table->editColumn('balance', function ($row) {
               
            $balance=0;
            $posts= Post::where([
                ['sender_id','=',$row->id],
                ['invoice_id', '=', null],
                ['status_id', '=', 3], // where status_id == 3 (delivered)
            ])->get();
            if(!$posts->isEmpty()){
                foreach($posts as $post){
                    $balance = $balance + $post->sender_total;
                }
            }
            return $balance;
            });
            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'crm_customer_show';
                $editGate = 'crm_customer_edit';
                $deleteGate = 'crm_customer_delete';
                $crudRoutePart = 'crm-customers';

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
            $table->addColumn('status_name', function ($row) {
                return $row->status ? $row->status->name : '';
            });

            $table->editColumn('email', function ($row) {
                return $row->email ? $row->email : '';
            });
            $table->editColumn('phone', function ($row) {
                return $row->phone ? $row->phone : '';
            });
            $table->editColumn('address', function ($row) {
                return $row->address ? $row->address : '';
            });

            $table->editColumn('capital_default_price', function ($row) {
                return $row->capital_default_price ? $row->capital_default_price : '';
            });

            $table->editColumn('other_default_price', function ($row) {
                return $row->other_default_price ? $row->other_default_price : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'status']);

            return $table->make(true);
        }

        return view('admin.crmCustomers.index');
    }

    public function create()
    {
        abort_if(Gate::denies('crm_customer_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $statuses = CrmStatus::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.crmCustomers.create', compact('statuses'));
    }

    public function store(StoreCrmCustomerRequest $request)
    {
        $crmCustomer = CrmCustomer::create($request->all());

        return redirect()->route('admin.crm-customers.index');
    }

    public function edit(CrmCustomer $crmCustomer)
    {
        abort_if(Gate::denies('crm_customer_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $statuses = CrmStatus::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $crmCustomer->load('status');

        return view('admin.crmCustomers.edit', compact('crmCustomer', 'statuses'));
    }

    public function update(UpdateCrmCustomerRequest $request, CrmCustomer $crmCustomer)
    {
        $crmCustomer->update($request->all());

        return redirect()->route('admin.crm-customers.index');
    }

    public function show(CrmCustomer $crmCustomer)
    {
        abort_if(Gate::denies('crm_customer_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $crmCustomer->load('status', 'customerCrmNotes', 'customerInvoices', 'senderPosts');
        $posts= Post::where([
            ['sender_id','=',$crmCustomer->id],
            ['invoice_id', '=', null],
            ['status_id', '=', 3], // where status_id == 3 (delivered)
        ])->get();

        return view('admin.crmCustomers.show', compact('crmCustomer','posts'));
    }

    public function destroy(CrmCustomer $crmCustomer)
    {
        abort_if(Gate::denies('crm_customer_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $crmCustomer->delete();

        return back();
    }

    public function massDestroy(MassDestroyCrmCustomerRequest $request)
    {
        CrmCustomer::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
