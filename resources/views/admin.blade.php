@extends('dashboard.master2')
@section('admin_title', 'Adnan Mobiles | Dashboard')
@section('content2')
    <style>
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: 0.3s;
            margin-top: 20px;
            overflow: hidden;
            border: 1px solid rgba(0, 0, 0, 0.205);
        }

        .card:hover {
            box-shadow: 0 8px 18px rgba(0, 0, 0, 0.25);
        }

        .card-header {
            background: linear-gradient(135deg, #75070e 70%, #bac2c8 70%);
            padding: 10px 10px;
            color: white;
            font-size: 1.1rem;
            font-weight: 600;
        }

        .card-header:hover {
            background: linear-gradient(135deg, #75070e, #900d13, #bac2c8);
        }

        .card-body {
            font-size: 1.3rem;
            padding: 20px;
            font-weight: 900;
            color: #000000;
            background: #fff4f5;
        }

        .card-icon {
            font-size: 1.5rem;
            margin-right: 10px;
        }
    </style>

    <style>
        .chart-container {
            position: relative;
            height: 300px;
            width: 100%;
            background: linear-gradient(135deg, rgba(106, 102, 102, 0.16), white)
        }

        .chart-container canvas {
            height: 100% !important;
            width: 100% !important;
        }
    </style>

    <div class="container-fluid px-3">

        <h2 class="fw-bold text-center text-dark">Total Rass</h2>

        <div class="row justify-content-around">
            <div class="col-lg-12 col-12 col-md-12 mb-4">
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <div>
                            <i class="card-icon bx bx-wallet"></i> Total Rass
                        </div>
                    </div>

                     <div class="card-body text-center count-animation" data-count="{{ $totalrass }}">
                        RS.0
                    </div>
                </div>
            </div>
        </div>










        <h2 class="fw-bold text-center text-dark">Sale Stats</h2>
        <div class="row justify-content-around">
            <div class="col-lg-12 col-12 col-md-12 mb-4">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <i class="card-icon bx bx-money"></i>
                        OverAll Sale
                    </div>
                    <div class="card-body text-center count-animation" data-count="{{ $overallsale }}">
                        RS.0
                    </div>
                </div>
            </div>



            <div class="col-lg-4 col-12 col-md-6 mb-4">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <i class="card-icon bx bx-money"></i>
                        Today Sale
                    </div>
                    <div class="card-body text-center count-animation" data-count="{{ $todaysale }}">
                        RS.0
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-12 col-md-6 mb-4">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <i class="card-icon bx bx-money"></i>
                        This Week Sale
                    </div>
                    <div class="card-body text-center count-animation" data-count="{{ $thisweeksale }}">
                        RS.0
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-12 col-md-12 mb-4">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <i class="card-icon bx bx-money"></i>
                        This Month Sale
                    </div>
                    <div class="card-body text-center count-animation"
                        data-count="{{ $thismonthsale }}">
                        RS.0
                    </div>
                </div>
            </div>





        </div>
















    </div>


    <script>
        $(document).ready(function() {
            // Initialize counter-up
            $('.count-animation').each(function() {
                var $this = $(this),
                    countTo = $this.attr('data-count');

                $this.prop('Counter', 0).animate({
                    Counter: countTo
                }, {
                    duration: 2000, // Duration of the animation in milliseconds
                    easing: 'swing', // Easing function
                    step: function(now) {
                        $this.text('RS.' + Math.ceil(now).toLocaleString());
                    }
                });
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // Initialize counter-up
            $('.count-animation-2').each(function() {
                var $this = $(this),
                    countTo = $this.attr('data-count');

                $this.prop('Counter', 0).animate({
                    Counter: countTo
                }, {
                    duration: 2000, // Duration of the animation in milliseconds
                    easing: 'swing', // Easing function
                    step: function(now) {
                        $this.text(+Math.ceil(now).toLocaleString());
                    }
                });
            });
        });
    </script>


@endsection
