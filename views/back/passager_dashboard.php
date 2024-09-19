<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'passager') {
    header("Location: /public/login.php");
    exit();
}

$title = "Passager Dashboard";
ob_start();
?>

<h2>Bienvenue sur le tableau de bord passager</h2>
<ul>
    <li><a href="recherche_trajets.php">Rechercher et réserver des trajets</a></li>
    <li><a href="historique_reservations.php">Voir l'historique de vos réservations</a></li>
</ul>

<?php
$content = ob_get_clean();
include 'base_front.php';
?>
