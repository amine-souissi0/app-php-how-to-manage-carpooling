<?php
class Utilisateur {
    private $conn;
    private $table_name = "utilisateurs";

    public $id;
    public $nom;
    public $email;
    public $mot_de_passe;
    public $role;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function lireUtilisateurs() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function creerUtilisateur() {
        $query = "INSERT INTO " . $this->table_name . " SET nom=:nom, email=:email, mot_de_passe=:mot_de_passe, role=:role";
        $stmt = $this->conn->prepare($query);

        $this->mot_de_passe = password_hash($this->mot_de_passe, PASSWORD_DEFAULT);

        $stmt->bindParam(":nom", $this->nom);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":mot_de_passe", $this->mot_de_passe);
        $stmt->bindParam(":role", $this->role);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function connexion() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE email=:email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $this->email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($this->mot_de_passe, $user['mot_de_passe'])) {
            $_SESSION['id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            return true;
        }

        return false;
    }
}
?>
