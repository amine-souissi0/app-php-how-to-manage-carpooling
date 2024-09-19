
<?php
class Database {
    private $host = 'localhost';
    private $db_name = 'covoiturage';
    private $username = 'noauthuser'; // Remplacez par votre nom d'utilisateur
    private $password = ''; // Remplacez par votre mot de passe
    public $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            echo "Erreur de connexion : " . $exception->getMessage();
        }

        return $this->conn;
    }
}
