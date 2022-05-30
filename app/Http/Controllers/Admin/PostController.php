<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyPostRequest;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\City;
use App\Models\CrmCustomer;
use App\Models\Governorate;
use App\Models\Invoice;
use App\Models\Post;
use App\Models\PostStatus;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class PostController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('post_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Post::with(['sender', 'governorate', 'city', 'status', 'invoice'])->select(sprintf('%s.*', (new Post())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'post_show';
                $editGate = 'post_edit';
                $deleteGate = 'post_delete';
                $statusGate = 'post_status';
                $crudRoutePart = 'posts';

                return view('partials.datatablesActions', compact(
                'viewGate',
                'editGate',
                'deleteGate',
                'statusGate',
                'crudRoutePart',
                'row'
            ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->editColumn('barcode', function ($row) {
                return $row->barcode ? $row->barcode : '';
            });
            $table->addColumn('sender_name', function ($row) {
                return $row->sender ? $row->sender->name : '';
            });

            $table->editColumn('sender.name', function ($row) {
                return $row->sender ? (is_string($row->sender) ? $row->sender : $row->sender->name) : '';
            });
            $table->editColumn('receiver_name', function ($row) {
                return $row->receiver_name ? $row->receiver_name : '';
            });
            $table->editColumn('receiver_phone_number', function ($row) {
                return $row->receiver_phone_number ? $row->receiver_phone_number : '';
            });
            $table->addColumn('governorate_name', function ($row) {
                return $row->governorate ? $row->governorate->name : '';
            });

            $table->addColumn('city_name', function ($row) {
                return $row->city ? $row->city->name : '';
            });

            $table->editColumn('delivery_address', function ($row) {
                return $row->delivery_address ? $row->delivery_address : '';
            });
            $table->editColumn('sender_total', function ($row) {
                return $row->sender_total ? $row->sender_total : '';
            });
            $table->editColumn('delivery_price', function ($row) {
                return $row->delivery_price ? $row->delivery_price : '';
            });
            $table->editColumn('customer_invoice_total', function ($row) {
                return $row->customer_invoice_total ? $row->customer_invoice_total : '';
            });
            $table->addColumn('status_name', function ($row) {
                return $row->status ? $row->status->name : '';
            });

            $table->editColumn('notes', function ($row) {
                return $row->notes ? $row->notes : '';
            });
            $table->addColumn('invoice_amount', function ($row) {
                return $row->invoice ? $row->invoice->amount : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'sender', 'governorate', 'city', 'status', 'invoice']);

            return $table->make(true);
        }

        $crm_customers = CrmCustomer::get();
        $governorates  = Governorate::get();
        $cities        = City::get();
        $post_statuses = PostStatus::get();
        $invoices      = Invoice::get();

        return view('admin.posts.index', compact('crm_customers', 'governorates', 'cities', 'post_statuses', 'invoices'));
    }

    public function create()
    {
        abort_if(Gate::denies('post_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $senders = CrmCustomer::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $governorates = Governorate::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $cities = City::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $statuses = PostStatus::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.posts.create', compact('cities', 'governorates', 'senders', 'statuses'));
    }

    public function store(StorePostRequest $request)
    {
        $post = Post::create($request->all());

        return redirect()->route('admin.posts.index');
    }

    public function edit(Post $post)
    {
        abort_if(Gate::denies('post_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $senders = CrmCustomer::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $governorates = Governorate::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $cities = City::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $statuses = PostStatus::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $post->load('sender', 'governorate', 'city', 'status', 'invoice');

        return view('admin.posts.edit', compact('cities', 'governorates', 'post', 'senders', 'statuses'));
    }

    public function editStatus($id, $status)
    {
        abort_if(Gate::denies('post_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $post=Post::find($id);
        if(!empty($post)){
            $post->status_id=$status;
            $post->save();
            $post->load('status');
            return $post->status->name;
        }
        return null;
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        $post->update($request->all());

        return redirect()->route('admin.posts.index');
    }

    public function show(Post $post)
    {
        abort_if(Gate::denies('post_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $post->load('sender', 'governorate', 'city', 'status', 'invoice');

        return view('admin.posts.show', compact('post'));
    }

    public function destroy(Post $post)
    {
        abort_if(Gate::denies('post_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $post->delete();

        return back();
    }

    public function massDestroy(MassDestroyPostRequest $request)
    {
        Post::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
    
    public function deliveryPrice($id)
    {
        $city=City::find($id);
        return $city->default_price;
    }
    
    public function changeCity($id)
    {
        $cities=Governorate::with('cities')->find($id);
        return $cities->cities;
    }
}
