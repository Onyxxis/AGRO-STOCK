<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard - Statistiques</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --primary-color: #38a169;
            --secondary-color: #276749;
            --light-bg: #f7fafc;
            --sidebar-width: 280px;
            --sidebar-collapsed-width: 70px;
            --navbar-height: 70px;
        }

        body {
            font-family: "Poppins", sans-serif;
            background-color: var(--light-bg);
            display: flex;
            min-height: 100vh;
            margin: 0;
            padding-top: var(--navbar-height);
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        a:hover,
        a:focus {
            color: inherit;
        }

        .top-navbar {
            height: var(--navbar-height);
            background-color: white;
            position: fixed;
            top: 0;
            right: 0;
            left: 0;
            z-index: 1030;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .sidebar {
            width: var(--sidebar-width);
            background-color: white;
            color: #2d3748;
            padding-top: 1.5rem;
            transition: all 0.3s ease;
            position: fixed;
            height: calc(100vh - var(--navbar-height));
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            z-index: 1020;
            top: var(--navbar-height);
            display: flex;
            flex-direction: column;
        }

        .sidebar.collapsed {
            width: var(--sidebar-collapsed-width);
        }

        .sidebar .logo {
            text-align: center;
            margin-bottom: 1rem;
            padding: 0 1rem;
            flex-shrink: 0;
        }

        .sidebar .logo h4 {
            color: var(--primary-color);
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .sidebar .logo i {
            font-size: 1.5rem;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
            margin: 0;
            flex-grow: 1;
        }

        .sidebar ul li {
            padding: 0.8rem 1.5rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all 0.3s ease;
            margin: 4px 8px;
            border-radius: 8px;
        }

        .sidebar ul li i {
            font-size: 1.2rem;
            width: 24px;
            text-align: center;
        }

        .sidebar ul li:hover {
            background-color: var(--primary-color);
            color: white;
        }

        .sidebar.collapsed .logo h4 span,
        .sidebar.collapsed ul li span {
            display: none;
        }

        .collapse-toggle {
            position: relative;
            margin: 20px auto;
            cursor: pointer;
            background-color: var(--primary-color);
            color: white;
            padding: 8px;
            border-radius: 50%;
            transition: all 0.3s ease;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .collapse-toggle:hover {
            background-color: var(--secondary-color);
        }

        .sidebar.collapsed .collapse-toggle {
            transform: rotate(180deg);
        }

        .content {
            flex-grow: 1;
            padding: 2rem;
            margin-left: var(--sidebar-width);
            transition: all 0.3s ease;
        }

        .content.collapsed {
            margin-left: var(--sidebar-collapsed-width);
        }

        .search-bar {
            position: relative;
            max-width: 300px;
        }

        .search-bar i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #718096;
        }

        .search-bar input {
            padding-left: 40px;
            border-radius: 20px;
            border: 1px solid #e2e8f0;
            background-color: #f7fafc;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-info .avatar {
            width: 40px;
            height: 40px;
            background-color: var(--primary-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            cursor: pointer;
        }

        .user-info span {
            color: #2d3748;
            font-weight: 500;
        }

        .dropdown-menu {
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            min-width: 120px;
        }

        .dropdown-item {
            padding: 8px 16px;
            color: #2d3748;
        }

        .dropdown-item:hover {
            background-color: #f7fafc;
            color: var(--primary-color);
        }

        .welcome-section {
            background-color: white;
            border-radius: 12px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .welcome-section h2 {
            color: #2d3748;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .welcome-section p {
            color: #718096;
            margin-bottom: 0;
        }

        /* Styles pour les cartes de statistiques */
        .stats-card {
            background-color: white;
            border-radius: 12px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .stats-card .card-header {
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 1rem;
            margin-bottom: 1.5rem;
        }

        .stats-card .card-header h3 {
            color: #2d3748;
            font-weight: 600;
            margin: 0;
        }

        .chart-container {
            position: relative;
            height: 50vh;
            min-height: 400px;
            width: 100%;
        }

        canvas {
            width: 100% !important;
            height: 100% !important;
        }

        /* Styles pour les KPI */
        .kpi-card {
            border-radius: 12px;
            border: none;
            transition: transform 0.3s ease;
            height: 100%;
            color: white;
            padding: 1.5rem;
        }

        .kpi-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        .kpi-card .card-title {
            font-size: 1rem;
            margin-bottom: 0.5rem;
            opacity: 0.9;
        }

        .kpi-card .card-value {
            font-size: 2rem;
            font-weight: 600;
            margin: 0.5rem 0;
        }

        .kpi-card .card-trend {
            font-size: 0.9rem;
            margin-bottom: 0;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        /* Styles pour le tableau */
        .table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 10px;
        }

        .table th {
            background-color: #f8f9fa;
            border: none;
            padding: 12px 15px;
            font-weight: 600;
        }

        .table td {
            background-color: white;
            padding: 12px 15px;
            vertical-align: middle;
            border: none;
        }

        .table tr {
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            border-radius: 8px;
        }

        .table tr:hover td {
            background-color: #f8f9fa;
        }

        #loading-screen {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.9);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        #loading-video {
            width: 200px;
            height: 200px;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: var(--sidebar-collapsed-width);
                transform: translateX(-100%);
            }

            .sidebar.collapsed {
                transform: translateX(0);
            }

            .content {
                margin-left: 0;
            }

            .content.collapsed {
                margin-left: var(--sidebar-collapsed-width);
            }

            .chart-container {
                height: 300px;
            }

            .kpi-card .card-value {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div id="loading-screen">
        <video id="loading-video" autoplay loop muted>
            <source src="{{ asset('loading.mp4') }}" type="video/mp4" />
        </video>
    </div>

    <nav class="top-navbar">
        <div class="search-bar">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Rechercher..." class="form-control" disabled />
        </div>
        <div class="user-info">
            <span>{{ Auth::user()->name }}</span>
            <div class="dropdown">
                <div class="avatar" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-user"></i>
                </div>
                <ul class="dropdown-menu">
                    <li>
                        <a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="fas fa-user-cog me-2"></i>Profil</a>
                    </li>
                    <li><hr class="dropdown-divider" /></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); this.closest('form').submit();">
                                <i class="fas fa-sign-out-alt me-2"></i>Déconnexion
                            </a>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="sidebar" id="sidebar">
        <div class="logo">
            <h4>
                <i class="fas fa-leaf"></i>
                <span>Agro Stock</span>
            </h4>
            <hr />
        </div>
        <ul>
            <li>
                <a href="/dashboard">
                    <i class="fas fa-home"></i>
                    <span>Accueil</span>
                </a>
            </li>
            <li>
                <a href="/produit">
                    <i class="fas fa-box"></i>
                    <span>Produits</span>
                </a>
            </li>
            <li>
                <a href="/stockage">
                    <i class="fas fa-warehouse"></i>
                    <span>Stock</span>
                </a>
            </li>
            <li>
                <a href="/transaction">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Commandes</span>
                </a>
            </li>
            <li class="active">
                <a href="/statistique">
                    <i class="fas fa-chart-bar"></i>
                    <span>Rapports</span>
                </a>
            </li>
        </ul>
        <div class="collapse-toggle" id="collapseToggle">
            <i class="fas fa-chevron-left"></i>
        </div>
    </div>

    <div class="content" id="content">
        <div class="welcome-section">
            <h2>Tableau de Bord Statistique</h2>
            <p>Visualisation des données clés de votre activité</p>
        </div>

        <!-- Indicateurs clés (KPI) -->
        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <div class="kpi-card bg-primary">
                    <h5 class="card-title">Total Ventes</h5>
                    <h2 class="card-value">{{ number_format($totalVentes) }} unités</h2>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="kpi-card bg-success">
                    <h5 class="card-title">Chiffre d'Affaires</h5>
                    <h2 class="card-value">{{ number_format($chiffreAffaires, 0, ',', ' ') }} FCFA</h2>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="kpi-card bg-info">
                    <h5 class="card-title">Stock Total</h5>
                    <h2 class="card-value">{{ number_format($totalStock) }} unités</h2>
                </div>
            </div>
        </div>

        <!-- Tableau des produits les plus vendus -->
        <div class="stats-card">
            <div class="card-header">
                <h3>Top 5 des Produits</h3>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Produit</th>
                            <th>Ventes</th>
                            <th>Distributions</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($topProduits as $produit)
                        <tr>
                            <td>{{ $produit->nom }}</td>
                            <td>{{ $produit->ventes }}</td>
                            <td>{{ $produit->distributions }}</td>
                            <td>{{ $produit->ventes + $produit->distributions }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Graphiques existants -->
        <div class="stats-card">
            <div class="card-header">
                <h3>Évolution des Transactions par Mois</h3>
            </div>
            <div class="chart-container">
                <canvas id="transactionsChart"></canvas>
            </div>
        </div>

        <div class="stats-card">
            <div class="card-header">
                <h3>État des Stocks par Produit</h3>
            </div>
            <div class="chart-container">
                <canvas id="stocksChart"></canvas>
            </div>
        </div>
    </div>

    <script>
        // Toggle sidebar
        const sidebar = document.getElementById("sidebar");
        const content = document.getElementById("content");
        const collapseToggle = document.getElementById("collapseToggle");

        collapseToggle.addEventListener("click", () => {
            sidebar.classList.toggle("collapsed");
            content.classList.toggle("collapsed");
        });

        // Loading screen
        window.addEventListener("load", function () {
            const loadingScreen = document.getElementById("loading-screen");
            setTimeout(() => {
                loadingScreen.style.display = "none";
            }, 2000);

            // Initialiser les graphiques après le chargement
            initCharts();
        });

        // Initialisation des graphiques
        function initCharts() {
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
                stocksCtx.parentElement.innerHTML = '<p class="text-muted text-center py-4">Aucune donnée de stock disponible</p>';
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
                        cutout: '50%',
                        spacing: 5
                    }
                });
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
