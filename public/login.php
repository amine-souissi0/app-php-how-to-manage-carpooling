<?php
session_start();
require_once '../config/database.php';
require_once '../controllers/UtilisateurController.php';

$database = new Database();
$db = $database->getConnection();
$utilisateurController = new UtilisateurController($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = htmlspecialchars($_POST['email']);
    $mot_de_passe = htmlspecialchars($_POST['mot_de_passe']);

    if ($utilisateurController->connexion($email, $mot_de_passe)) {
        if ($_SESSION['role'] === 'administrateur') {
            header("Location: ../views/back/admin_dashboard.php");
        } elseif ($_SESSION['role'] === 'conducteur') {
            header("Location: ../views/front/conducteur_dashboard.php");
        } elseif ($_SESSION['role'] === 'passager') {
            header("Location: ../views/front/passager_dashboard.php");
        }
        exit();
    } else {
        $message = "Identifiants incorrects";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
</head>
<body>
    <h1>Connexion</h1>
    <?php if (!empty($message)) : ?>
        <p><?= $message ?></p>
    <?php endif; ?>
    <form action="" method="POST">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="mot_de_passe" placeholder="Mot de passe" required>
        <button type="submit">Connexion</button>
    </form>
</body>
</html>
