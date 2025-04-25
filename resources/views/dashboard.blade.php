<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
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
        }

        .stats-container {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            margin-top: 30px;
        }

        .stat-card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            flex: 1;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .stat-icon {
            font-size: 2.5em;
            color: #fff;
            background-color: #2c3e50;
            width: 60px;
            height: 60px;
            line-height: 60px;
            border-radius: 50%;
            margin: 0 auto 15px;
        }

        .stat-info h3 {
            font-size: 1.2em;
            color: #333;
            margin-bottom: 10px;
        }

        .stat-value {
            font-size: 1.5em;
            font-weight: bold;
            color: #2c3e50;
        }

        #produits-card .stat-icon {
            background-color: #3498db;
        }

        #commandes-card .stat-icon {
            background-color: #e67e22;
        }

        #ca-card .stat-icon {
            background-color: #27ae60;
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
            <input type="text" placeholder="Rechercher..." class="form-control" />
        </div>
        <div class="user-info">
            <span>{{ Auth::user()->name }}</span>
            <div class="dropdown">
                <div class="avatar" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-user"></i>
                </div>
                <ul class="dropdown-menu">
                    <li>
                        <a class="dropdown-item" href="{{ route('profile.edit') }}">
                            <i class="fas fa-user-cog me-2"></i>Profil
                        </a>
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
            </h4><hr>
        </div>
        <ul>
            <li>
                <a href="{{ route('dashboard') }}">
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
            <li>
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
            <h2>Bienvenue sur le Dashboard</h2>
            <p>Gérez efficacement votre stock de produits agricoles</p>
        </div>
        <div class="stats-container">
            <div class="stat-card" id="produits-card">
                <div class="stat-icon">
                    <i class="fas fa-box"></i>
                </div>
                <div class="stat-info">
                    <h3>Produits</h3>
                    <p class="stat-value">{{ $produitCount ?? 'N/A' }}</p>
                </div>
            </div>
            <div class="stat-card" id="commandes-card">
                <div class="stat-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="stat-info">
                    <h3>Commandes</h3>
                    <p class="stat-value">40</p>
                </div>
            </div>
            <div class="stat-card" id="ca-card">
                <div class="stat-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="stat-info">
                    <h3>Chiffre d'affaires</h3>
                    <p class="stat-value">1 579 450 FCFA</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        const sidebar = document.getElementById("sidebar");
        const content = document.getElementById("content");
        const collapseToggle = document.getElementById("collapseToggle");

        collapseToggle.addEventListener("click", () => {
            sidebar.classList.toggle("collapsed");
            content.classList.toggle("collapsed");
        });

        window.addEventListener("load", function () {
            const loadingScreen = document.getElementById("loading-screen");
            setTimeout(() => {
                loadingScreen.style.display = "none";
            }, 2000);
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
