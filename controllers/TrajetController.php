
<?php
require_once __DIR__ . '/../models/Trajet.php';

class TrajetController {
    private $db;
    private $trajet;

    public function __construct($db) {
        $this->db = $db;
        $this->trajet = new Trajet($db);
    }

    public function creerTrajet($data) {
        $this->trajet->conducteur_id = $_SESSION['id'];
        $this->trajet->depart = $data['depart'];
        $this->trajet->destination = $data['destination'];
        $this->trajet->date = $data['date'];
        $this->trajet->places_disponibles = $data['places_disponibles'];
        return $this->trajet->creerTrajet();
    }

    public function lireTrajetsParConducteur() {
        return $this->trajet->lireTrajetsParConducteur($_SESSION['id']);
    }

    public function mettreAJourTrajet($id, $data) {
        $this->trajet->conducteur_id = $_SESSION['id'];
        $this->trajet->depart = $data['depart'];
        $this->trajet->destination = $data['destination'];
        $this->trajet->date = $data['date'];
        $this->trajet->places_disponibles = $data['places_disponibles'];
        return $this->trajet->mettreAJourTrajet($id);
    }

    public function supprimerTrajet($id) {
        $this->trajet->conducteur_id = $_SESSION['id'];
        return $this->trajet->supprimerTrajet($id);
    }


    public function rechercherEtTrierTrajets($criteria = [], $sort_column = 'date', $sort_order = 'ASC') {
        $query = "SELECT * FROM trips WHERE 1=1";  // Basic query
    
        // Building the search part of the query based on criteria
        if (!empty($criteria['depart'])) {
            $query .= " AND depart LIKE :depart";
        }
        if (!empty($criteria['destination'])) {
            $query .= " AND destination LIKE :destination";
        }
        if (!empty($criteria['date'])) {
            $query .= " AND date = :date";
        }
    
        // Sorting the results
        $query .= " ORDER BY " . $sort_column . " " . $sort_order;
    
        $stmt = $this->db->prepare($query);
    
        // Binding the criteria
        if (!empty($criteria['depart'])) {
            $stmt->bindParam(':depart', $criteria['depart']);
        }
        if (!empty($criteria['destination'])) {
            $stmt->bindParam(':destination', $criteria['destination']);
        }
        if (!empty($criteria['date'])) {
            $stmt->bindParam(':date', $criteria['date']);
        }
    
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);  // Fetch the results
    }
    

    public function lireReservationsParTrajet($conducteur_id) {
        $query = "SELECT u.nom as passager_nom, u.email as passager_email, t.depart, t.destination, t.date as date_trajet, r.date_reservation 
                  FROM reservations r
                  JOIN trips t ON r.trajet_id = t.id
                  JOIN users u ON r.passager_id = u.id
                  WHERE t.conducteur_id = :conducteur_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':conducteur_id', $conducteur_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

}
?>
