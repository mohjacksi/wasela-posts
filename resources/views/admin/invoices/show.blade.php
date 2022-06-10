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

                    {{-- <a class="btn btn-primary" href="#" onclick="newInvoice()">
                    {{ trans('cruds.invoice.download') }}
                </a> --}}

                    <a class="btn btn-info" href="#" onclick="printInvoice()">
                        {{ trans('cruds.invoice.print') }}
                    </a>
                    <br><br>

                    <ul class="nav nav-pills p-2">
                        <li class="nav-item m-2">
                            <a class="btn btn-outline-success nav-link active" data-toggle="tab"
                                href="#delivered">delivered</a>
                        </li>
                        <li class="nav-item m-2">
                            <a class="btn btn-outline-warning nav-link" data-toggle="tab" href="#rejected">rejected</a>
                        </li>
                    </ul>


                </div>
                <!-- Tab panes -->
                <div class="tab-content" id="print_content">
                    <div class="tab-pane container active" id="delivered">
                        @includeIf('admin.invoices.deliveredInvoice', ['invoice' => $invoice])
                    </div>
                    <div class="tab-pane container fade" id="rejected">
                        @includeIf('admin.invoices.rejectedInvoice', ['invoice' => $invoice])
                    </div>
                </div>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="{{ asset('js/cdnjs/jspdf.min.js') }}"></script>

    <script>
        function newInvoice() {
            $.ajax({
                    method: 'GET',
                    url: "{{ route('admin.invoices.newCreate', $invoice->id) }}",
                })
                .done(function() {
                    location.reload()
                })

        }

        function printInvoice() {
            var myIframe = document.getElementById("print_content");

            myIframe.focus();

            myIframe.print();

            return false;
        }

        function toPDF() {
            var doc = new jsPDF();
            var elementHandler = {
                '#ignorePDF': function(element, renderer) {
                    return true;
                }
            };
            var source = window.document.getElementsByTagName("body")[0];
            doc.fromHTML(
                source,
                15,
                15, {
                    'width': 180,
                    'elementHandlers': elementHandler
                });

            doc.output("dataurlnewwindow");
        }
    </script>
@endsection
