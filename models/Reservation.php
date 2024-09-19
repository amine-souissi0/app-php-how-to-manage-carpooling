<?php
class Reservation {
    private $conn;
    private $table = 'reservations';

    public $id;
    public $trajet_id;
    public $passager_id;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function creerReservation() {
        $query = "INSERT INTO " . $this->table . " (trajet_id, passager_id) VALUES (:trajet_id, :passager_id)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':trajet_id', $this->trajet_id);
        $stmt->bindParam(':passager_id', $this->passager_id);
        return $stmt->execute();
    }

    public function lireReservationsParPassager($passager_id) {
        $query = "SELECT t.depart, t.destination, r.date_reservation FROM " . $this->table . " r 
                  JOIN trips t ON r.trajet_id = t.id 
                  WHERE r.passager_id = :passager_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':passager_id', $passager_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
