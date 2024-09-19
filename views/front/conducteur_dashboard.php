<?php
session_start();
if ($_SESSION['role'] !== 'conducteur') {
    header("Location: ../public/login.php");
    exit();
}
?>
<a href="/public/login.php" style="color: red; text-decoration: none; font-weight: bold;">Déconnexion</a>

<h2>Bienvenue sur le tableau de bord conducteur</h2>
<ul>
    <li><a href="gerer_trajets.php">Gérer vos trajets</a></li>
    <li><a href="voir_reservations.php">Voir les réservations des passagers</a></li>
</ul>
