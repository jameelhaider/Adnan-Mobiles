@extends('dashboard.master2')
@section('admin_title', 'Admin | Return History')
@section('content2')
    <div class="container-fluid px-3">
        <div class="card shadow-sm bg-white rounded-0">
            <div class="row">
                <div class="col-lg-3 col-7 col-md-4 col-sm-5">
                     <a href="{{ url('/admin') }}"
                        class="btn btn-primary custom-back-button d-flex align-items-center justify-content-center">
                        <i class="bx bx-home me-1"></i> Dashboard
                    </a>



                </div>
                <div class="col-lg-9 col-5 col-md-8 col-sm-7">

                    <div class="d-flex align-items-center">
                        <h3 class="mt-1 d-none d-md-block d-lg-block" style="font-family: cursive;">Return History</h3>
                        <h5 class="mt-1 d-none d-sm-block d-md-none" style="font-family: cursive;">Return History</h5>
                        <small class="mt-1 d-block d-sm-none d-lg-none d-md-none" style="font-family: cursive;">Return History</small>





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
                        <input type="text" placeholder="Name" class="form-control" value="{{ request()->name }}" name="name">
                    </div>

                    <div class="col-lg-5 col-md-4 col-sm-3 col-6 mt-1 mb-1">
                        <input type="date"  class="form-control" value="{{ request()->date }}" name="date">
                    </div>

                    <div class="col-lg-3 col-md-4 col-sm-6 col-12 mt-1 mb-1">
                        <div class="btn-group w-100">
                            <a href="{{ url('admin/return-history') }}" title="Clear"
                                class="btn btn-outline-danger">Clear</a>
                            <button type="submit" title="Search" class="btn btn-outline-success">Search</button>


                        </div>
                    </div>
                </div>
            </form>
        </div>


        @if ($return_items->count() > 0 && (request()->name || request()->date))
            <div class="alert bg-primary text-white mt-3">
                <strong>{{ $return_items->count() }}
                    {{ $return_items->count() > 0 && $return_items->count() < 2 ? 'Result' : 'Results' }}
                    Found</strong>
            </div>
        @elseif ($return_items->count() < 1 && (request()->name || request()->date))
            <div class="alert bg-warning text-white mt-3">
                <strong>No Results Found !</strong>
            </div>
        @endif


        <div class="card p-2 mb-0">
            @if ($return_items->count() > 0)
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="font-size:14px" class="text-dark fw-bold text-center">#</th>
                                <th style="font-size:14px" class="text-dark fw-bold">Name</th>
                                <th style="font-size:14px" class="text-dark fw-bold">Sale</th>
                                <th style="font-size:14px" class="text-dark fw-bold text-center">Qty</th>
                                <th style="font-size:14px" class="text-dark fw-bold">Total</th>
                                <th style="font-size:14px" class="text-dark fw-bold">Date | Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($return_items as $key => $item)
                                <tr>
                                    <td class="text-dark text-center">{{ ++$key }}</td>
                                    <td class="text-dark fw-bold" style="font-size: 17px">
                                     {{ $item->name }}
                                    </td>
                                    <td class="text-dark">
                                     {{'Rs.'. number_format($item->price) }}
                                    </td>
                                     <td class="text-dark text-center">
                                     {{ $item->qty }}
                                    </td>
                                     <td class="text-dark">
                                     {{'Rs.'. number_format($item->total) }}
                                    </td>

                                    <td class="text-dark"> {{ \Carbon\Carbon::parse($item->created_at)->format('d M y | h:i A') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="float-end mt-2">
                        {{ $return_items->appends(request()->query())->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr class="text-center">
                                <th style="font-size:14px" class="text-dark fw-bold">#</th>
                                <th style="font-size:14px" class="text-dark fw-bold">Name</th>
                                <th style="font-size:14px" class="text-dark fw-bold">Sale</th>
                                <th style="font-size:14px" class="text-dark fw-bold">Qty</th>
                                <th style="font-size:14px" class="text-dark fw-bold">Total</th>
                                <th style="font-size:14px" class="text-dark fw-bold">Date | Time</th>
                            </tr>
                        </thead>
                    </table>
                </div>

                <h4 class="h4 mt-2 text-center text-dark fw-bold">No Data Found!</h4>
            @endif

        </div>
    </div>







@endsection
