<?php
session_start();
require_once '../../config/database.php';
require_once '../../controllers/TrajetController.php';
require_once '../../controllers/ReservationController.php';

// Ensure the session is active and the user is logged in
if (!isset($_SESSION['id'])) {
    // Redirect to login if the user is not logged in
    header("Location: /public/login.php");
    exit();
}

// Database connection
$database = new Database();
$db = $database->getConnection();

// Initialize controllers
$trajetController = new TrajetController($db);
$reservationController = new ReservationController($db);

// Handle reservation submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['trajet_id'])) {
    $data = [
        'passager_id' => $_SESSION['id'],  // Pass the logged-in user's ID from session
        'trajet_id' => $_POST['trajet_id']
    ];
    $reservationController->reserverTrajet($data);
    echo "Réservation effectuée avec succès!";
}

// Search and filter trips
$criteria = [
    'depart' => $_GET['depart'] ?? '',
    'destination' => $_GET['destination'] ?? '',
    'date' => $_GET['date'] ?? '',
];

$sort_column = $_GET['sort_column'] ?? 'date';
$sort_order = $_GET['sort_order'] ?? 'ASC';

$trips = $trajetController->rechercherEtTrierTrajets($criteria, $sort_column, $sort_order);
?>

<!-- HTML part -->
<h2>Rechercher des Trajets</h2>
<form action="" method="GET">
    <input type="text" name="depart" placeholder="Départ" value="<?= htmlspecialchars($_GET['depart'] ?? '') ?>">
    <input type="text" name="destination" placeholder="Destination" value="<?= htmlspecialchars($_GET['destination'] ?? '') ?>">
    <input type="date" name="date" value="<?= htmlspecialchars($_GET['date'] ?? '') ?>">
    <button type="submit">Rechercher</button>
</form>

<h2>Résultats</h2>
<table>
    <tr>
        <th>Départ</th>
        <th>Destination</th>
        <th>Date</th>
        <th>Places Disponibles</th>
        <th>Réserver</th>
    </tr>
    <?php foreach ($trips as $trip): ?>
    <tr>
        <td><?= htmlspecialchars($trip['depart']) ?></td>
        <td><?= htmlspecialchars($trip['destination']) ?></td>
        <td><?= htmlspecialchars($trip['date']) ?></td>
        <td><?= htmlspecialchars($trip['places_disponibles']) ?></td>
        <td>
            <form method="POST">
                <input type="hidden" name="trajet_id" value="<?= htmlspecialchars($trip['id']) ?>">
                <button type="submit">Réserver</button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
