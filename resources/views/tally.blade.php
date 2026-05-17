@extends('dashboard.master2')

@section('admin_title', 'Admin | Tally Stock')

@section('content2')

    <div class="container-fluid px-3">

        <div class="card p-2 mb-0">

            @if ($stocks->count() > 0)

                <div class="table-responsive">
                    <table class="table">

                        <thead>
                            <tr>
                                <th class="fw-bold text-dark">
                                    <label style="cursor:pointer;">
                                        <input type="checkbox" id="selectAll" style="transform: scale(1.5);">
                                        <b> Select All</b>
                                    </label>
                                </th>

                                <th class="text-center text-dark fw-bold">#</th>
                                <th class="text-dark fw-bold">Name</th>
                                <th class="text-center text-dark fw-bold">Expected Qty</th>
                                <th class="text-center text-dark fw-bold">Qty You Have</th>
                                <th class="text-dark fw-bold">Price</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($stocks as $key => $item)
                                <tr>
                                    <td>
                                        <input type="checkbox" class="row-check" data-id="{{ $item->id }}"
                                            data-qty="{{ $item->qty }}" style="transform: scale(1.4);">
                                    </td>

                                    <td class="text-center text-dark">{{ $key + 1 }}</td>

                                    <td style="width:40%; word-break:break-word;" class="text-dark fw-bold">
                                        {{ $item->name }}
                                    </td>

                                    <td class="text-center text-dark">
                                        {{ $item->qty }}
                                    </td>

                                    <td>
                                        <input type="number" class="form-control qty-input" name="qty[{{ $item->id }}]"
                                            min="0" max="{{ $item->qty }}" disabled style="width:100px;">
                                    </td>

                                    <td class="text-dark">
                                        {{ 'Rs.' . number_format($item->sale_price) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>

                {{-- BUTTONS --}}
                <div class="mt-3 d-flex gap-2">
                    <button type="button" id="calcMissingBtn" class="btn btn-primary">
                        Calculate Missing Parts
                    </button>

                    <button type="button" id="resetBtn" class="btn btn-danger">
                        Reset / Tally Again
                    </button>
                </div>

                {{-- RESULT TABLE --}}
                <div class="mt-4" id="missingResult" style="display:none;">

                    <h5 class="fw-bold text-dark">Missing Parts Summary</h5>

                    <div class="table-responsive">
                        <table class="table table-bordered">

                            <thead>
                                <tr>
                                    <th class="text-dark text-center fw-bold">#</th>
                                    <th class="text-dark fw-bold">Name</th>
                                    <th class="text-center fw-bold text-dark">Missed Qty</th>
                                    <th class="text-center fw-bold text-dark">Price</th>
                                    <th class="text-center fw-bold text-dark">Total</th>
                                </tr>
                            </thead>

                            <tbody id="missingBody"></tbody>

                            <tfoot>
                                <tr>
                                    <th colspan="2" class="text-end text-dark fw-bold">Totals:</th>
                                    <th class="text-center text-dark fw-bold" id="totalMissedQty">0</th>
                                    <th></th>
                                    <th class="text-center text-dark fw-bold" id="totalMissedAmount">0</th>
                                </tr>
                            </tfoot>

                        </table>
                    </div>

                </div>
            @else
                <h4 class="text-center text-dark fw-bold mt-3">
                    No Data Found!
                </h4>

            @endif

        </div>
    </div>

    {{-- ================= JS ================= --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const selectAll = document.getElementById('selectAll');
            const calcBtn = document.getElementById('calcMissingBtn');
            const resetBtn = document.getElementById('resetBtn');

            const resultBox = document.getElementById('missingResult');
            const tbody = document.getElementById('missingBody');

            const totalQtyEl = document.getElementById('totalMissedQty');
            const totalAmtEl = document.getElementById('totalMissedAmount');

            function rows() {
                return document.querySelectorAll('.row-check');
            }

            // ================= SELECT ALL =================
            selectAll.addEventListener('change', function() {

                rows().forEach(cb => {
                    cb.checked = selectAll.checked;

                    const tr = cb.closest('tr');
                    const input = tr.querySelector('.qty-input');
                    const maxQty = parseInt(cb.dataset.qty);

                    if (selectAll.checked) {
                        input.disabled = false;
                        input.value = maxQty;
                    } else {
                        input.disabled = true;
                        input.value = '';
                    }
                });

            });

            // sync select all
            document.addEventListener('change', function(e) {
                if (e.target.classList.contains('row-check')) {
                    selectAll.checked = [...rows()].every(cb => cb.checked);
                }
            });

            // ================= CALCULATE =================
            calcBtn.addEventListener('click', function() {

                let totalQty = 0;
                let totalAmount = 0;
                let index = 1;

                tbody.innerHTML = '';

                rows().forEach(cb => {

                    const tr = cb.closest('tr');

                    const expected = parseInt(cb.dataset.qty);
                    const entered = parseInt(tr.querySelector('.qty-input').value || 0);

                    const name = tr.querySelector('td:nth-child(3)').innerText.trim();

                    const priceText = tr.querySelector('td:last-child')
                        .innerText.replace('Rs.', '')
                        .replace(/,/g, '');

                    const price = parseFloat(priceText);

                    const missed = expected - entered;

                    if (missed > 0) {

                        const total = missed * price;

                        totalQty += missed;
                        totalAmount += total;

                        tbody.innerHTML += `
                    <tr>
                        <td class="text-dark text-center">${index++}</td>
                        <td class="text-dark" style="width:45%; word-break:break-word;">${name}</td>
                        <td class="text-center text-dark">${missed}</td>
                        <td class="text-center text-dark">Rs. ${price.toLocaleString()}</td>
<td class="text-center text-dark">Rs. ${total.toLocaleString()}</td>
                    </tr>
                `;
                    }
                });

                totalQtyEl.innerText = totalQty;
                totalAmtEl.innerText = totalAmount.toLocaleString();

                resultBox.style.display = 'block';
            });

            // ================= RESET =================
            resetBtn.addEventListener('click', function() {

                rows().forEach(cb => {
                    cb.checked = false;

                    const tr = cb.closest('tr');
                    const input = tr.querySelector('.qty-input');

                    input.value = '';
                    input.disabled = true;
                });

                selectAll.checked = false;

                tbody.innerHTML = '';
                resultBox.style.display = 'none';

                totalQtyEl.innerText = 0;
                totalAmtEl.innerText = 0;
            });

        });
    </script>

@endsection
