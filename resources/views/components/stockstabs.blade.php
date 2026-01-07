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
    <div class="container-fluid">

        <ul class="nav nav-tabs" id="serviceTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ Request::is('admin/stocks') ? 'active' : '' }}"
                 href="{{ url('admin/stocks') }}">
                    List All Stock
                </a>
            </li>
          @if (Auth::user()->email=='husnainbutt047@gmail.com')
  <li class="nav-item" role="presentation">
                <a class="nav-link {{ Request::is('admin/stocks/create')  ? 'active' : '' }}"
                    href="{{ url('admin/stocks/create') }}">
                    Add New Stock
                </a>
            </li>
          @endif
        </ul>


    </div>


    <div class="tab-content">
        <div class="tab-pane fade show active">
            @yield('content3')
        </div>
    </div>

@endsection
