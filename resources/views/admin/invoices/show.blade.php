@extends('layouts.admin')
@section('content')
@section('styles')
<style>

    @media print{
        @page {
            size: a5 landscape;
            margin: 0;
        }
    }
</style>
@endsection
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

                    {{-- <a class="btn btn-primary" href="#" onclick="toPDF()">
                    {{ trans('cruds.invoice.download') }}
                </a> --}}

                    <a class="btn btn-info" href="#" onclick="printInvoice()">
                        {{ trans('cruds.invoice.print') }}
                    </a>

                </div>
                <div id="print_content">
                    @if($invoice->status_id == 3)
                        @includeIf('admin.invoices.deliveredInvoice', ['invoice' => $invoice])
                    @elseif($invoice->status_id == 2)
                
                        @includeIf('admin.invoices.rejectedInvoice', ['invoice' => $invoice])
                    @endif
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
            // var myIframe = document.getElementById("print_content");
            var printContents = document.getElementById("print_content").innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;

        }

        function toPDF() {
            var doc = new jsPDF();
            var elementHTML = $('#print_content').html();
            var specialElementHandlers = {
                '#elementH': function (element, renderer) {
                    return true;
                }
            };
            doc.fromHTML(elementHTML, 15, 15, {
                'width': 170,
                'elementHandlers': specialElementHandlers
            });

            // Save the PDF
            doc.save('sample-document.pdf');
        }
    </script>
@endsection
