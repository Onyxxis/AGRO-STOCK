<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Dashboard</title>
        <link
            rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
        />
        <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        />
        <!-- Ajout des bibliothèques jQuery et Select2 -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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
                text-decoration: none; /* Enlève le soulignement */
                color: inherit; /* Hérite la couleur du texte parent */
            }

            a:hover,
            a:focus {
                color: inherit; /* Empêche le changement de couleur en bleu */
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

            /* Ajout des styles de formulaire depuis prod_create.blade.php */
            .form-container {
                background-color: white;
                border-radius: 12px;
                padding: 2rem;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
                max-width: 600px;
                margin: 0 auto;
            }

            .form-group {
                margin-bottom: 1.5rem;
            }

            .form-group label {
                display: block;
                font-weight: 500;
                color: #2d3748;
                margin-bottom: 0.5rem;
            }

            .form-group input,
            .form-group select {
                width: 100%;
                padding: 0.75rem;
                border: 1px solid #e2e8f0;
                border-radius: 8px;
                background-color: #f7fafc;
                font-size: 1rem;
                color: #2d3748;
                transition: border-color 0.3s ease;
            }

            .form-group input:focus,
            .form-group select:focus {
                border-color: var(--primary-color);
                outline: none;
            }

            /* Bouton de soumission */
            .btn-primary {
                background-color: var(--primary-color);
                color: white;
                padding: 0.75rem 1.5rem;
                border: none;
                border-radius: 8px;
                font-size: 1rem;
                font-weight: 500;
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 10px;
                transition: background-color 0.3s ease;
                width: 100%;
            }

            .btn-primary:hover {
                background-color: var(--secondary-color);
            }

            /* Style pour le bouton annuler */
            .btn-secondary {
                background-color: #718096;
                color: white;
                padding: 0.75rem 1.5rem;
                border: none;
                border-radius: 8px;
                font-size: 1rem;
                font-weight: 500;
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 10px;
                transition: background-color 0.3s ease;
                width: 100%;
            }

            .btn-secondary:hover {
                background-color: #4a5568;
            }

            /* Style pour le conteneur des boutons */
            .button-container {
                display: flex;
                gap: 1rem;
                margin-top: 1rem;
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

            /* Styles pour les modals de succès et d'erreur */
            .modal-popup {
                display: none;
                position: fixed;
                z-index: 1050;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);
            }

            .modal-content {
                background-color: white;
                margin: 15% auto;
                padding: 30px;
                border-radius: 12px;
                width: 400px;
                max-width: 90%;
                text-align: center;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
                animation: modalFadeIn 0.3s;
            }

            @keyframes modalFadeIn {
                from {opacity: 0; transform: translateY(-20px);}
                to {opacity: 1; transform: translateY(0);}
            }

            .success-icon {
                font-size: 60px;
                color: #38a169;
                margin-bottom: 20px;
            }

            .error-icon {
                font-size: 60px;
                color: #e53e3e;
                margin-bottom: 20px;
            }

            .modal-title {
                font-size: 24px;
                font-weight: 600;
                margin-bottom: 15px;
                color: #2d3748;
            }

            .modal-message {
                font-size: 16px;
                color: #4a5568;
                margin-bottom: 25px;
            }

            .error-list {
                list-style-type: none;
                padding: 0;
                text-align: left;
                margin-bottom: 25px;
                color: #e53e3e;
            }

            .error-list li {
                margin-bottom: 5px;
                padding: 5px 10px;
                background-color: #fed7d7;
                border-radius: 4px;
            }

            .modal-close-btn {
                background-color: #38a169;
                color: white;
                border: none;
                padding: 10px 20px;
                border-radius: 8px;
                font-size: 16px;
                cursor: pointer;
                transition: background-color 0.3s;
            }

            .modal-close-btn:hover {
                background-color: #2f855a;
            }

            .modal-error-btn {
                background-color: #e53e3e;
                color: white;
                border: none;
                padding: 10px 20px;
                border-radius: 8px;
                font-size: 16px;
                cursor: pointer;
                transition: background-color 0.3s;
            }

            .modal-error-btn:hover {
                background-color: #c53030;
            }

            /* Ajout des styles pour les messages d'erreur en ligne */
            .invalid-feedback {
                display: block;
                width: 100%;
                margin-top: 0.25rem;
                font-size: 0.875em;
                color: #e53e3e;
            }

            .is-invalid {
                border-color: #e53e3e !important;
                background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23e53e3e'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23e53e3e' stroke='none'/%3e%3c/svg%3e");
                background-repeat: no-repeat;
                background-position: right calc(0.375em + 0.1875rem) center;
                background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
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
                <input
                    type="text"
                    placeholder="Rechercher..."
                    class="form-control"
                />
            </div>
            <div class="user-info">
                <span>{{ Auth::user()->name }}</span>
                <div class="dropdown">
                    <div
                        class="avatar"
                        id="userDropdown"
                        data-bs-toggle="dropdown"
                        aria-expanded="false"
                    >
                        <i class="fas fa-user"></i>
                    </div>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="#"
                                ><i class="fas fa-user-cog me-2"></i>Profil</a
                            >
                        </li>
                        <li>
                            <a class="dropdown-item" href="#"
                                ><i class="fas fa-cog me-2"></i>Paramètres</a
                            >
                        </li>
                        <li><hr class="dropdown-divider" /></li>
                        <li>
                            <a class="dropdown-item" href="#"
                                ><i class="fas fa-sign-out-alt me-2"></i
                                >Déconnexion</a
                            >
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
            <div class="container">
                <h2>Ajouter une Transaction</h2>

                <!-- Affichage des erreurs dans une alerte -->
                @if ($errors->any())
                <div class="alert alert-danger mb-4">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Attention !</strong> Veuillez corriger les erreurs ci-dessous.
                </div>
                @endif

                <form action="{{ route('transaction.store') }}" method="POST" id="transactionForm" class="bg-white p-4 rounded shadow">
                    @csrf

                    <div class="mb-3">
                        <label for="produit_id_field" class="form-label">Produit</label>
                        <select id="produit_id_field" name="produit_id" class="form-control select2 @error('produit_id') is-invalid @enderror" required>
                            <option value="">Sélectionnez un produit</option>
                            @foreach($produits as $produit)
                                <option value="{{ $produit->id }}" {{ old('produit_id') == $produit->id ? 'selected' : '' }}>{{ $produit->nom }}</option>
                            @endforeach
                        </select>
                        @error('produit_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="type_transaction_field" class="form-label">Type</label>
                        <select id="type_transaction_field" name="type_transaction" class="form-control @error('type_transaction') is-invalid @enderror" required>
                            <option value="">Sélectionnez un type</option>
                            <option value="Vente" {{ old('type_transaction') == 'Vente' ? 'selected' : '' }}>Vente</option>
                            <option value="Distribution" {{ old('type_transaction') == 'Distribution' ? 'selected' : '' }}>Distribution</option>
                        </select>
                        @error('type_transaction')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="date_transaction_field" class="form-label">Date</label>
                        <input type="date" id="date_transaction_field" name="date_transaction" value="{{ old('date_transaction') }}" class="form-control @error('date_transaction') is-invalid @enderror" required>
                        @error('date_transaction')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="quantite_field" class="form-label">Quantité</label>
                        <input type="number" step="0.01" id="quantite_field" name="quantite" value="{{ old('quantite') }}" class="form-control @error('quantite') is-invalid @enderror" required>
                        @error('quantite')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="prix_unitaire_field" class="form-label">Prix unitaire (si Vente)</label>
                        <input type="number" step="0.01" id="prix_unitaire_field" name="prix_unitaire" value="{{ old('prix_unitaire') }}" class="form-control @error('prix_unitaire') is-invalid @enderror">
                        @error('prix_unitaire')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="destinataire_field" class="form-label">Destinataire / Acheteur</label>
                        <input type="text" id="destinataire_field" name="destinataire" value="{{ old('destinataire') }}" class="form-control @error('destinataire') is-invalid @enderror" required>
                        @error('destinataire')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Affichage des erreurs spécifiques qui ne correspondent pas aux champs -->
                    @error('stock')
                        <div class="alert alert-danger mb-3">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            {{ $message }}
                        </div>
                    @enderror

                    @error('error')
                        <div class="alert alert-danger mb-3">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            {{ $message }}
                        </div>
                    @enderror

                    <div class="button-container">
                        <button type="submit" class="btn-primary">
                            <i class="fas fa-check me-2"></i>Valider
                        </button>
                        <a href="{{ route('transaction.index') }}" class="btn-secondary">
                            <i class="fas fa-times me-2"></i>Annuler
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal de succès -->
        <div id="successModal" class="modal-popup">
            <div class="modal-content">
                <div class="success-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h3 class="modal-title">Transaction ajoutée</h3>
                <p class="modal-message">La transaction a été ajoutée avec succès.</p>
                <button onclick="closeModal('successModal')" class="modal-close-btn">Fermer</button>
            </div>
        </div>

        <!-- Modal d'erreur -->
        <div id="errorModal" class="modal-popup">
            <div class="modal-content">
                <div class="error-icon">
                    <i class="fas fa-exclamation-circle"></i>
                </div>
                <h3 class="modal-title">Erreur</h3>
                <ul id="errorList" class="error-list">
                    <!-- Les erreurs seront insérées ici via JavaScript -->
                </ul>
                <button onclick="closeModal('errorModal')" class="modal-error-btn">OK</button>
            </div>
        </div>

        <script>
            // Script pour le sidebar
            const sidebar = document.getElementById("sidebar");
            const content = document.getElementById("content");
            const collapseToggle = document.getElementById("collapseToggle");

            collapseToggle.addEventListener("click", () => {
                sidebar.classList.toggle("collapsed");
                content.classList.toggle("collapsed");
            });

            // Script pour initialiser Select2
            $(document).ready(function() {
                $('.select2').select2({
                    placeholder: "Choisissez un produit",
                    allowClear: true
                });

                // Gestion conditionnelle du champ prix_unitaire
                $('#type_transaction_field').change(function() {
                    if ($(this).val() === 'Vente') {
                        $('#prix_unitaire_field').prop('required', true);
                        $('label[for="prix_unitaire_field"]').text('Prix unitaire (obligatoire)');
                    } else {
                        $('#prix_unitaire_field').prop('required', false);
                        $('label[for="prix_unitaire_field"]').text('Prix unitaire (si Vente)');
                    }
                });

                // Déclencher le changement au chargement
                $('#type_transaction_field').trigger('change');

                // Afficher le modal d'erreur si des erreurs sont présentes
                @if ($errors->any())
                    const errors = {!! json_encode($errors->all()) !!};
                    if (errors.length > 0) {
                        showErrorModal(errors);
                    }
                @endif

                // Afficher le modal de succès si le message flash existe
                @if (session('success'))
                    showSuccessModal("{{ session('success') }}");
                @endif
            });

            // Script pour le chargement et le modal
            window.addEventListener("load", function () {
                const loadingScreen = document.getElementById("loading-screen");

                // Masquer l'écran de chargement après 2 secondes
                setTimeout(() => {
                    loadingScreen.style.display = "none";
                }, 2000);
            });

            function showSuccessModal(message = null) {
                const modal = document.getElementById('successModal');
                if (message) {
                    document.querySelector('#successModal .modal-message').textContent = message;
                }
                if (modal) {
                    modal.style.display = 'block';
                }
            }

            function showErrorModal(errors) {
                const modal = document.getElementById('errorModal');
                const errorList = document.getElementById('errorList');

                // Vider la liste d'erreurs existante
                errorList.innerHTML = '';

                // Ajouter chaque erreur à la liste
                errors.forEach(error => {
                    const li = document.createElement('li');
                    li.textContent = error;
                    errorList.appendChild(li);
                });

                if (modal) {
                    modal.style.display = 'block';
                }
            }

            function closeModal(modalId) {
                const modal = document.getElementById(modalId);
                if (modal) {
                    modal.style.display = 'none';
                }
            }

            // Fermer les modals si on clique en dehors
            window.addEventListener('click', function(event) {
                const successModal = document.getElementById('successModal');
                const errorModal = document.getElementById('errorModal');

                if (event.target === successModal) {
                    closeModal('successModal');
                }

                if (event.target === errorModal) {
                    closeModal('errorModal');
                }
            });
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
