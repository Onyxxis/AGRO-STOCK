<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard - Stock</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        :root {
            --primary-color: #5BCC90FF;
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
            max-width: 400px;
        }

        .search-bar i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #A6D8C1FF;
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

        /* Styles pour le tableau des produits */
        .filter-section {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .filter-group {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .filter-group label {
            font-weight: 500;
            color: #2d3748;
            white-space: nowrap;
        }

        .filter-group select {
            padding: 0.5rem;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            background-color: #f7fafc;
            font-size: 1rem;
            color: #2d3748;
            transition: border-color 0.3s ease;
        }

        .filter-group select:focus {
            border-color: var(--primary-color);
            outline: none;
        }

        #sort-button {
            background-color: var(--primary-color);
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            color: white;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.3s ease;
            white-space: nowrap;
        }

        #sort-button:hover {
            background-color: var(--secondary-color);
        }

        .product-table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .product-table th,
        .product-table td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }

        .product-table th {
            background-color: var(--primary-color);
            color: white;
            font-weight: 600;
        }

        .product-table tbody tr:hover {
            background-color: #e2f3e8;
            transform: scale(1.02);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .product-table tbody tr:last-child td {
            border-bottom: none;
        }

        .product-table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .product-table td {
            margin-right: 8px;
            color: black;
        }

        .i {
            color: var(--color-green-50)
        }

        .action-buttons {
            display: flex;
            gap: 8px;
        }

        .action-buttons button {
            padding: 0.5rem;
            border: none;
            border-radius: 8px;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .edit-btn {
            background-color: #3490dc;
        }

        .delete-btn {
            background-color: #e3342f;
        }

        .edit-btn:hover {
            background-color: #2779bd;
        }

        .delete-btn:hover {
            background-color: #cc1f1a;
        }

        /* Modal styles */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .modal-content {
            background-color: white;
            padding: 2rem;
            border-radius: 12px;
            width: 100%;
            max-width: 500px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .modal-title {
            font-size: 1.5rem;
            color: #2d3748;
            font-weight: 600;
        }

        .close-btn {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: #718096;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #2d3748;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            outline: none;
        }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            margin-top: 2rem;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
        }

        .btn-secondary {
            background-color: #e2e8f0;
            color: #2d3748;
        }

        .btn-secondary:hover {
            background-color: #cbd5e0;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--secondary-color);
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

        #main-content {
            display: none;
        }

        /* Bouton flottant pour ajouter un produit */
        .floating-add-btn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 60px;
            height: 60px;
            background-color: var(--primary-color);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 100;
        }

        .floating-add-btn:hover {
            background-color: var(--secondary-color);
            transform: scale(1.1);
        }

        .filter-container {
        background-color: white;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .filter-form {
        width: 100%;
    }

    .filter-row {
        display: flex;
        align-items: flex-end;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .filter-item {
        flex: 1;
        min-width: 150px;
    }

    .filter-label {
        display: block;
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
        color: #4a5568;
        font-weight: 500;
    }

    .filter-select, .filter-date {
        width: 100%;
        padding: 0.6rem 1rem;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        background-color: #f7fafc;
        font-size: 0.9rem;
        color: #2d3748;
        transition: all 0.3s ease;
    }

    .filter-select:focus, .filter-date:focus {
        border-color: #5BCC90FF;
        outline: none;
        box-shadow: 0 0 0 2px rgba(91, 204, 144, 0.2);
    }

    .filter-button {
        background-color: #5BCC90FF;
        color: white;
        border: none;
        padding: 0.6rem 1.5rem;
        border-radius: 8px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        height: 40px;
    }

    .filter-button:hover {
        background-color: #276749;
    }

    @media (max-width: 992px) {
        .filter-item {
            min-width: 120px;
        }
    }

    @media (max-width: 768px) {
        .filter-row {
            flex-direction: column;
            align-items: stretch;
            gap: 1rem;
        }

        .filter-item {
            width: 100%;
        }

        .filter-button {
            width: 100%;
            justify-content: center;
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
            <form action="{{ route('produits.search') }}" method="GET">
                <i class="fas fa-search"></i>
                <input type="text" name="search" placeholder="Rechercher..." class="form-control" value="{{ request('search') }}" />
            </form>
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
                    @unless(auth()->user()->role === 'agriculteur')
                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-cog me-2"></i>Paramètres
                            </a>
                        </li>
                    @endunless
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
            @unless(auth()->user()->role === 'agriculteur')
                <li>
                    <a href="/dashboard">
                        <i class="fas fa-home"></i>
                        <span>Accueil</span>
                    </a>
                </li>
            @endunless

            <li>
                <a href="/produit">
                    <i class="fas fa-box"></i>
                    <span>Produits</span>
                </a>
            </li>

            @unless(auth()->user()->role === 'agriculteur')
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
            @endunless
        </ul>
        <div class="collapse-toggle" id="collapseToggle">
            <i class="fas fa-chevron-left"></i>
        </div>
    </div>

    <div class="content" id="content">


        <div class="filter-container">
            <form method="GET" action="{{ route('produits.filter') }}" class="filter-form">
                <div class="filter-row">
                    <div class="filter-item">
                        <label for="sort-by" class="filter-label">Trier par</label>
                        <select name="criteria" id="sort-by" class="filter-select">
                            <option value="type">Type</option>
                            <option value="statut">Statut</option>
                        </select>
                    </div>

                    <div class="filter-item">
                        <label for="filter-type" class="filter-label">Type</label>
                        <select name="type" id="filter-type" class="filter-select">
                            <option value="tout">Tout</option>
                            <option value="fruits">Fruits</option>
                            <option value="legume">Légumes</option>
                            <option value="cereale">Céréales</option>
                            <option value="tubercule">Tubercules</option>
                        </select>
                    </div>

                    <div class="filter-item">
                        <label for="filter-statut" class="filter-label">Statut</label>
                        <select name="statut" id="filter-statut" class="filter-select">
                            <option value="tout">Tout</option>
                            <option value="stocké">Stocké</option>
                            <option value="vendu">Vendu</option>
                            <option value="distribué">Distribué</option>
                        </select>
                    </div>

                    <div class="filter-item">
                        <label for="start-date" class="filter-label">Date début</label>
                        <input type="date" name="start_date" id="start-date" class="filter-date">
                    </div>

                    <div class="filter-item">
                        <label for="end-date" class="filter-label">Date fin</label>
                        <input type="date" name="end_date" id="end-date" class="filter-date">
                    </div>

                    <div class="filter-item">
                        <button type="submit" class="filter-button">
                            <i class="fas fa-filter"></i> Filtrer
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="table-responsive">
            <table class="product-table">
                <thead>
                    <tr>
                        <th>Nom du produit</th>
                        <th>Type</th>
                        <th>Quantité (kg)</th>
                        <th>Date de récolte</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="product-table-body">
                    @foreach($produits as $produit)
                    <tr>
                        <td>{{ $produit->nom }}</td>
                        <td>{{ $produit->type }}</td>
                        <td>{{ $produit->quantite_recoltee }}</td>
                        <td>{{ date('d/m/Y', strtotime($produit->date_recolte)) }}</td>
                        <td>{{ $produit->statut }}</td>
                        <td>
                            <div class="action-buttons">
                                <button class="edit-btn" onclick="window.location.href='{{ route('produits.edit', $produit->id) }}'">
                                    <i class="fas fa-pen"></i>
                                </button>
                                <button class="delete-btn" onclick="confirmDelete('{{ route('produits.destroy', $produit->id) }}')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

            <!-- Bouton flottant pour ajouter un produit -->
            <a href="/produit/create" class="floating-add-btn">
                <i class="fas fa-plus"></i>
            </a>

        <!-- Modal de confirmation -->
        <div class="modal-overlay" id="deleteModal">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmation</h5>
                    <button type="button" class="close-btn" onclick="closeModal()">&times;</button>
                </div>
                <div class="modal-body">
                    Voulez-vous vraiment supprimer ce produit ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeModal()">Annuler</button>
                    <form id="deleteForm" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                    </form>
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

        function confirmDelete(url) {
            const form = document.getElementById('deleteForm');
            form.action = url;
            document.getElementById('deleteModal').classList.add('active');
        }

        function closeModal() {
            document.getElementById('deleteModal').classList.remove('active');
        }

        function clearForm() {
            document.getElementById('deleteForm').action = "";
            closeModal();
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
