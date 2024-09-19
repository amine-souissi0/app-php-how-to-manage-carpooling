Gestion des Ressources Humaines (PHP 8)
Système de gestion des RH développé en PHP 8 suivant la structure MVC. Il permet de gérer les utilisateurs, départements, et catégories.

Prérequis
PHP 8.0+
Serveur local (XAMPP, WAMP, MAMP)
MySQL ou MariaDB
Installation

Configurez config/database.php avec vos informations de base de données.

Importez gestion_rh.sql dans votre serveur MySQL.

Lancez le serveur PHP :

bash
Copier le code
php -S localhost:8000
Accédez à l'application :



http://localhost:8000/public/login.php
Pages d'accès
Connexion : /public/login.php
Utilisateurs (Admin RH) : /views/back/users.php
Départements (Admin RH) : /views/back/departements.php
Catégories (Admin RH) : /views/back/categories.php
Dashboard Manager : /views/front/manager_dashboard.php
Profil Employé : /views/front/profile.php
Fonctionnalités
Admin RH : Gère utilisateurs, départements, catégories.
Manager : Recherche et évalue les employés.
Employé : Consulte et met à jour ses informations.
Structure
config/ : Configuration (connexion DB)
controllers/ : Logique métier
models/ : Interaction avec la DB
views/ : Fichiers de vue (back & front)
public/ : Fichiers accessibles publiquement
Licence
Sous licence MIT.
