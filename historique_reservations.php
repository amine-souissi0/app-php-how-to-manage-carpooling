<?php
require_once '../../controllers/ReservationController.php';

$reservationController = new ReservationController($db);
$reservations = $reservationController->lireReservationsParPassager();
?>

<h2>Historique de vos Réservations</h2>
<table>
    <tr>
        <th>Départ</th>
        <th>Destination</th>
        <th>Date de Réservation</th>
    </tr>
    <?php foreach ($reservations as $reservation): ?>
    <tr>
        <td><?= htmlspecialchars($reservation['depart']) ?></td>
        <td><?= htmlspecialchars($reservation['destination']) ?></td>
        <td><?= htmlspecialchars($reservation['date_reservation']) ?></td>
    </tr>
    <?php endforeach; ?>
</table>
