@php
    $layout = isset($stock->id) ? 'dashboard.master2' : 'components.stockstabs';
    $title = $stock->id ? 'Admin | Edit Stock' : 'Admin | Add New Stock';
@endphp
@extends($layout)
@section('admin_title', $title)
@section(isset($stock->id) ? 'content2' : 'content3')

    <div class="container-fluid px-3">

        <div class="card shadow-sm bg-white rounded-0">
            <div class="row">
                <div class="col-lg-2 col-md-3 col-6 col-sm-4">
                    <a href="{{ url('admin/stocks') }}"
                        class="btn btn-dark custom-back-button d-flex align-items-center justify-content-center">
                        <i class="bx bx-chevron-left me-1"></i> Back
                    </a>
                </div>
                <div class="col-lg-10 col-md-9 col-sm-8 col-6">
                    <h3 class="mt-1 d-none d-md-block d-lg-block" style="font-family:cursive">
                        {{ $stock->id != null ? 'Edit Stock' : 'Add New Stock' }}
                    </h3>
                    <h5 class="mt-1 d-block d-md-none d-lg-none" style="font-family:cursive">
                        {{ $stock->id != null ? 'Edit Stock' : 'Add New Stock' }}
                    </h5>
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


        <div class="card p-3 mt-3">
            <form action="{{ $stock->id != null ? route('update.stock', ['id' => $stock->id]) : route('submit.stock') }}"
                method="POST">
                @csrf
                <div class="row mt-3">
                    <hr>
                    <h4 class="fw-bold mb-3">Stock Information</h4>
                    <hr>
                    <div class="col-lg-8 col-md-12 col-12">
                        <label for="" class="fw-bold mb-2">Name<span class="text-danger">*</span></label>
                        <input type="text"  required placeholder="Name"
                            value="{{ old('name', $stock->name) }}" class="form-control @error('name') is-invalid @enderror"
                            name="name">
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                </div>












                <div class="row mt-3">
                    <div class="col-lg-4 col-md-4 col-6">
                        <label for="" class="fw-bold mb-2">Quantity<span class="text-danger">*</span></label>
                        <input type="number" min="0" required placeholder="Quantity"
                            value="{{ old('qty', $stock->qty) }}" class="form-control @error('qty') is-invalid @enderror"
                            name="qty">
                        @error('qty')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="col-lg-4 col-md-4 col-6">
                        <label for="" class="fw-bold mb-2">Sale Price<span class="text-danger">*</span></label>
                        <input type="number" min="0" required placeholder="Sale Price"
                            value="{{ old('sale_price', $stock->sale_price) }}" min="1"
                            class="form-control @error('sale_price') is-invalid @enderror" name="sale_price">
                        @error('sale_price')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                </div>

















                <button type="submit" name="action" value="save" class="btn btn-primary mt-3 float-end ms-2"
                    title="Save">
                    {{ $stock->id != null ? 'Update' : 'Save' }} <i class="bx bx-check-circle"></i>
                </button>

                @if ($stock->id == null)
                    <button type="submit" name="action" value="save_add_new" class="btn btn-dark mt-3 float-end"
                        title="Save and Add New">
                        Save & Add New <i class="bx bx-plus-circle"></i>
                    </button>
                @endif

            </form>
        </div>
    </div>



@endsection
