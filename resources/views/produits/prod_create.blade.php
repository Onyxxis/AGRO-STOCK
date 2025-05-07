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

            /* Conteneur du formulaire */
.form-container {
    background-color: white;
    border-radius: 12px;
    padding: 2rem;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    max-width: 600px;
    margin: 0 auto;
}

/* Groupe de formulaire */
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
.submit-btn {
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
}

.submit-btn:hover {
    background-color: var(--secondary-color);
}

.submit-btn i {
    font-size: 1.2rem;
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

            /* Style du Modal */
.success-modal {
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
            </h4><hr>
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
        <div class="container">
            <h2>{{ isset($produit) ? 'Modifier' : 'Ajouter' }} un produit</h2>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ isset($produit) ? route('produits.update', $produit->id) : route('produits.store') }}" method="POST">
                @csrf
                @if(isset($produit))
                    @method('PUT')
                @endif

                <div class="mb-3">
                    <label for="nom" class="form-label">Nom du produit :</label>
                    <input type="text" class="form-control" name="nom" value="{{ old('nom', $produit->nom ?? '') }}" required>
                </div>

                <div class="mb-3">
                    <label for="type" class="form-label">Type :</label>
                    <select class="form-control" name="type" id="type" required>
                        <option value="">Sélectionner un type</option>
                        <option value="fruits" {{ old("type", $produit->type ?? '') === 'fruits' ? 'selected' : '' }}>Fruits</option>
                        <option value="legume" {{ old("type", $produit->type ?? '') === 'legume' ? 'selected' : '' }}>Légume</option>
                        <option value="cereale" {{ old("type", $produit->type ?? '') === 'cereale' ? 'selected' : '' }}>Céréale</option>
                        <option value="tubercule" {{ old("type", $produit->type ?? '') === 'tubercule' ? 'selected' : '' }}>Tubercule</option>
                        <option value="autre" {{ old("type", $produit->type ?? '') === 'autre' ? 'selected' : '' }}>Autre</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="quantite_recoltee" class="form-label">Quantité :</label>
                    <input type="number" class="form-control" name="quantite_recoltee" value="{{ old('quantite_recoltee', $produit->quantite_recoltee ?? '') }}" required>
                </div>

                <div class="mb-3">
                    <label for="date_recolte" class="form-label">Date de récolte :</label>
                    <input type="date" class="form-control" name="date_recolte" value="{{ old('date_recolte', $produit->date_recolte ?? '') }}" required>
                </div>

                <div class="mb-3">
                    <label for="statut" class="form-label">Statut :</label>
                    <select class="form-control" name="statut" required>
                        <option value="Stocké" {{ (isset($produit) && $produit->statut == 'Stocké') ? 'selected' : '' }}>Stocké</option>
                        <option value="Vendu" {{ (isset($produit) && $produit->statut == 'Vendu') ? 'selected' : '' }}>Vendu</option>
                        <option value="Distribué" {{ (isset($produit) && $produit->statut == 'Distribué') ? 'selected' : '' }}>Distribué</option>
                    </select>
                </div>

                <button type="submit" class="btn w-100" style="color: white; background-color: var(--primary-color);">
                    {{ isset($produit) ? 'Modifier' : 'Ajouter' }}
                </button>
            </form>
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
