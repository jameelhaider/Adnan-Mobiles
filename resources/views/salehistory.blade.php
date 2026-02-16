@extends('dashboard.master2')
@section('admin_title', 'Admin | Sale History')
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
                        <h3 class="mt-1 d-none d-md-block d-lg-block" style="font-family: cursive;">Sale History</h3>
                        <h5 class="mt-1 d-none d-sm-block d-md-none" style="font-family: cursive;">Sale History</h5>
                        <small class="mt-1 d-block d-sm-none d-lg-none d-md-none" style="font-family: cursive;">Sale
                            History</small>





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
                        <input type="text" placeholder="Name" class="form-control" value="{{ request()->name }}"
                            name="name">
                    </div>

                    <div class="col-lg-5 col-md-4 col-sm-3 col-6 mt-1 mb-1">
                        <input type="date" class="form-control" value="{{ request()->date }}" name="date">
                    </div>

                    <div class="col-lg-3 col-md-4 col-sm-6 col-12 mt-1 mb-1">
                        <div class="btn-group w-100">
                            <a href="{{ url('admin/sale-history') }}" title="Clear"
                                class="btn btn-outline-danger">Clear</a>
                            <button type="submit" title="Search" class="btn btn-outline-success">Search</button>


                        </div>
                    </div>
                </div>
            </form>
        </div>


        @if ($invoice_items->count() > 0 && (request()->name || request()->date))
            <div class="alert bg-primary text-white mt-3">
                <strong>{{ $invoice_items->count() }}
                    {{ $invoice_items->count() > 0 && $invoice_items->count() < 2 ? 'Result' : 'Results' }}
                    Found</strong>
            </div>
        @elseif ($invoice_items->count() < 1 && (request()->name || request()->date))
            <div class="alert bg-warning text-white mt-3">
                <strong>No Results Found !</strong>
            </div>
        @endif


        <div class="card p-2 mb-0">
            @if ($invoice_items->count() > 0)
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
                                <th style="font-size:14px" class="text-dark fw-bold">No | View | Return</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoice_items as $key => $item)
                                <tr>
                                    <td class="text-dark text-center">{{ ++$key }}</td>
                                    <td class="text-dark fw-bold" style="font-size: 14px;width:40%">
                                        {{ $item->name }}
                                        <br>
                                        @if ($item->status=='Partial Returned')
                                        <span style="font-size: 10px;color:red">{{ $item->partial_qty }} pcs returned consider sale qty as {{ $item->qty-$item->partial_qty }} and total as {{ 'Rs.'.number_format(($item->qty-$item->partial_qty)*$item->price) }}</span>
                                        @endif
                                    </td>
                                    <td class="text-dark">
                                        {{ 'Rs.' . number_format($item->price) }}
                                    </td>
                                    <td class="text-dark text-center">
                                        {{ $item->qty }}
                                    </td>
                                    <td class="text-dark">
                                        {{ 'Rs.' . number_format($item->total) }}
                                    </td>

                                    <td class="text-dark fw-bold" style="font-size: 16px">
                                        {{ \Carbon\Carbon::parse($item->created_at)->format('d M y | h:i A') }}</td>


                                    <td> <a href="{{ route('invoice.view', ['id' => $item->invoice_id]) }}" target="_Blank"
                                            class="btn btn-xs btn-primary mt-1"> {{ $item->invoice_id }} | View</a>


                                        @if (Auth::user()->email !== 'husnainbutt047@gmail.com')
                                            @if ($item->stock_id != null && $item->status != 'Returned')
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#returnModal"
                                                    data-invoice-id="{{ $item->invoice_id }}"
                                                    data-item-id="{{ $item->id }}"
                                                    data-item-name="{{ $item->name }}"
                                                    data-item-qty="{{ $item->qty }}"
                                                    data-item-status="{{ $item->status }}"
                                                    data-item-partial-qty="{{ $item->partial_qty ?? 0 }}"
                                                    data-item-price="{{ $item->price }}"
                                                    class="btn btn-danger btn-xs mt-1">Return <i class="bx bx-undo"></i></a>
                                            @else
                                                <span class="fw-light" style="color: rgb(253, 27, 27)">Returned</span>
                                            @endif
                                        @endif




                                    </td>





                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="float-end mt-2">
                        {{ $invoice_items->appends(request()->query())->links('pagination::bootstrap-5') }}
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
                                <th style="font-size:14px" class="text-dark fw-bold">No | View | Return</th>
                            </tr>
                        </thead>
                    </table>
                </div>

                <h4 class="h4 mt-2 text-center text-dark fw-bold">No Data Found!</h4>
            @endif

        </div>
    </div>









    <!-- Return Modal -->
    <div class="modal fade" id="returnModal" tabindex="-1" aria-labelledby="returnModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('return.invoice.item') }}" method="POST">
                @csrf
                <input type="hidden" name="invoice_id" id="modalInvoiceId">
                <input type="hidden" name="item_id" id="modalItemId">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="returnModalLabel">Return Item</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <p><strong>Item Name:</strong> <span id="modalItemName" class="text-danger fw-bold"></span>
                        </p>
                        <p><strong>Actual Qty:</strong> <span id="modalActualQty" class="fw-bold text-danger"></span>
                        </p>
                        <p><strong>Already Returned:</strong> <span id="modalReturnedQty"
                                class="fw-bold text-danger"></span></p>
                        <p><strong>Returnable Qty:</strong> <span id="modalReturnableQty"
                                class="text-danger fw-bold"></span></p>
                        <p><strong>Status:</strong> <span id="modalStatus" class="text-danger fw-bold"></span></p>

                        <!-- Action Dropdown -->
                        <div id="actionWrapper">
                            <label for="actionSelect" class="fw-bold">Select Action <span
                                    class="text-danger">*</span></label>
                            <select name="action" class="form-select" id="actionSelect">
                                <option value="">Select Option</option>
                                <option value="Return Complete Item">Return Complete Item</option>
                                <option value="Return Some Qty">Return Some Qty</option>
                            </select>
                        </div>

                        <!-- Quantity Input -->
                        <div id="qtyWrapper" class="mt-2" style="display: none;">
                            <label for="returnQty" class="fw-bold">Return Qty <span class="text-danger">*</span></label>
                            <input type="number" min="1" name="return_qty" class="form-control" id="returnQty"
                                placeholder="Qty To Return">
                        </div>

                        <div class="mt-2">
                            <label for="returnPrice" class="fw-bold">Return Price <span
                                    class="text-danger">*</span></label>
                            <input type="number" readonly min="1" name="return_price" class="form-control"
                                id="returnPrice" placeholder="Return Price">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">Yes, Return</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <script>
        const returnModal = document.getElementById('returnModal');
        const modalInvoiceId = document.getElementById('modalInvoiceId');
        const modalItemId = document.getElementById('modalItemId');
        const modalItemName = document.getElementById('modalItemName');
        const modalActualQty = document.getElementById('modalActualQty');
        const modalReturnedQty = document.getElementById('modalReturnedQty');
        const modalReturnableQty = document.getElementById('modalReturnableQty');
        const modalStatus = document.getElementById('modalStatus');
        const actionWrapper = document.getElementById('actionWrapper');
        const actionSelect = document.getElementById('actionSelect');
        const qtyWrapper = document.getElementById('qtyWrapper');
        const qtyInput = document.getElementById('returnQty');
        const priceInput = document.getElementById('returnPrice');

        const resetFields = (returnableQty, itemPrice) => {
            actionWrapper.style.display = 'block';
            actionSelect.value = '';
            qtyWrapper.style.display = 'none';
            qtyInput.value = '';
            qtyInput.removeAttribute('readonly');
            qtyInput.removeAttribute('required');
            qtyInput.setAttribute('max', returnableQty);
            actionSelect.removeAttribute('required');
            priceInput.value = itemPrice ?? '';
        };

        const setQtyField = (value, readonly = false, required = true, maxQty = null) => {
            qtyWrapper.style.display = 'block';
            qtyInput.value = value;
            readonly ? qtyInput.setAttribute('readonly', 'readonly') : qtyInput.removeAttribute('readonly');
            required ? qtyInput.setAttribute('required', 'required') : qtyInput.removeAttribute('required');
            if (maxQty) {
                qtyInput.setAttribute('max', maxQty);
            } else {
                qtyInput.removeAttribute('max');
            }
        };

        const handleActionChange = (returnableQty) => {
            const action = actionSelect.value;
            if (action === 'Return Some Qty') {
                setQtyField('', false, true, returnableQty - 1);
            } else if (action === 'Return Complete Item') {
                setQtyField(returnableQty, true, true, returnableQty);
            } else {
                qtyWrapper.style.display = 'none';
                qtyInput.value = '';
                qtyInput.removeAttribute('readonly');
                qtyInput.removeAttribute('required');
                qtyInput.removeAttribute('max');
            }
        };

        returnModal.addEventListener('show.bs.modal', (event) => {
            const button = event.relatedTarget;

            const invoiceId = button.getAttribute('data-invoice-id');
            const itemId = button.getAttribute('data-item-id');
            const itemName = button.getAttribute('data-item-name');
            const itemQty = parseInt(button.getAttribute('data-item-qty')) || 0;
            const itemPrice = button.getAttribute('data-item-price');
            const itemStatus = button.getAttribute('data-item-status')?.trim();
            const partialQty = parseInt(button.getAttribute('data-item-partial-qty')) || 0;

            modalInvoiceId.value = invoiceId;
            modalItemId.value = itemId;
            modalItemName.textContent = itemName;
            modalActualQty.textContent = itemQty;
            modalReturnedQty.textContent = partialQty;
            modalStatus.textContent = itemStatus;

            // Calculate returnable qty
            let returnableQty = itemQty - partialQty;
            modalReturnableQty.textContent = returnableQty;

            resetFields(returnableQty, itemPrice);

            if (returnableQty === 1) {
                actionWrapper.style.display = 'none';
                actionSelect.value = 'Return Complete Item';
                actionSelect.removeAttribute('required');
                setQtyField(1, true, true, 1);
            } else {
                actionWrapper.style.display = 'block';
                actionSelect.setAttribute('required', 'required');
            }

            actionSelect.onchange = () => handleActionChange(returnableQty);
        });
    </script>
@endsection
