@extends('dashboard.master2')
@php
    $title = 'View Sale Invoice | ' . $invoice->id;
@endphp
@section('admin_title', $title)
@section('content2')

    <div class="container-fluid px-3">
        <div class="card shadow-sm bg-white rounded-0">
            <div class="row">
                <div class="col-lg-2 col-3 col-sm-2">
                    <a href="{{ route('invoices.list') }}"
                        class="btn btn-dark custom-back-button d-flex align-items-center justify-content-center">
                        <i class="bx bx-chevron-left me-1"></i> Back
                    </a>
                </div>
                <div class="col-lg-8 col-6 col-sm-8">
                    <h3 class="mt-1 d-none d-md-block d-lg-block" style="font-family:cursive">View Sale Invoice |
                        {{ $invoice->id }}
                    </h3>
                    <small class="mt-1 d-block text-center d-md-none" style="font-family:cursive">View Sale Invoice |
                        {{ $invoice->id }}
                    </small>
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
                background-color: #314861;
            }

            .custom-back-button i {
                font-size: 18px;
            }
        </style>





        <div class="row justify-content-center">
            <div class="col-lg-8 col-12 col-md-10">

                <div class="card mt-2 shadow p-1" style="border-radius: 0%">
                    <div class="d-flex justify-content-between">
                        <a href="javascript:void(0);" class="btn btn-sm me-2"
                            style="background-color: rgb(241, 61, 70);color:white"
                            onclick="copyToClipboard('{{ $invoice->id }}')">
                            Copy Invoice No <i class="bx bx-copy"></i>
                        </a>

                        <button id="downloadImage" class="btn btn-sm btn-dark me-2">Download as Image <i
                                class="bx bx-image"></i></button>
                        <button id="downloadPDF" class="btn btn-sm btn-primary">Download as PDF <i
                                class=" bx bxs-file-pdf"></i></button>
                    </div>
                </div>
                <script>
                    function copyToClipboard(text) {
                        navigator.clipboard.writeText(text).then(function() {
                            alert('Copied: ' + text);
                        }, function(err) {
                            console.error('Failed to copy: ', err);
                        });
                    }
                </script>
                <script>
                    // Function to ignore elements with class 'not-show'
                    function ignoreNotShowElements(element) {
                        return element.classList && element.classList.contains('not-show');
                    }

                    // Download as Image
                    document.getElementById("downloadImage").addEventListener("click", function() {
                        const receipt = document.getElementById("receipt-card");

                        html2canvas(receipt, {
                            ignoreElements: ignoreNotShowElements
                        }).then(canvas => {
                            const link = document.createElement('a');
                            link.download = 'sale-invoice.png';
                            link.href = canvas.toDataURL("image/png");
                            link.click();
                        });
                    });

                    // Download as PDF
                    document.getElementById("downloadPDF").addEventListener("click", function() {
                        const {
                            jsPDF
                        } = window.jspdf;
                        const receipt = document.getElementById("receipt-card");

                        html2canvas(receipt, {
                            scale: 2,
                            ignoreElements: ignoreNotShowElements
                        }).then(canvas => {
                            const imgData = canvas.toDataURL("image/png");

                            const pdf = new jsPDF("p", "mm", "a5");
                            const pdfWidth = pdf.internal.pageSize.getWidth();
                            const pdfHeight = pdf.internal.pageSize.getHeight();

                            const imgWidth = pdfWidth;
                            const imgHeight = (canvas.height * imgWidth) / canvas.width;

                            let heightLeft = imgHeight;
                            let position = 0;

                            // Add first page
                            pdf.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
                            heightLeft -= pdfHeight;

                            // Add more pages if needed
                            while (heightLeft > 0) {
                                position = heightLeft - imgHeight;
                                pdf.addPage();
                                pdf.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
                                heightLeft -= pdfHeight;
                            }

                            pdf.save("sale-invoice.pdf");
                        });
                    });
                </script>




                <div class="card p-4 mt-2" id="receipt-card"
                    style="border-radius: 25px;background-color:rgb(255, 255, 255)">
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-4">
                            <img src="{{ asset('uploads/c2.png') }}" class="img-fluid" height="300px" alt="">
                        </div>
                        <div class="col-lg-9 col-md-9 col-12">
                            <span class="fw-bold text-dark" style="font-size:3em">Adnan Mobiles </span>

                            <div class="p-2">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-6">
                                        <h5 class="fw-bold text-dark">Address :</h5>
                                        <h6 class="text-dark">Sarfaraz Plaza,Ground Floor Shop # 04, Chowk Shugar Mill Rahwali Cantt</h6>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-6">
                                        <h5 class="fw-bold text-dark">Conatct :</h5>
                                        <span class="h5 fw-bold text-dark">Adnan Mansha :</span> <span
                                            class="h6 text-dark">0333-3459011
                                        </span>
                                        {{-- <br>
                                        <span class="h5 fw-bold text-dark">Nasir Ahmad:</span> <span
                                            class="h6 text-dark">0305-5760932</span> --}}
                                    </div>
                                </div>
                            </div>

                        </div>


                    </div>
                    <div class="mt-2" style="background-color: rgba(0, 0, 0, 0.64);height:2px"></div>

                    <h2 class="text-dark text-center fw-bold mt-2">Stock Sale Invoice</h2>
                    <div style="background-color: rgba(0, 0, 0, 0.64);height:2px"></div>


                    <style>
                        .table-borderless-yellow tbody tr {
                            border-bottom: 1px solid rgba(0, 0, 0, 0.286);
                        }

                        .table-borderless-yellow thead tr {
                            border-bottom: 2px solid rgba(0, 0, 0, 0.64);
                        }

                        .table-borderless-yellow td,
                        .table-borderless-yellow th {
                            border: none !important;
                        }
                    </style>
                    <div class="table-responsive">
                        <table class="table table-borderless-yellow">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-dark fw-bold" style="font-size:14px">#</th>
                                    <th scope="col" class="text-dark fw-bold" style="font-size:14px">Name</th>
                                    <th scope="col" class="text-dark fw-bold text-center" style="font-size:14px">
                                        Qty</th>
                                    <th scope="col" class="text-dark fw-bold" style="font-size:14px">Price</th>
                                    <th scope="col" class="text-dark fw-bold" style="font-size:14px">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $totalQty = 0; @endphp
                                @foreach ($invoice_items as $key => $item)
                                    <tr>
                                        <th class="text-dark text-dark" scope="row">{{ ++$key }}</th>
                                        <td class="text-dark">{{ $item->name }}</td>
                                        <td class="text-center text-dark">{{ $item->qty }}</td>
                                        <td class="text-dark">{{ 'Rs.' . number_format($item->price) }}</td>
                                        <td class="text-dark">{{ 'Rs.' . number_format($item->total) }}</td>


                                    </tr>
                                    @php $totalQty += $item->qty; @endphp
                                @endforeach
                                <tr>
                                    <td></td>
                                    <td class="fw-bold text-dark">Total Qty</td>
                                    <td class="text-center text-dark">{{ $totalQty }}</td>
                                    <td colspan="1" class="fw-bold text-dark" style="width: 15%">Total Bill</td>
                                    <td class="text-dark">{{ 'Rs.' . number_format($invoice->total_bill) }}</td>
                                </tr>

                            </tbody>
                        </table>
                    </div>


                        <label class="text-dark mt-2"><strong>Total In Words: </strong>
                            {{ numberToWords($invoice->total_bill) }}</label>







                    <div class="d-flex justify-content-between">

                        <div class="d-block">
                            <h2 class="mt-3 fw-bold text-dark">Invoice To:</h2>
                            <h3 class="fw-light text-dark">Counter Sale</h3>
                        </div>

                        <div class="float-end">
                                <img src="{{ asset('uploads/paidstump.png') }}" height="200px" width="200px"
                                    alt="">
                        </div>
                    </div>








                    <div class="row mt-3">
                        <hr style="border-top: 1px solid rgba(0, 0, 0, 0.286)">
                        <div class="d-flex justify-content-between">
                            <div>
                                <span class="h6 text-dark"><strong class="text-dark">Sale Invoice No:</strong>
                                    {{ $invoice->id }}</span>

                            </div>
                            <div>
                                <span class="h6 float-end text-dark"><strong class="text-dark">Sale Date:</strong>
                                    {{ \Carbon\Carbon::parse($invoice->created_at)->format('F d, Y h:i A') }}</span>
                            </div>
                        </div>

                        <hr style="border-top: 1px solid rgba(0, 0, 0, 0.286)">
                        <h4 class="text-center fw-bold text-dark">Thank You For Bussiness With Us</h4>
                        <hr style="border-top: 1px solid rgba(0, 0, 0, 0.286)">
                    </div>

                </div>


            </div>
        </div>

















    </div>






@endsection
