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


        /* Conteneur des cartes */
.stats-container {
    display: flex;
    justify-content: space-between;
    gap: 20px;
    margin-top: 30px;
}

/* Style de base des cartes */
.stat-card {
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 20px;
    flex: 1;
    text-align: center;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

/* Effet au survol */
.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
}

/* Icône */
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

/* Titre de la carte */
.stat-info h3 {
    font-size: 1.2em;
    color: #333;
    margin-bottom: 10px;
}

/* Valeur de la carte */
.stat-value {
    font-size: 1.5em;
    font-weight: bold;
    color: #2c3e50;
}

/* Couleurs personnalisées pour chaque carte */
#produits-card .stat-icon {
    background-color: #3498db; /* Bleu */
}

#commandes-card .stat-icon {
    background-color: #e67e22; /* Orange */
}

#ca-card .stat-icon {
    background-color: #27ae60; /* Vert */
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
                <span>John Doe</span>
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
                    <a href="">
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
                <h2>Page de stock</h2>
                <p>Gérez efficacement votre stock de produits agricoles</p>
            </div>
            <!-- Optionnel : formulaire de recherche (ex: par lieu ou produit) -->
            <div class="filter-container">
                <form method="GET" action="{{ route('stockage.search') }}" class="filter-form">
                    <div class="filter-row">
                        <div class="filter-item">
                            <label for="search" class="filter-label">Rechercher</label>
                            <input type="text" name="search" id="search" placeholder="Nom produit ou lieu..." class="filter-date">
                        </div>
                        <div class="filter-item">
                            <button type="submit" class="filter-button">
                                <i class="fas fa-search"></i> Rechercher
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Tableau des stocks -->
            <div class="table-responsive">
                <table class="product-table">
                    <thead>
                        <tr>
                            <th>Nom du produit</th>
                            <th>Type</th>
                            <th>Quantité stockée (kg)</th>
                            <th>Lieu de stockage</th>
                            <th>Date d'enregistrement</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="product-table-body">
                        @foreach($stocks as $stock)
                        <tr>
                            <td>{{ $stock->produit->nom }}</td>
                            <td>{{ $stock->produit->type }}</td>
                            <td>{{ $stock->quantite_stockee }}</td>
                            <td>{{ $stock->lieu_stockage }}</td>
                            <td>{{ $stock->created_at->format('d/m/Y') }}</td>
                            <td>
                                <div class="action-buttons">
                                    <button class="edit-btn" onclick="window.location.href='{{ route('stockage.edit', $stock->id) }}'">
                                        <i class="fas fa-pen"></i>
                                    </button>
                                    <button class="delete-btn" data-bs-toggle="modal" data-bs-target="#deleteModal" data-url="{{ route('stockage.destroy', $stock->id) }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Bouton flottant d’ajout -->
            <a href="{{ route('stockage.create') }}" class="floating-add-btn">
                <i class="fas fa-plus"></i>
            </a>

            <!-- Modal de suppression -->
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
                            Voulez-vous vraiment supprimer ce stock ?
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

        <!-- Script pour injecter l’URL dynamique dans le formulaire de suppression -->
        <script>
            const deleteButtons = document.querySelectorAll('.delete-btn');
            const deleteForm = document.getElementById('deleteForm');

            deleteButtons.forEach(btn => {
                btn.addEventListener('click', function () {
                    const url = this.getAttribute('data-url');
                    deleteForm.setAttribute('action', url);
                });
            });
        </script>



        <script>
            const sidebar = document.getElementById("sidebar");
            const content = document.getElementById("content");
            const collapseToggle = document.getElementById("collapseToggle");

            collapseToggle.addEventListener("click", () => {
                sidebar.classList.toggle("collapsed");
                content.classList.toggle("collapsed");
            });
        </script>

<script>
            window.addEventListener("load", function () {
                const loadingScreen = document.getElementById("loading-screen");
                const mainContent = document.getElementById("main-content");

                setTimeout(() => {
                    loadingScreen.style.display = "none";
                    mainContent.style.display = "block";
                }, 2000);
            });
        </script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
