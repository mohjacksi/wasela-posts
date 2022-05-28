@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.invoice.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.invoices.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>

                <a class="btn btn-primary" href="#" onclick="newInvoice()">
                    {{ trans('cruds.invoice.download') }}
                </a>

                <a class="btn btn-info" href="#" onclick="printInvoice()">
                    {{ trans('cruds.invoice.print') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <iframe 
                    name="invoiceData"
                    id="invoiceData" 
                    srcdoc="{{$newInvoice}}"
                    src="#"
                    width="100%"
                    height="500rem"
                ></iframe>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.invoices.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        {{ trans('global.relatedData') }}
    </div>
    <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
        <li class="nav-item">
            <a class="nav-link" href="#invoice_posts" role="tab" data-toggle="tab">
                {{ trans('cruds.post.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="invoice_posts">
            @includeIf('admin.invoices.relationships.invoicePosts', ['posts' => $invoice->invoicePosts])
        </div>
    </div>
</div>
{{-- <iframe 
                    name="iframeid"
                    id="iframeid" 
                    src="http://127.0.0.1:8000/profile/password"
                    width="100%"
                    height="500rem"
                ></iframe>  --}}

{{-- <script src="js/cdnjs/jspdf.min.js"></script> --}}
<script src="{{ asset('js/cdnjs/jspdf.min.js') }}"></script>

<script>
    function newInvoice(){
        $.ajax({
            method: 'GET',
            url: "{{ route('admin.invoices.newCreate', $invoice->id) }}",
            })
            .done(function () { location.reload() })

    }

    function printInvoice(){
        var myIframe = document.getElementById("invoiceData").contentWindow;

        myIframe.focus();

        myIframe.print();

        return false;
    }

    function toPDF(){       
        var pdf = new jsPDF('p', 'in', 'letter');

        // source can be HTML-formatted string, or a reference
        // to an actual DOM element from which the text will be scraped.
        source = $('#iframeid')[0]

        // we support special element handlers. Register them with jQuery-style 
        // ID selector for either ID or node name. ("#iAmID", "div", "span" etc.)
        // There is no support for any other type of selectors 
        // (class, of compound) at this time.
        specialElementHandlers = {
            // element with id of "bypass" - jQuery style selector
            '#emptyid': function(element, renderer){
                // true = "handled elsewhere, bypass text extraction"
                return true
            }
        }

        // all coords and widths are in jsPDF instance's declared units
        // 'inches' in this case
        pdf.fromHTML(
            source // HTML string or DOM elem ref.
            , 0.5 // x coord
            , 0.5 // y coord
            , {
                'width':7.5 // max width of content on PDF
                ,'elementHandlers': specialElementHandlers
            }
        )

        pdf.save('Test.pdf');
    }
</script>
@endsection