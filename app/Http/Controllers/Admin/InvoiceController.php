<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyInvoiceRequest;
use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use App\Models\CrmCustomer;
use App\Models\Invoice;
use App\Models\Post;
use App\Models\PostStatus;
use Gate;
use DB;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('invoice_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Invoice::with(['customer','status'])->select(sprintf('%s.*', (new Invoice())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'invoice_show';
                $editGate = 'invoice_edit';
                $deleteGate = 'invoice_delete';
                $crudRoutePart = 'invoices';

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
            $table->addColumn('customer_email', function ($row) {
                return $row->customer ? $row->customer->email : '';
            });

            $table->editColumn('customer.name', function ($row) {
                return $row->customer ? (is_string($row->customer) ? $row->customer : $row->customer->name) : '';
            });
            $table->editColumn('amount', function ($row) {
                return $row->amount ? $row->amount : '';
            });
            $table->editColumn('status_name', function ($row) {
                return $row->status ? $row->status->name : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'customer']);

            return $table->make(true);
        }

        $crm_customers = CrmCustomer::get();
        $status = PostStatus::get();

        return view('admin.invoices.index', compact('crm_customers','status'));
    }

    public function create()
    {
        abort_if(Gate::denies('invoice_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $customers = CrmCustomer::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.invoices.create', compact('customers'));
    }

    public function store(StoreInvoiceRequest $request)
    {
        $invoice = Invoice::create($request->all());
        $invoice->load('customer');
        $posts= Post::where([
            ['sender_id','=',$invoice->customer->id],
            ['invoice_id', '=', null],
            ['status_id', '=', $invoice->status_id], // where status_id == 3 (delivered)
        ])->get();
        if(!$posts->isEmpty()){
            foreach($posts as $post){
                $post->update(['invoice_id' => $invoice->id]);
            }
        }
        return redirect()->route('admin.invoices.show',$invoice->id);
    }

    public function edit(Invoice $invoice)
    {
        abort_if(Gate::denies('invoice_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $customers = CrmCustomer::pluck('email', 'id')->prepend(trans('global.pleaseSelect'), '');

        $invoice->load('customer');

        return view('admin.invoices.edit', compact('customers', 'invoice'));
    }

    public function update(UpdateInvoiceRequest $request, Invoice $invoice)
    {
        $invoice->update($request->all());

        return redirect()->route('admin.invoices.index');
    }

    public function show(Invoice $invoice)
    {
        abort_if(Gate::denies('invoice_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $invoice->load('customer', 'invoicePosts');

        return view('admin.invoices.show', compact('invoice'));
    }

    public function destroy(Invoice $invoice)
    {
        abort_if(Gate::denies('invoice_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if(!$invoice->invoicePosts->isEmpty()){
            foreach($invoice->invoicePosts as $post){
                $post->invoice_id=null;
                $post->save();
            }
        }
        $invoice->delete();

        return back();
    }

    public function massDestroy(MassDestroyInvoiceRequest $request)
    {
        $invoice=Invoice::with('invoicePosts')->whereIn('id', request('ids'))->get();
        if(!$invoice->isEmpty()){
            foreach($invoice as $oneInvoice){
                if(!$oneInvoice->invoicePosts->isEmpty()){
                    foreach($oneInvoice->invoicePosts as $post){
                        $post->invoice_id=null;
                        $post->save();
                    }
                }
            }
        }
        
        $invoice=Invoice::whereIn('id', request('ids'))->delete();


        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function getBalance(Request $request)
    {
        abort_if(Gate::denies('invoice_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $balance=0;
        $posts= Post::with(['governorate', 'city',])->where([
            ['sender_id','=',$request->all()['id']],
            ['invoice_id', '=', null],
            ['status_id', '=', $request->all()['status_id']], // where status_id == 3 (delivered)
        ])->get();
        if(!$posts->isEmpty()){
            foreach($posts as $post){
                $balance = $balance + $post->sender_total;
            }
        }
        $id=DB::select("SHOW TABLE STATUS LIKE 'invoices'");
        $next_id=$id[0]->Auto_increment;
        $customer = CrmCustomer::find($request->all()['id']);
        $invoice=(object)array(
            'id'=>$next_id,
            'customer'=>$customer,
            'created_at'=>null,
            'amount'=>$balance,
        );
        $data[0]= $balance;
        if($request->all()['status_id'] == 3){
            $data[1]= view('admin.invoices.deliveredInvoice', compact('posts','invoice'))->render();
        }elseif($request->all()['status_id'] == 2){
            $data[1]= view('admin.invoices.rejectedInvoice', compact('posts','invoice'))->render();
        }

        return $data; 
    }

}
