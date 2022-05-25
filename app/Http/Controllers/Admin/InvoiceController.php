<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyInvoiceRequest;
use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use App\Models\CrmCustomer;
use App\Models\Invoice;
use App\Models\Post;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

use LaravelDaily\Invoices\Invoice as newInvoice;
use LaravelDaily\Invoices\Classes\Party;
use LaravelDaily\Invoices\Classes\InvoiceItem;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('invoice_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Invoice::with(['customer'])->select(sprintf('%s.*', (new Invoice())->table));
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

            $table->rawColumns(['actions', 'placeholder', 'customer']);

            return $table->make(true);
        }

        $crm_customers = CrmCustomer::get();

        return view('admin.invoices.index', compact('crm_customers'));
    }

    public function create()
    {
        abort_if(Gate::denies('invoice_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $customers = CrmCustomer::pluck('email', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.invoices.create', compact('customers'));
    }

    public function store(StoreInvoiceRequest $request)
    {
        $invoice = Invoice::create($request->all());
        $invoice->load('customer');
        $posts= Post::where([
            ['sender_id','=',$invoice->customer->id],
            ['invoice_id', '=', null],
            ['status_id', '=', 3], // where status_id == 3 (delivered)
        ])->get();
        if(!$posts->isEmpty()){
            foreach($posts as $post){
                $post->update(['invoice_id' => $invoice->id]);
            }
        }
        return redirect()->route('admin.invoices.index');
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

        $invoice->delete();

        return back();
    }

    public function massDestroy(MassDestroyInvoiceRequest $request)
    {
        Invoice::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function newCreate(Invoice $invoice)
    {

        abort_if(Gate::denies('invoice_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $invoice->load('customer', 'invoicePosts');

        $client = new Party([
            'name'          => $invoice->customer->name,
            'phone'         => $invoice->customer->phone,
            'custom_fields' => [
                'address'        => $invoice->customer->address,
            ],
        ]);

        $customer = new Party([
            'custom_fields' => [
                'number of customers'        => count($invoice->invoicePosts),
            ],
        ]);

        $items = [];
        if(!$invoice->invoicePosts->isEmpty()){
            foreach($invoice->invoicePosts as $key=>$post){
                $items[$key] = (new InvoiceItem())->title($post->barcode)->pricePerUnit($post->sender_total);
            }
        }

        $newInvoice = newInvoice::make('Invoice')->template('newInvoice')
            ->series($client->name.$invoice->id)
            ->seller($client)
            ->buyer($customer)
            ->date($invoice->created_at)
            ->dateFormat('m/d/Y')
            ->currencySymbol('$')
            ->currencyCode('USD')
            ->currencyFormat('{SYMBOL}{VALUE}')
            ->currencyThousandsSeparator('.')
            ->currencyDecimalPoint(',')
            ->filename($client->name . ' ' . $invoice->id)
            ->addItems($items)
            // You can additionally save generated invoice to configured disk
            ->save('public');

        $link = $newInvoice->url();

        // And return invoice itself to browser or have a different view
        return $newInvoice->download();

    }

    public function getBalance($id)
    {
        abort_if(Gate::denies('invoice_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $balance=0;
        $posts= Post::where([
            ['sender_id','=',$id],
            ['invoice_id', '=', null],
            ['status_id', '=', 3], // where status_id == 3 (delivered)
        ])->get();
        if(!$posts->isEmpty()){
            foreach($posts as $post){
                $balance = $balance + $post->sender_total;
            }
        }
        return $balance; 
    }
}
