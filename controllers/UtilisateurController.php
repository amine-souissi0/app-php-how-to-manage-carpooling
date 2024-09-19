<?php
class UtilisateurController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }


    public function compterUtilisateurs() {
        $query = "SELECT COUNT(*) as total FROM Users"; // Adjust 'utilisateurs' to match your table name
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total']; // Returning the total count
    }

    public function creerUtilisateur($data) {
        $sql = "INSERT INTO Users (nom, email, mot_de_passe, role) VALUES (:nom, :email, :mot_de_passe, :role)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nom', $data['nom']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':mot_de_passe', password_hash($data['mot_de_passe'], PASSWORD_DEFAULT));
        $stmt->bindParam(':role', $data['role']);
        return $stmt->execute();
    }

     // Updated lireUtilisateurs method to handle search and sort criteria
     public function lireUtilisateurs($tri_colonne = 'id', $tri_ordre = 'ASC', $search_nom = '', $search_email = '', $search_role = '') {
        $query = "SELECT * FROM users WHERE 1=1";

        // Add search filters if they exist
        if (!empty($search_nom)) {
            $query .= " AND nom LIKE :nom";
        }
        if (!empty($search_email)) {
            $query .= " AND email LIKE :email";
        }
        if (!empty($search_role)) {
            $query .= " AND role = :role";
        }

        // Add sorting criteria
        $query .= " ORDER BY " . $tri_colonne . " " . $tri_ordre;

        $stmt = $this->db->prepare($query);

        // Bind search parameters if they are set
        if (!empty($search_nom)) {
            $stmt->bindValue(':nom', '%' . $search_nom . '%');
        }
        if (!empty($search_email)) {
            $stmt->bindValue(':email', '%' . $search_email . '%');
        }
        if (!empty($search_role)) {
            $stmt->bindValue(':role', $search_role);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function mettreAJourUtilisateur($id, $data) {
        $sql = "UPDATE Users SET nom = :nom, email = :email, role = :role WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nom', $data['nom']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':role', $data['role']);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function supprimerUtilisateur($id) {
        $sql = "DELETE FROM Users WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function connexion($email, $mot_de_passe) {
        $query = "SELECT * FROM Users WHERE email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($user && password_verify($mot_de_passe, $user['mot_de_passe'])) {
            $_SESSION['id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            return true;
        }
        return false;
    }
}
?>
