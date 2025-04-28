@extends('layouts.app')


@section('styles')
<style>
    .card-body {
        padding: 20px;
    }
    canvas {
        width: 100% !important;
        height: 100% !important;
    }
</style>

@section('content')
<div class="container">
    <h1 class="mb-4">Tableau de Bord</h1>

    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>Évolution des Transactions par Mois</h3>
                </div>
                <div class="card-body" style="position: relative; height: 50vh;">
                    <canvas id="transactionsChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>État des Stocks par Produit</h3>
                </div>
                <div class="card-body" style="position: relative; height: 50vh; min-height: 400px;">
                    <canvas id="stocksChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Graphique des transactions
        const transactionsCtx = document.getElementById('transactionsChart');
        const transactionsData = @json($transactionsByMonth);

        const months = ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun', 'Jul', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc'];
        const ventesData = new Array(12).fill(0);
        const distributionsData = new Array(12).fill(0);

        Object.entries(transactionsData).forEach(([month, transactions]) => {
            const monthIndex = parseInt(month) - 1;
            transactions.forEach(transaction => {
                if (transaction.type_transaction === 'Vente') {
                    ventesData[monthIndex] = transaction.total_quantite;
                } else if (transaction.type_transaction === 'Distribution') {
                    distributionsData[monthIndex] = transaction.total_quantite;
                }
            });
        });

        new Chart(transactionsCtx, {
            type: 'bar',
            data: {
                labels: months,
                datasets: [
                    {
                        label: 'Ventes',
                        data: ventesData,
                        backgroundColor: 'rgba(54, 162, 235, 0.7)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 2,
                        borderRadius: 5
                    },
                    {
                        label: 'Distributions',
                        data: distributionsData,
                        backgroundColor: 'rgba(255, 99, 132, 0.7)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 2,
                        borderRadius: 5
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            font: {
                                size: 14
                            },
                            padding: 20
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0,0,0,0.7)',
                        titleFont: {
                            size: 16
                        },
                        bodyFont: {
                            size: 14
                        },
                        padding: 12,
                        cornerRadius: 5
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Quantité',
                            font: {
                                size: 14,
                                weight: 'bold'
                            }
                        },
                        ticks: {
                            font: {
                                size: 12
                            }
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Mois',
                            font: {
                                size: 14,
                                weight: 'bold'
                            }
                        },
                        ticks: {
                            font: {
                                size: 12
                            }
                        },
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // Graphique des stocks
        const stocksCtx = document.getElementById('stocksChart');
        const stockData = @json($stockByProduct);

        // Vérification et nettoyage des données
        const labels = Object.keys(stockData).filter(key => stockData[key] > 0);
        const dataValues = Object.values(stockData).filter(val => val > 0);

        if (dataValues.length === 0) {
         stocksCtx.parentElement.innerHTML = '<p class="text-muted">Aucune donnée de stock disponible</p>';
    } else {
        new Chart(stocksCtx, {
            type: 'pie',
            data: {
                labels: Object.keys(stockData),
                datasets: [{
                    data: Object.values(stockData),
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(255, 206, 86, 0.7)',
                        'rgba(75, 192, 192, 0.7)',
                        'rgba(153, 102, 255, 0.7)',
                        'rgba(255, 159, 64, 0.7)'
                    ],
                    borderColor: 'rgba(255, 255, 255, 1)',
                    borderWidth: 2,
                    hoverOffset: 15
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: false,
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            font: {
                                size: 14
                            },
                            padding: 20,
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    },
                    title: {
                        display: true,
                        text: 'Répartition des Stocks par Produit',
                        font: {
                            size: 16,
                            weight: 'bold'
                        },
                        padding: {
                            top: 20,
                            bottom: 20
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0,0,0,0.7)',
                        titleFont: {
                            size: 16
                        },
                        bodyFont: {
                            size: 14
                        },
                        padding: 12,
                        cornerRadius: 5,
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.raw || 0;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = Math.round((value / total) * 100);
                                return `${label}: ${value} (${percentage}%)`;
                            }
                        }
                    }
                },
                cutout: '50%', // Pour un effet doughnut (optionnel)
                spacing: 5
            }
        });
    }
    });
</script>
@endsection
