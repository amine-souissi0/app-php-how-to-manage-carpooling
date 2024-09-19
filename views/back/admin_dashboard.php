<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'administrateur') {
    header("Location: /public/login.php");
    exit();
}
?>

<h2>Bienvenue sur le tableau de bord administrateur</h2>
<ul>
    <li><a href="users.php">Gérer les utilisateurs</a></li>
    <li><a href="trajets.php">Voir les statistiques des trajets</a></li>
</ul>
