<!-- resources/views/manager/dashboard.blade.php -->
@extends('layouts.app')

@section('title', 'Manager Dashboard')

@section('content')
<div class="dashboard-container">
    <!-- Title at the top-left -->
    <div class="title">
        <h1>Manager Dashboard</h1>
    </div>

    <!-- Success or Error Messages -->
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- Sales Histograms Side-by-Side -->
    <div class="charts-container">
        <div class="chart-item">
            <h2>Sales Overview</h2>
            <canvas id="salesChart"></canvas>
        </div>
        
        <div class="chart-item">
            <h2>Model Sales Counts</h2>
            <canvas id="modelCountChart"></canvas>
        </div>
    </div>

    <!-- Display number of unsold engines and amounts -->
    <div class="statistics">
        <div class="stat-item">
            <h3>Unsold Engines: <span>{{ $unsoldCount }}</span></h3>
        </div>
        <div class="stat-item">
            <h3>Total Amount Earned: <span>${{ number_format($amountEarned, 2) }}</span></h3>
        </div>
        <div class="stat-item">
            <h3>Expected Amount: <span>${{ number_format($expectedAmount, 2) }}</span></h3>
        </div>
    </div>
    <!-- PDF Report Button -->
<div class="generate-report" style="text-align: center; margin-bottom: 20px;">
    <a href="{{ route('manager.generateReport') }}" class="btn btn-secondary">
        Generate PDF Report
    </a>
</div>

    <!-- Form to Search for an Engine by Serial Number -->
    <div class="search-engine">
        <h2>Update Engine Status</h2>
        <form action="{{ route('manager.searchEngine') }}" method="GET" class="search-form">
            @csrf
            <input type="text" name="serial_number" id="serial_number" placeholder="Enter Serial Number" required>
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
    </div>

    <!-- Form to update engine status -->
    <div class="update-status">
        @isset($engine)
            <form action="{{ route('manager.updateStatus', $engine->id) }}" method="POST">
                @csrf
                @method('PUT')
                <label for="status">Change Status:</label>
                <select name="status" id="status" required>
                    <option value="sold" {{ $engine->status == 'sold' ? 'selected' : '' }}>Sold</option>
                    <option value="unsold" {{ $engine->status == 'unsold' ? 'selected' : '' }}>Unsold</option>
                </select>
                <button type="submit" class="btn btn-primary">Update Status</button>
            </form>
        @else
            <p>No engine selected for updating.</p>
        @endisset
    </div>
</div>


<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Data for the chart
    const labels = @json(array_keys($monthlySales)); // Last 6 months as labels
    const data = @json(array_values($monthlySales)); // Sales data for each month

    // Configure the chart
    const ctx = document.getElementById('salesChart').getContext('2d');
    const salesChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Monthly Sales',
                data: data,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Months'
                    },
                },
                y: {
                    title: {
                        display: true,
                        text: 'Number of Sales'
                    },
                    beginAtZero: true, // Ensure it starts at 0
                    max: 12,           // Set the maximum value to 12
                    ticks: {
                        stepSize: 2    // Increment y-axis values by 2
                    }
                }
            }
        }
    });
    
    const modelCountChartCtx = document.getElementById('modelCountChart').getContext('2d');
    const modelCountChart = new Chart(modelCountChartCtx, {
        type: 'bar',
        data: {
            labels: ['Skygo', 'Honda', 'Yamaha'],
            datasets: [{
                label: '# of Sales per Model',
                data: [{{ $modelSalesCounts['Skygo'] ?? 0 }}, {{ $modelSalesCounts['Honda'] ?? 0 }}, {{ $modelSalesCounts['Yamaha'] ?? 0 }}],
                backgroundColor: ['#FF5722', '#9E9E9E', '#4CAF50']
            }]
        },
        options: {
            scales: {
                y: { beginAtZero: true, max: 16, ticks: { stepSize: 2 } }
            }
        }
    });
</script>

<style>
    .dashboard-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 30px;
        background-color: #f4f6f8;
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .title h1 {
        font-size: 32px;
        font-weight: bold;
        color: #333;
        margin-bottom: 20px;
    }

    .alert {
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 20px;
        font-size: 14px;
    }

    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    .charts-container {
        display: flex;
        gap: 20px;
        margin-bottom: 30px;
    }

    .chart-item {
        flex: 1;
        text-align: center;
    }

    .chart-item h2 {
        font-size: 20px;
        color: #444;
        margin-bottom: 10px;
    }

    .chart-item canvas {
        max-width: 400px;
        max-height: 300px;
        width: 100%;
        height: auto;
    }

    .statistics {
        display: flex;
        justify-content: space-around;
        gap: 20px;
        margin-bottom: 30px;
        text-align: center;
    }

    .stat-item h3 {
        font-size: 18px;
        color: #555;
    }

    .stat-item span {
        font-weight: bold;
        color: #007bff;
    }

    .search-engine {
        background-color: #ffffff;
        padding: 20px;
        border-radius: 5px;
        margin-bottom: 30px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .search-engine h2 {
        font-size: 18px;
        margin-bottom: 10px;
        color: #555;
    }

    .search-form input[type="text"] {
        width: 80%;
        padding: 10px;
        margin-right: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
    }

    .update-status {
        text-align: center;
    }

    .update-status form {
        display: inline-block;
        text-align: left;
    }

    .update-status label {
        font-size: 16px;
        color: #555;
    }

    .update-status select {
        padding: 5px;
        margin: 0 10px;
        border-radius: 5px;
        border: 1px solid #ddd;
    }

    .btn {
        padding: 10px 20px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .btn:hover {
        background-color: #0056b3;
    }

    .generate-report {
        text-align: right;
        margin-top: 20px;
    }

    .generate-report .btn {
        padding: 8px 16px;
        font-size: 14px;
        font-weight: bold;
        background-color: #6c757d;
        color: white;
        border: none;
        border-radius: 5px;
        text-decoration: none;
    }

    .generate-report .btn:hover {
        background-color: #5a6268;
    }
</style>
@endsection
