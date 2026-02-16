@extends('components.invoicetabs')
@section('admin_title', 'Admin | List Sale Invoices')
@section('content4')
    <div class="container-fluid px-3">
        <div class="card shadow-sm bg-white rounded-0">
            <div class="row">
                <div class="col-lg-3 col-7 col-md-4 col-sm-5">
                      @if (Auth::user()->email == 'husnainbutt047@gmail.com')
                     <a href="{{ url('/admin') }}"
                        class="btn btn-primary custom-back-button d-flex align-items-center justify-content-center">
                        <i class="bx bx-home me-1"></i> Dashboard
                    </a>
                    @else
                      <a href="{{ url('/admin/invoices/make') }}"
                        class="btn btn-primary custom-back-button d-flex align-items-center justify-content-center">
                        <i class="bx bx-plus me-1"></i> Make Sale Invoice
                    </a>
                    @endif



                </div>
                <div class="col-lg-9 col-5 col-md-8 col-sm-7">

                    <div class="d-flex align-items-center">
                        <h3 class="mt-1 d-none d-md-block d-lg-block" style="font-family: cursive;">List Sale Invoices</h3>
                        <h5 class="mt-1 d-none d-sm-block d-md-none" style="font-family: cursive;">List Sale Invoices</h5>
                        <small class="mt-1 d-block d-sm-none d-lg-none d-md-none" style="font-family: cursive;">List Sale
                            Invoices</small>





                    </div>


                </div>
            </div>
        </div>



        <style>
            .custom-back-button {
                font-size: 16px;
                height: 100%;
                width: 100%;
                border-radius: 0;
                text-decoration: none;
                transition: all 0.3s ease;
                font-weight: 500;
            }

            .custom-back-button:hover {
                background-color: #8c0811;
                border: 0px;
            }

            .custom-back-button i {
                font-size: 18px;
            }
        </style>




        <div class="card mb-2 p-2 mt-2">
            <form action="" method="GET">
                <div class="row">

                     <div class="col-lg-4 col-md-4 col-sm-3 col-6 mt-1 mb-1">
                        <input type="number" placeholder="Invoice No" min="1" class="form-control" value="{{ request()->invoice_no }}" name="invoice_no">
                    </div>

                    <div class="col-lg-5 col-md-4 col-sm-3 col-6 mt-1 mb-1">
                        <input type="date"  class="form-control" value="{{ request()->date }}" name="date">
                    </div>

                    <div class="col-lg-3 col-md-4 col-sm-6 col-12 mt-1 mb-1">
                        <div class="btn-group w-100">
                            <a href="{{ url('admin/invoices/list') }}" title="Clear"
                                class="btn btn-outline-danger">Clear</a>
                            <button type="submit" title="Search" class="btn btn-outline-success">Search</button>


                        </div>
                    </div>
                </div>
            </form>
        </div>


        @if ($invoices->count() > 0 && (request()->date || request()->invoice_no))
            <div class="alert bg-primary text-white mt-3">
                <strong>{{ $invoices->count() }}
                    {{ $invoices->count() > 0 && $invoices->count() < 2 ? 'Result' : 'Results' }}
                    Found</strong>
            </div>
        @elseif ($invoices->count() < 1 && (request()->date || request()->invoice_no))
            <div class="alert bg-warning text-white mt-3">
                <strong>No Results Found !</strong>
            </div>
        @endif


        <div class="card p-2 mb-0">
            @if ($invoices->count() > 0)
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr class="text-center">
                                <th style="font-size:14px" class="text-dark fw-bold">#</th>
                                <th style="font-size:14px" class="text-dark fw-bold">Invoice NO</th>
                                <th style="font-size:14px" class="text-dark fw-bold">Total Bill</th>
                                <th style="font-size:14px" class="text-dark fw-bold">Total Items</th>
                                <th style="font-size:14px" class="text-dark fw-bold">Date</th>
                                <th style="font-size:14px" class="text-dark fw-bold">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoices as $key => $invoice)
                                <tr class="text-center">
                                    <td class="text-dark">{{ ++$key }}</td>
                                    <td class="text-dark">
                                        <a class="nav-link text-dark"
                                            href="{{ route('invoice.view', ['id' => $invoice->id]) }}">{{ $invoice->id }}</a>
                                    </td>




                                    <td class="text-dark fw-bold" style="font-size: 16px" title="{{ 'Rs.' . number_format($invoice->total_bill) }}">


                                        <a class="nav-link text-dark"
                                            href="{{ route('invoice.view', ['id' => $invoice->id]) }}">
                                            {{ 'Rs.' . number_format($invoice->total_bill) }}</a>
                                    </td>
                                    <td title="{{ $invoice->total_items }}">
                                        <span class="badge bg-primary">{{ $invoice->total_items }}</span>
                                    </td>

                                    <td class="text-dark fw-bold" style="font-size: 16px"
                                        title="{{ \Carbon\Carbon::parse($invoice->created_at)->format('d M y, h:i A') }}">
                                        {{ \Carbon\Carbon::parse($invoice->created_at)->format('d M y, h:i A') }}
                                    </td>



                                    <td>

                                        <div class="dropdown ms-auto">
                                            <button class="btn btn-dark btn-sm dropdown-toggle" type="button"
                                                id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                Actions
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end"
                                                aria-labelledby="dropdownMenuButton">
                                                <li> <a class="dropdown-item"
                                                        href="{{ route('invoice.view', ['id' => $invoice->id]) }}">View
                                                        Invoice</a>
                                                </li>
                                            </ul>
                                        </div>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="float-end mt-2">
                        {{ $invoices->appends(request()->query())->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr class="text-center">
                                <th style="font-size:14px" class="text-dark fw-bold">#</th>
                                <th style="font-size:14px" class="text-dark fw-bold">Invoice NO</th>
                                <th style="font-size:14px" class="text-dark fw-bold">Total Bill</th>
                                <th style="font-size:14px" class="text-dark fw-bold">Total Items</th>
                                <th style="font-size:14px" class="text-dark fw-bold">Date</th>
                                <th style="font-size:14px" class="text-dark fw-bold">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>

                <h4 class="h4 mt-2 text-center text-dark fw-bold">No Data Found!</h4>
            @endif

        </div>
    </div>





@endsection
