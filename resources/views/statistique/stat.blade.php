@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Évolution des ventes</h2>
    <canvas id="ventesChart" width="400" height="200"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('ventesChart').getContext('2d');
    const ventesChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($ventes->pluck('date')) !!},
            datasets: [{
                label: 'Quantité vendue',
                data: {!! json_encode($ventes->pluck('total')) !!},
                backgroundColor: 'rgba(75, 192, 192, 0.3)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 2,
                fill: true,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>
@endsection
