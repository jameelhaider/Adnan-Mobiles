@extends('components.stockstabs')
@section('admin_title', 'Admin | Stocks')
@section('content3')

    <div class="container-fluid px-3">

        <div class="card shadow-sm bg-white rounded-0">
            <div class="row">
                <div class="col-lg-3 col-6 col-md-4 col-sm-5">
                    @if (Auth::user()->email == 'husnainbutt047@gmail.com')
                        <a href="{{ route('create.stock') }}"
                            class="btn btn-primary custom-back-button d-flex align-items-center justify-content-center">
                            <i class="bx bx-plus me-1"></i>
                            Add New Stock
                        </a>
                    @else
                        <a href="{{ route('admin') }}"
                            class="btn btn-primary custom-back-button d-flex align-items-center justify-content-center">
                            <i class="bx bx-home me-1"></i>
                            Dashboard
                        </a>
                    @endif


                </div>

                {{-- <div class="col-lg-9 col-6 col-md-8 col-sm-7">
                    <div class="d-flex align-items-center">
                        <h3 class="mt-1 d-none d-md-block d-lg-block" style="font-family: cursive;">Stock Items</h3>

                        <h5 class="mt-1 d-block d-lg-none d-md-none d-sm-block" style="font-family: cursive;">Stock Items
                        </h5>


                    </div>
                </div> --}}

                <div class="col-lg-9 col-6 col-md-8 col-sm-7">
                    <div class="d-flex align-items-center gap-2">
                        <h3 class="mt-1 d-none d-md-block d-lg-block" style="font-family: cursive;">Stock Items</h3>

                        <h5 class="mt-1 d-block d-lg-none d-md-none d-sm-block" style="font-family: cursive;">
                            Stock Items
                        </h5>

                        <button type="button" class="btn btn-sm btn-primary" id="copyAvailableParts">
                            Copy Available Parts
                        </button>
                    </div>
                </div>

                <script>
                    document.getElementById('copyAvailableParts').addEventListener('click', function() {
                        fetch("{{ url('/copy-available-stocks') }}")
                            .then(response => response.json())
                            .then(data => {
                                navigator.clipboard.writeText(data.text).then(() => {
                                    alert('Available stock copied successfully!');
                                });
                            })
                            .catch(err => {
                                alert('Something went wrong!');
                            });
                    });
                </script>




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
            <div class="row">
                <div class="col-12">
                    <input type="text" id="live-search" class="form-control" placeholder="Search by name...">
                </div>
            </div>
        </div>


        @if ($stocks->count() > 0 && request()->name)
            <div class="alert bg-primary text-white mt-3">
                <strong>{{ $stocks->count() }} {{ $stocks->count() > 0 && $stocks->count() < 2 ? 'Result' : 'Results' }}
                    Found</strong>
            </div>
        @elseif ($stocks->count() < 1 && request()->name)
            <div class="alert bg-warning text-white mt-3">
                <strong>No Results Found !</strong>
            </div>
        @endif





        <div class="card p-2 mb-0">
            <div id="table-data">
                @include('stocks.partials.table')
            </div>
        </div>


    </div>



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#live-search').on('keyup', function() {
                let value = $(this).val();

                $.ajax({
                    url: "{{ route('stock.index') }}",
                    type: "GET",
                    data: {
                        name: value
                    },
                    success: function(data) {
                        $('#table-data').html(data);
                    }
                });
            });
        });
    </script>


@endsection
