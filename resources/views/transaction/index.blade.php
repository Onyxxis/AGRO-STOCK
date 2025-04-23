<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard - Transactions</title>
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

        .transaction-table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .transaction-table th,
        .transaction-table td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }

        .transaction-table th {
            background-color: var(--primary-color);
            color: white;
            font-weight: 600;
        }

        .transaction-table tbody tr:hover {
            background-color: #e2f3e8;
            transform: scale(1.02);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .transaction-table tbody tr:last-child td {
            border-bottom: none;
        }

        .transaction-table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .transaction-table td {
            margin-right: 8px;
            color: black;
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

        /* Bouton flottant pour ajouter une transaction */
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

        .badge {
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .badge-vente {
            background-color: #3490dc;
            color: white;
        }

        .badge-distribution {
            background-color: #f6ad55;
            color: white;
        }

        @media (max-width: 992px) {
            .filter-item {
                min-width: 120px;
            }
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
            <form action="{{ route('transaction.search') }}" method="GET">
                <i class="fas fa-search"></i>
                <input type="text" name="search" placeholder="Rechercher..." class="form-control" value="{{ request('search') }}" />
            </form>
        </div>

        <div class="user-info">
            <span>John Doe</span>
            <div class="dropdown">
                <div class="avatar" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-user"></i>
                </div>
                <ul class="dropdown-menu">
                    <li>
                        <a class="dropdown-item" href="#"><i class="fas fa-user-cog me-2"></i>Profil</a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Paramètres</a>
                    </li>
                    <li><hr class="dropdown-divider" /></li>
                    <li>
                        <a class="dropdown-item" href="#"><i class="fas fa-sign-out-alt me-2"></i>Déconnexion</a>
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
        <div class="filter-container">
            <form method="GET" action="{{ route('transaction.filter') }}" class="filter-form">
                <div class="filter-row">
                    <div class="filter-item">
                        <label for="sort-by" class="filter-label">Trier par</label>
                        <select name="criteria" id="sort-by" class="filter-select">
                            <option value="date_transaction">Date</option>
                            <option value="type_transaction">Type de transaction</option>
                            <option value="quantite">Quantité</option>
                        </select>
                    </div>

                    <div class="filter-item">
                        <label for="filter-type" class="filter-label">Type de transaction</label>
                        <select name="type_transaction" id="filter-type" class="filter-select">
                            <option value="tout">Tout</option>
                            <option value="Vente">Vente</option>
                            <option value="Distribution">Distribution</option>
                        </select>
                    </div>

                    <div class="filter-item">
                        <label for="filter-produit" class="filter-label">Produit</label>
                        <select name="produit_id" id="filter-produit" class="filter-select">
                            <option value="tout">Tous les produits</option>
                            @foreach($produits ?? [] as $produit)
                            <option value="{{ $produit->id }}">{{ $produit->nom }}</option>
                            @endforeach
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
            <table class="transaction-table">
                <thead>
                    <tr>
                        <th>Produit</th>
                        <th>Type</th>
                        <th>Date</th>
                        <th>Quantité (kg)</th>
                        <th>Prix unitaire</th>
                        <th>Total</th>
                        <th>Destinataire</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="transaction-table-body">
                    @foreach($transactions ?? [] as $transaction)
                    <tr>
                        <td>{{ $transaction->produit->nom }}</td>
                        <td>
                            <span class="badge {{ $transaction->type_transaction == 'Vente' ? 'badge-vente' : 'badge-distribution' }}">
                                {{ $transaction->type_transaction }}
                            </span>
                        </td>
                        <td>{{ date('d/m/Y', strtotime($transaction->date_transaction)) }}</td>
                        <td>{{ $transaction->quantite }}</td>
                        <td>{{ $transaction->type_transaction == 'Vente' ? number_format($transaction->prix_unitaire, 0, ',', ' ') . ' FCFA' : '-' }}</td>
                        <td>{{ $transaction->type_transaction == 'Vente' ? number_format($transaction->prix_unitaire * $transaction->quantite, 0, ',', ' ') . ' FCFA' : '-' }}</td>
                        <td>{{ $transaction->destinataire }}</td>
                        <td>
                            <div class="action-buttons">
                                <button class="edit-btn" data-bs-toggle="modal" data-bs-target="#editModal" 
                                    data-id="{{ $transaction->id }}"
                                    data-produit="{{ $transaction->produit_id }}"
                                    data-type="{{ $transaction->type_transaction }}"
                                    data-quantite="{{ $transaction->quantite }}"
                                    data-prix="{{ $transaction->prix_unitaire }}"
                                    data-date="{{ $transaction->date_transaction }}"
                                    data-destinataire="{{ $transaction->destinataire }}">
                                    <i class="fas fa-pen"></i>
                                </button>
                                <button class="delete-btn" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="{{ $transaction->id }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Bouton flottant pour ajouter une transaction -->
        <a href="{{ route('transaction.create') }}" class="floating-add-btn">
            <i class="fas fa-plus"></i>
        </a>

        <!-- Modal d'édition de transaction -->
        <!-- Modal pour l'édition de transaction -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifier la transaction</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editForm" method="POST" action="">
                    @csrf
                    @method('PUT')
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="edit_produit_id" class="form-label">Produit</label>
                            <select name="produit_id" id="edit_produit_id" class="form-control" required>
                                @foreach($produits as $produit)
                                <option value="{{ $produit->id }}">{{ $produit->nom }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_type_transaction" class="form-label">Type de transaction</label>
                            <select name="type_transaction" id="edit_type_transaction" class="form-control" required>
                                <option value="Vente">Vente</option>
                                <option value="Distribution">Distribution</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="edit_quantite" class="form-label">Quantité (kg)</label>
                            <input type="number" name="quantite" id="edit_quantite" class="form-control" required min="0" step="0.01">
                        </div>
                        <div class="col-md-6">
                            <label for="edit_prix_unitaire" class="form-label">Prix unitaire (FCFA)</label>
                            <input type="number" name="prix_unitaire" id="edit_prix_unitaire" class="form-control" min="0" step="0.01">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="edit_date_transaction" class="form-label">Date de transaction</label>
                            <input type="date" name="date_transaction" id="edit_date_transaction" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_destinataire" class="form-label">Destinataire</label>
                            <input type="text" name="destinataire" id="edit_destinataire" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
        <!-- Modal de confirmation de suppression -->
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirmation</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Voulez-vous vraiment supprimer cette transaction ?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <form id="deleteForm" method="POST" action="">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Supprimer</button>
                        </form>
                    </div>
                </div>
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
            const mainContent = document.getElementById("main-content");

            setTimeout(() => {
                loadingScreen.style.display = "none";
                mainContent.style.display = "block";
            }, 2000);
        });

        // Setup edit modal
        document.addEventListener('DOMContentLoaded', function() {
    const editModal = document.getElementById('editModal');
    if (editModal) {
        editModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            const produitId = button.getAttribute('data-produit');
            const type = button.getAttribute('data-type');
            const quantite = button.getAttribute('data-quantite');
            const prix = button.getAttribute('data-prix');
            const date = button.getAttribute('data-date');
            const destinataire = button.getAttribute('data-destinataire');
            
            // Set form action
            const form = document.getElementById('editForm');
            form.action = `/transactions/${id}`;
            
            // Fill form fields
            // Sélection du produit dans la liste déroulante
            const produitSelect = document.getElementById('edit_produit_id');
            for (let i = 0; i < produitSelect.options.length; i++) {
                if (produitSelect.options[i].value == produitId) {
                    produitSelect.selectedIndex = i;
                    break;
                }
            }
            
            document.getElementById('edit_type_transaction').value = type;
            document.getElementById('edit_quantite').value = quantite;
            document.getElementById('edit_prix_unitaire').value = prix || 0;
            document.getElementById('edit_date_transaction').value = date;
            document.getElementById('edit_destinataire').value = destinataire;
            
            // Toggle prix_unitaire field visibility based on transaction type
            const prixField = document.getElementById('edit_prix_unitaire');
            const prixContainer = prixField.closest('.col-md-6');
            
            if (type === 'Distribution') {
                prixContainer.style.display = 'none';
                prixField.value = '0';
                prixField.required = false;
            } else {
                prixContainer.style.display = 'block';
                prixField.required = true;
            }
        });

        // Add event listener for type change
        document.getElementById('edit_type_transaction').addEventListener('change', function() {
            const prixField = document.getElementById('edit_prix_unitaire');
            const prixContainer = prixField.closest('.col-md-6');
            
            if (this.value === 'Distribution') {
                prixContainer.style.display = 'none';
                prixField.value = '0';
                prixField.required = false;
            } else {
                prixContainer.style.display = 'block';
                prixField.required = true;
            }
        });
    }
});

        // Setup delete modal
        document.addEventListener('DOMContentLoaded', function() {
        const deleteModal = document.getElementById('deleteModal');
    if (deleteModal) {
        deleteModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            const form = document.getElementById('deleteForm');
            // Utilisez la route nommée pour transactions.destroy
            form.action = `{{ route('transaction.index') }}/${id}`;
        });
        }
    });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>