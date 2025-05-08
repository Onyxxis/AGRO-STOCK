<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard - Ajouter un stock</title>
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

        /* Styles pour le formulaire */
        .form-container {
            background-color: white;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            max-width: 600px;
            margin: 0 auto;
        }

        .form-title {
            color: #2d3748;
            font-weight: 600;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-weight: 500;
            color: #2d3748;
            margin-bottom: 0.5rem;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            background-color: #f7fafc;
            font-size: 1rem;
            color: #2d3748;
            transition: border-color 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            outline: none;
            box-shadow: 0 0 0 2px rgba(56, 161, 105, 0.2);
        }

        .text-danger {
            color: #e53e3e;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: var(--secondary-color);
        }

        .btn-secondary {
            background-color: #718096;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #4a5568;
        }

        .action-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-top: 2rem;
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
        <div class="form-container">
            <h2 class="form-title">Ajouter un stock</h2>

            <form method="POST" action="{{ route('stockage.store') }}">
                @csrf

                <div class="form-group">
                    <label for="produit_id" class="form-label">Produit</label>
                    <select name="produit_id" class="form-control" required>
                        <option value="">Sélectionner un produit</option>
                        @foreach($produits as $produit)
                            <option value="{{ $produit->id }}" {{ old('produit_id') == $produit->id ? 'selected' : '' }}>
                                {{ $produit->nom }}
                            </option>
                        @endforeach
                    </select>
                    @error('produit_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
{{--
                <div class="form-group">
                    <label for="quantite_stockee" class="form-label">Quantité stockée (kg)</label>
                    <input type="number" name="quantite_stockee" class="form-control"
                           value="{{ old('quantite_stockee') }}" required min="0" step="0.01">
                    @error('quantite_stockee')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div> --}}

                <div class="form-group">
                    <label for="lieu_stockage" class="form-label">Lieu de stockage</label>
                    <input type="text" name="lieu_stockage" class="form-control"
                           value="{{ old('lieu_stockage') }}" required>
                    @error('lieu_stockage')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="action-buttons">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i> Enregistrer
                    </button>
                    <a href="{{ route('stockage.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times me-2"></i> Annuler
                    </a>
                </div>
            </form>
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
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
