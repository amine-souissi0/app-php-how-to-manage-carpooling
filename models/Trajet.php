<?php
class Trajet {
    private $conn;
    private $table_name = "trips"; // Your table name

    public $id;
    public $conducteur_id;
    public $depart;
    public $destination;
    public $date;
    public $places_disponibles;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create a new trip
    public function creerTrajet() {
        $query = "INSERT INTO " . $this->table_name . " SET conducteur_id=:conducteur_id, depart=:depart, destination=:destination, date=:date, places_disponibles=:places_disponibles";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":conducteur_id", $this->conducteur_id);
        $stmt->bindParam(":depart", $this->depart);
        $stmt->bindParam(":destination", $this->destination);
        $stmt->bindParam(":date", $this->date);
        $stmt->bindParam(":places_disponibles", $this->places_disponibles);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Get all trips for a specific driver
    public function lireTrajetsParConducteur($conducteur_id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE conducteur_id = :conducteur_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':conducteur_id', $conducteur_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Update a trip
    public function mettreAJourTrajet($id) {
        $query = "UPDATE " . $this->table_name . " SET depart=:depart, destination=:destination, date=:date, places_disponibles=:places_disponibles WHERE id=:id AND conducteur_id=:conducteur_id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":depart", $this->depart);
        $stmt->bindParam(":destination", $this->destination);
        $stmt->bindParam(":date", $this->date);
        $stmt->bindParam(":places_disponibles", $this->places_disponibles);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":conducteur_id", $this->conducteur_id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Delete a trip
    public function supprimerTrajet($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id AND conducteur_id = :conducteur_id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":conducteur_id", $this->conducteur_id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }


    
}


?>
