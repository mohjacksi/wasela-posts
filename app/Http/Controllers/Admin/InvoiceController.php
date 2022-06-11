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

use LaravelDaily\Invoices\Invoice as newInvoice;
use LaravelDaily\Invoices\Classes\Party;
use LaravelDaily\Invoices\Classes\InvoiceItem;

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
        $newInvoice=$this->createInvoice(0,$invoice->id,'arabicInvoice');
        $newInvoice = $newInvoice->toHtml();

        return view('admin.invoices.show', compact('invoice','newInvoice'));
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

    public function newCreate(Invoice $invoice)
    {

        abort_if(Gate::denies('invoice_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $invoice->load('customer', 'invoicePosts');

        $newInvoice=$this->createInvoice($invoice->customer->id,$invoice->id);
        $link = $newInvoice->url();

        // And return invoice itself to browser or have a different view
        return $newInvoice->download();

    }

    public function getBalance(Request $request)
    {
        abort_if(Gate::denies('invoice_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
// dd($request->all());
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

    public function createInvoice($client_id , $invoice_id=null , $template=null)
    {

        abort_if(Gate::denies('invoice_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if($invoice_id){
            $invoice=Invoice::with('customer', 'invoicePosts')->where('id',$invoice_id)->first();
            $client = new Party([
                'name'          => $invoice->customer->name,
                'phone'         => $invoice->customer->phone,
                'address'        => $invoice->customer->address,
            ]);
            if($invoice->invoicePosts->isEmpty()){     
                $client = new Party([
                    'name'          => 'No seller',
                    'phone'         => 'No seller',
                ]);
                $newInvoice = newInvoice::make('invoice')->template('emptyInvoice')
                ->seller($client);
                return $newInvoice;
            }
            $posts=$invoice->invoicePosts;
            $invoiceDate=$invoice->created_at;
        }else{       
            $clientData = CrmCustomer::with('senderPosts','customerInvoices')->where('id',$client_id)->first();
            if(empty($clientData)){     
                $client = new Party([
                    'name'          => 'No seller',
                    'phone'         => 'No seller',
                ]);
                $newInvoice = newInvoice::make('invoice')->template('emptyInvoice')
                ->seller($client);
                return $newInvoice;
            }

            $client = new Party([
                'name'          => $clientData->name,
                'phone'         => $clientData->phone,
                'address'        => $clientData->address,
            ]);
            $posts= Post::with('status')->where([
                ['sender_id','=',$client_id],
                ['invoice_id', '=', null],
                // ['status_id', '=', 3], // where status_id == 3 (delivered)
            ])->get();
            $invoiceDate=now();

            if($posts->isEmpty()){     

            $newInvoice = newInvoice::make('invoice')->template('emptyInvoice')
            ->seller($client);
            return $newInvoice; 
            }
        }
        
        $customer = new Party([
            'custom_fields' => [
                'Number of customers'        => count($posts),
            ],
        ]);

        $items = [];
        if(!$posts->isEmpty()){
            foreach($posts as $key=>$post){
                if($post->status_id != 3){
                    $items[$key] = (new InvoiceItem())->title($post->barcode.' ( '.$post->receiver_name.' : '.$post->delivery_address.' ) ')
                    ->pricePerUnit($post->sender_total)->discount($post->sender_total)->description($post->status->name);
                }else{
                    $items[$key] = (new InvoiceItem())->title($post->barcode.' ( '.$post->receiver_name.' : '.$post->delivery_address.' ) ')
                    ->pricePerUnit($post->sender_total)->discount('0')->description($post->status->name);
                }
                
            }
        }

        if($template == null){
            $template='newInvoice';
        }
        $newInvoice = newInvoice::make('Invoice')->template($template)
            ->series($client->name.now())
            ->seller($client)
            ->buyer($customer)
            ->date($invoiceDate)
            ->dateFormat('m/d/Y')
            ->currencySymbol('$')
            ->currencyCode('USD')
            ->currencyFormat('{SYMBOL}{VALUE}')
            ->currencyThousandsSeparator('.')
            ->currencyDecimalPoint(',')
            ->filename($client->name . ' ' . now())
            ->addItems($items)
            ->save('public');

        return $newInvoice;

    }

}
