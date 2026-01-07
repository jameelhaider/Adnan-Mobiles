@extends('dashboard.master2')
@section('content2')
    <style>
        .nav-tabs .nav-link.active {
            background-color: #f5f5f5 !important;
            color: rgb(117, 7, 14) !important;

        }

        .nav-tabs .nav-link {
            background-color: #f5f5f5 !important;
            color: rgb(117, 113, 113) !important;
            margin-bottom: 1px;
        }
    </style>
    <div class="container-fluid px-3">

        <ul class="nav nav-tabs" id="serviceTabs" role="tablist">


             @if (Auth::user()->email !== 'husnainbutt047@gmail.com')
                  <li class="nav-item" role="presentation">
                <a class="nav-link {{ Request::is('admin/invoices/make') ? 'active' : '' }}"
                    href="{{ url('admin/invoices/make') }}">
                    Make Sale Invoice
                </a>
            </li>

        @endif


            <li class="nav-item" role="presentation">
                <a class="nav-link {{ Request::is('admin/invoices/list')  ? 'active' : '' }}"
                href="{{ url('admin/invoices/list') }}">
                    List Sale Invoices
                </a>
            </li>

        </ul>


    </div>
    <div class="tab-content">
        <div class="tab-pane fade show active">
            @yield('content4')
        </div>
    </div>

@endsection
