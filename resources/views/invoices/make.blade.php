@extends('components.invoicetabs')
@section('admin_title', 'Admin | Make Sale Invoice')
@section('content4')
    <div class="container-fluid px-3">
        <div class="card shadow-sm bg-white rounded-0">
            <div class="row">
                <div class="col-lg-3 col-6 col-md-3 col-sm-4">
                    <a href="{{ url('/admin') }}"
                        class="btn btn-primary custom-back-button d-flex align-items-center justify-content-center">
                        <i class="bx bx-home-circle me-2"></i> Dashboard
                    </a>
                </div>
                <div class="col-lg-9 col-6 col-md-9 col-sm-8">


                    <div class="d-flex align-items-center">
                        <h3 class="mt-1 d-none d-md-block d-lg-block" style="font-family: cursive;">Make Sale Invoice</h3>
                        <h5 class="mt-1 d-block d-sm-block d-lg-none d-md-none" style="font-family: cursive;">Make Sale
                            Invoice
                        </h5>
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
                     <div class="col-lg-9 col-md-8 col-sm-6 col-7 mt-1 mb-1">
                        <input type="text" placeholder="Name" class="form-control" value="{{ request()->name }}" name="name">
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-5 mt-1 mb-1">
                        <div class="btn-group w-100">
                            <a href="{{ url('admin/invoices/make') }}" title="Clear"
                                class="btn btn-outline-danger">Clear</a>
                            <button type="submit" title="Search" class="btn btn-outline-success">Search</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>







        <form action="{{ route('invoice.store') }}" method="POST">
            @csrf

            <div class="card p-2 mb-0 mt-2">

                @if ($stocks->count() > 0)

                    <div class="table-responsive">
                        <table class="table" id="invoiceTable">
                            <thead>
                                <tr>
                                    <th style="font-size:14px;" class="text-dark fw-bold text-center">#</th>
                                    <th style="font-size:14px;" class="text-dark fw-bold">Name</th>
                                    <th style="font-size:14px;" class="text-dark fw-bold">Sale</th>
                                    <th style="font-size:14px;" class="text-dark fw-bold text-center">Avail Qty</th>
                                    <th style="font-size:14px;" class="text-dark fw-bold text-center">Qty</th>
                                    <th style="font-size:14px;" class="text-dark fw-bold text-center">Total</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($stocks as $key => $stock)
                                    <tr data-price="{{ $stock->sale_price }}">
                                        <td class="text-center" style="width: 5%">
                                            <!-- checkbox with unique id -->
                                            <input type="checkbox" class="item-check big-checkbox"
                                                id="item_{{ $stock->id }}" {{ $stock->qty <= 0 ? 'disabled' : '' }}>

                                            <!-- hidden inputs (disabled by default) -->
                                            <input type="hidden" name="stock_id[]" value="{{ $stock->id }}" disabled>
                                            <input type="hidden" name="sale_price[]" value="{{ $stock->sale_price }}"
                                                disabled>
                                            <input type="hidden" name="qty[]" value="1" class="qty-hidden" disabled>
                                        </td>

                                        <style>
                                            .big-checkbox {
                                                transform: scale(1.4);
                                                cursor: pointer;
                                            }
                                        </style>

                                        <td class="text-dark fw-bold" style="font-size: 16px;width:40%">
                                            <!-- Wrap name in label linked to checkbox -->
                                            <label for="item_{{ $stock->id }}" style="cursor:pointer;">
                                                @if ($stock->qty > 0)
                                                    <span style="color: rgb(1, 149, 1);">
                                                        {{ $stock->name }}
                                                    </span>
                                                @else
                                                    <span style="color: rgb(253, 27, 27);">
                                                        {{ $stock->name }}
                                                    </span>
                                                @endif
                                            </label>
                                        </td>


                                        <td class="text-dark fw-bold" style="width:10%">
                                            {{ 'Rs.' . number_format($stock->sale_price) }}
                                        </td>

                                        <td class="text-center text-dark" style="width:10%">{{ $stock->qty }}</td>

                                        <td class="text-center" style="width: 10%">
                                            <input type="number" class="form-control qty-input" min="1"
                                                max="{{ $stock->qty }}" value="1" disabled>
                                        </td>

                                        <td class="text-center fw-bold row-total text-dark" style="width:10%">Rs. 0</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th style="font-size:14px;" class="text-dark fw-bold text-center">#</th>
                                    <th style="font-size:14px;" class="text-dark fw-bold">Name </th>
                                    <th style="font-size:14px;" class="text-dark fw-bold">Sale</th>
                                    <th style="font-size:14px;" class="text-dark fw-bold text-center">Avail Qty </th>
                                    <th style="font-size:14px;" class="text-dark fw-bold text-center">Qty </th>
                                    <th style="font-size:14px;" class="text-dark fw-bold text-center">Total </th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <h4 class="h4 text-center fw-normal text-muted mt-2">No Data Found!</h4>
                @endif

            </div>

            <div
                class="invoice-total-bar shadow-sm mt-2 d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
                <span class="text-dark fw-semibold">Invoice Total</span>
                <h4 class="fw-bold text-dark mb-0">
                    <span id="grandTotal">Rs. 0</span>
                </h4>
                <button type="submit" class="btn btn-primary mt-2 mt-md-0">
                    Make Invoice
                </button>
            </div>


            <style>
                .invoice-total-bar {
                    position: sticky;
                    bottom: 0;
                    background: #ffffff;
                    padding: 14px 18px;
                    border-top: 2px solid #e9ecef;
                    z-index: 999;
                }
            </style>



        </form>

        <script>
            document.addEventListener('DOMContentLoaded', function() {

                function updateTotals() {
                    let grandTotal = 0;

                    document.querySelectorAll('#invoiceTable tbody tr').forEach(row => {
                        const checkbox = row.querySelector('.item-check');
                        const qtyInput = row.querySelector('.qty-input');
                        const price = parseFloat(row.dataset.price);
                        const rowTotalCell = row.querySelector('.row-total');

                        if (checkbox.checked) {
                            const qty = parseInt(qtyInput.value) || 0;
                            const rowTotal = qty * price;
                            rowTotalCell.innerText = 'Rs. ' + rowTotal.toLocaleString();
                            grandTotal += rowTotal;
                        } else {
                            rowTotalCell.innerText = 'Rs. 0';
                        }
                    });

                    document.getElementById('grandTotal').innerText =
                        'Rs. ' + grandTotal.toLocaleString();
                }

                document.querySelectorAll('.item-check').forEach(check => {
                    check.addEventListener('change', function() {
                        const row = this.closest('tr');
                        const qtyInput = row.querySelector('.qty-input');

                        qtyInput.disabled = !this.checked;

                        row.querySelectorAll('input[type="hidden"]').forEach(input => {
                            input.disabled = !this.checked;
                        });

                        if (!this.checked) {
                            qtyInput.value = 1;
                            row.querySelector('.qty-hidden').value = 1;
                        }

                        updateTotals();
                    });
                });

                document.querySelectorAll('.qty-input').forEach(input => {
                    input.addEventListener('input', function() {
                        if (this.value < 1) this.value = 1;
                        if (parseInt(this.value) > parseInt(this.max)) {
                            this.value = this.max;
                        }

                        const row = this.closest('tr');
                        row.querySelector('.qty-hidden').value = this.value;

                        updateTotals();
                    });
                });

            });
        </script>



    </div>
@endsection
