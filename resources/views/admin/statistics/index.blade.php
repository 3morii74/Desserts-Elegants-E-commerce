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

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <canvas id="ordersChart" width="400" height="400"></canvas>
                </div>
                <div class="col-md-6">
                    <h4 class="text-teal-800 font-bold">Best Selling Products</h4>
                    <div class="card-deck">
                        @foreach ($topTwoItemsFromTable as $item)
                        <div class="card">
                            <img src="{{ Storage::url($item->image) }}" class="card-img-top mx-auto mt-6 w-48 h-48 rounded" alt="Product" style="width: 200px; height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title text-teal-800">{{$item->name}}</h5>
                                <p class="card-text text-teal-800">{{$item->price}} L.E</p>
                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>

            </div>
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
                backgroundColor: 'rgba(233 213 255)',
                borderColor: 'rgba(107 33 168)',
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
