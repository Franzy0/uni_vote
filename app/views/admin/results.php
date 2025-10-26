<!DOCTYPE html>
<html>
<head>
    <title>Election Results</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-white">
<div class="container mt-5">
    <h2 class="text-success">📊 Election Results</h2>
    <canvas id="voteChart" height="150"></canvas>
    <a href="/admin/export_csv" class="btn btn-outline-light mt-4">Export CSV</a>
    <a href="/admin/dashboard" class="btn btn-outline-light mt-4">Back</a>
</div>

<script>
const ctx = document.getElementById('voteChart').getContext('2d');
const chartData = {
    labels: <?= json_encode(array_column($results, 'name')) ?>,
    datasets: [{
        label: 'Total Votes',
        data: <?= json_encode(array_column($results, 'total_votes')) ?>,
        backgroundColor: 'rgba(29, 185, 84, 0.8)',
        borderColor: '#1DB954',
        borderWidth: 1
    }]
};
new Chart(ctx, { type: 'bar', data: chartData });
</script>
</body>
</html>
