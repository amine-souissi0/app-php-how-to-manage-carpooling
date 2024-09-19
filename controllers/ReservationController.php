<?php
require_once __DIR__ . '/../models/Reservation.php';

class ReservationController {
    private $db;
    private $reservation;

    public function __construct($db) {
        $this->db = $db;
        $this->reservation = new Reservation($db);
    }

    // Create a reservation for a trip
    public function reserverTrajet($data) {
        $this->reservation->passager_id = $data['passager_id'];
        $this->reservation->trajet_id = $data['trajet_id'];
        return $this->reservation->creerReservation();
    }
    

    // Fetch reservations by passenger
    public function lireReservationsParPassager() {
        return $this->reservation->lireReservationsParPassager($_SESSION['id']);
    }
}
?>
