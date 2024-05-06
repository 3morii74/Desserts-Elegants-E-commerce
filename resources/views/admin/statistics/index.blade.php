<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>


    <!-- Page content -->
    <div class="content">
        <!-- Header -->


        <!-- Main content area -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <!-- Orders Chart -->
                    <canvas id="ordersChart" width="400" height="400"></canvas>
                </div>
                <div class="col-md-6">
                    <!-- Best Selling Products -->
                    <h4>Best Selling Products</h4>
                    <div class="card-deck">
                        <!-- Product Card 1 -->
                        @foreach ($topTwoItemsFromTable as $item)
                        <div class="card">
                            <img src="{{ Storage::url($item->image) }}" class="card-img-top" alt="Product 1" style="width: 200px; height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title">{{$item->name}}</h5>
                                <p class="card-text">L.E {{$item->price}}</p>
                                <!-- Add more details if needed -->
                            </div>
                        </div>
                        @endforeach


                        <!-- Add more product cards as needed -->
                    </div>
                </div>

            </div>
            {{-- <div class="row">
                <div class="col-md-6">
                    <!-- New Users -->
                    <h4>New Users</h4>
                    <p>10 new users registered this week.</p>
                </div>
                <div class="col-md-6">
                    <!-- Canceled Orders -->
                    <h4>Canceled Orders</h4>
                    <p>5 orders were canceled in the last month.</p>
                </div>
            </div> --}}
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Custom JS -->
    <script src="scripts.js"></script>
    <script>
        // Sample data for orders chart

        var ordersChartData = {
            labels: {!! json_encode($labels) !!},
            datasets: [{
                label: "Number of Orders",
                data: {!! json_encode($data) !!},
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        };

        // Create orders chart
        var ordersChartCtx = document.getElementById('ordersChart').getContext('2d');
        var ordersChart = new Chart(ordersChartCtx, {
            type: 'bar',
            data: ordersChartData,
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>
</body>
</html>


</x-admin-layout>
