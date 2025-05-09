# ProjetLaravel:

# Une brève description du projet:

Une application Laravel pour la gestion post-récolte des produits agricoles. Elle inclut la gestion des produits, du stock, des transactions, des rapports PDF et des statistiques graphiques.

## Prérequis

- PHP >= 8.1
- Composer
- Laravel >= 10.x
- MySQL ou autre base de données
- Node.js et npm

## Installation

```bash
# Cloner le projet
git clone https://github.com/poussin26/ProjetLaravel.git

cd ProjetLaravel

# Installer les dépendances PHP
composer install

# Copier le fichier d'environnement et le configurer
cp .env.example .env

# Générer la clé de l'application
php artisan key:generate

# Configurer la base de données dans le fichier .env

# Exécuter les migrations
php artisan migrate

# (Optionnel) Ajouter les données initiales
php artisan db:seed

# Installer les dépendances front-end
npm install && npm run dev

# Utilisation

php artisan serve

```

## Fonctionnalités

Authentification des utilisateurs

Gestion des produits et du stock

Gestion des transactions

Génération de rapports des transactions PDF

Statistiques graphiques des transactions(charts.js, etc.)







