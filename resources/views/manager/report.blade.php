<!DOCTYPE html>
<html>
<head>
    <title>Manager Report</title>
</head>
<body>
    <h1>Sales Report</h1>

    <h2>Summary</h2>
    <p>Daily sales: {{ $dailySales }}</p>
    <p>Weekly sales: {{ $weeklySales }}</p>
    <p>Monthly sales: {{ $monthlySales }}</p>

    <h2>Model Sales Counts</h2>
    <ul>
        @foreach ($modelSalesCounts as $model => $count)
            <li>{{ $model }}: {{ $count }}</li>
        @endforeach
    </ul>

    <h2>Insights</h2>
    @if ($modelSalesCounts->isNotEmpty())
        @php
            $mostSoldModel = $modelSalesCounts->keys()->first(); // Assuming sorted with the most sold on top
            $leastSoldModel = $modelSalesCounts->keys()->last();
        @endphp

        <p>The {{ $mostSoldModel }} model was the most sold model this period, indicating high demand.</p>
        <p>The {{ $leastSoldModel }} model had the fewest sales, which may require further analysis.</p>
    @endif

    <h2>Financial Summary</h2>
    <p>Total amount earned: {{ $amountEarned }}</p>
    <p>Expected amount (based on unsold inventory): {{ $expectedAmount }}</p>

    @if ($amountEarned < $expectedAmount)
        <p>There is a shortfall of {{ $expectedAmount - $amountEarned }}, indicating potential issues in sales tracking.</p>
    @else
        <p>Revenue meets or exceeds expectations, indicating good sales performance.</p>
    @endif
</body>
</html>
