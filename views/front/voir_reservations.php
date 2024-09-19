<?php
// Start session to access session variables
session_start();

// Ensure the user is logged in and is a conductor
if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'conducteur') {
    // Redirect to login if the user is not logged in as a conductor
    header("Location: /public/login.php");
    exit();
}

// Include the necessary files
require_once '../../config/database.php';
require_once '../../controllers/TrajetController.php';

// Create a database connection
$database = new Database();
$db = $database->getConnection();

// Initialize the TrajetController with the database connection
$trajetController = new TrajetController($db);

// Fetch reservations for the conductor's trips
$reservations = $trajetController->lireReservationsParTrajet($_SESSION['id']);

?>

<!-- HTML to display the reservations -->
<h2>Réservations pour vos trajets</h2>
<table>
    <tr>
        <th>Nom du Passager</th>
        <th>Email du Passager</th>
        <th>Départ</th>
        <th>Destination</th>
        <th>Date du Trajet</th>
        <th>Date de Réservation</th>
    </tr>
    <?php foreach ($reservations as $reservation): ?>
    <tr>
        <td><?= htmlspecialchars($reservation['passager_nom']) ?></td>
        <td><?= htmlspecialchars($reservation['passager_email']) ?></td>
        <td><?= htmlspecialchars($reservation['depart']) ?></td>
        <td><?= htmlspecialchars($reservation['destination']) ?></td>
        <td><?= htmlspecialchars($reservation['date_trajet']) ?></td>
        <td><?= htmlspecialchars($reservation['date_reservation']) ?></td>
    </tr>
    <?php endforeach; ?>
</table>
