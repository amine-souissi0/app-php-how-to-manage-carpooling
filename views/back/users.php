<link rel="stylesheet" href="../css/style.css">

<?php
session_start();

// Check if the user is logged in and is an administrator
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'administrateur') {
    header("Location: /public/login.php");
    exit();
}

require_once '../../config/database.php';
require_once '../../controllers/UtilisateurController.php';

$database = new Database();
$db = $database->getConnection();

$utilisateurController = new UtilisateurController($db);

$errors = [];

// Handle form submission for creating, updating, and deleting users
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['create'])) {
        $result = $utilisateurController->creerUtilisateur($_POST);
        if (is_array($result)) {
            $errors = $result;
        } else {
            header('Location: users.php');
            exit();
        }
    } elseif (isset($_POST['update'])) {
        $utilisateurController->mettreAJourUtilisateur($_POST['id'], $_POST);
    } elseif (isset($_POST['delete'])) {
        $utilisateurController->supprimerUtilisateur($_POST['id']);
    }
}

// Sorting and listing users
// Handle search and sorting parameters from the GET request
$search_nom = isset($_GET['nom']) ? $_GET['nom'] : '';
$search_email = isset($_GET['email']) ? $_GET['email'] : '';
$search_role = isset($_GET['role']) ? $_GET['role'] : '';
$tri_colonne = isset($_GET['tri_colonne']) ? $_GET['tri_colonne'] : 'id';
$tri_ordre = isset($_GET['tri_ordre']) && $_GET['tri_ordre'] === 'ASC' ? 'ASC' : 'DESC';

// Fetch the filtered and sorted user list
$utilisateurs = $utilisateurController->lireUtilisateurs($tri_colonne, $tri_ordre, $search_nom, $search_email, $search_role);


$title = "Gestion des Utilisateurs";
ob_start();
?>

<div class="container">
    <?php if (!empty($errors)): ?>
    <div class="errors">
        <?php foreach ($errors as $error): ?>
            <p><?= htmlspecialchars($error) ?></p>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <h2 class="title">Créer un nouvel utilisateur</h2>
    <form id="createUserForm" action="" method="POST" class="form">
        <input type="text" name="nom" placeholder="Nom" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="mot_de_passe" placeholder="Mot de passe" required>
        <select name="role" required>
            <option value="administrateur">Administrateur</option>
            <option value="conducteur">Conducteur</option>
            <option value="passager">Passager</option>
        </select>
        <button type="submit" name="create" class="button">Créer</button>
    </form>

    <h2 class="title">Recherche multicritères</h2>
    <form action="" method="GET" class="form">
        <input type="text" name="nom" placeholder="Nom">
        <input type="email" name="email" placeholder="Email">
        <select name="role">
            <option value="">Tous les rôles</option>
            <option value="administrateur">Administrateur</option>
            <option value="conducteur">Conducteur</option>
            <option value="passager">Passager</option>
        </select>
        <select name="tri_colonne">
            <option value="id">Trier par ID</option>
            <option value="nom">Trier par Nom</option>
            <option value="email">Trier par Email</option>
            <option value="role">Trier par Rôle</option>
        </select>
        <select name="tri_ordre">
            <option value="ASC">Ordre Ascendant</option>
            <option value="DESC">Ordre Descendant</option>
        </select>
        <button type="submit" class="button">Rechercher</button>
    </form>

    <h2 class="title">Liste des utilisateurs</h2>
    <table class="user-table">
        <thead>
            <tr>
                <th><a href="?tri_colonne=id&tri_ordre=<?= isset($_GET['tri_ordre']) && $_GET['tri_ordre'] == 'ASC' ? 'DESC' : 'ASC' ?>">ID</a></th>
                <th><a href="?tri_colonne=nom&tri_ordre=<?= isset($_GET['tri_ordre']) && $_GET['tri_ordre'] == 'ASC' ? 'DESC' : 'ASC' ?>">Nom</a></th>
                <th><a href="?tri_colonne=email&tri_ordre=<?= isset($_GET['tri_ordre']) && $_GET['tri_ordre'] == 'ASC' ? 'DESC' : 'ASC' ?>">Email</a></th>
                <th><a href="?tri_colonne=role&tri_ordre=<?= isset($_GET['tri_ordre']) && $_GET['tri_ordre'] == 'ASC' ? 'DESC' : 'ASC' ?>">Rôle</a></th>
                <th>Date de Création</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($utilisateurs as $utilisateur): ?>
            <tr>
                <td><?= htmlspecialchars($utilisateur['id']) ?></td>
                <td><?= htmlspecialchars($utilisateur['nom']) ?></td>
                <td><?= htmlspecialchars($utilisateur['email']) ?></td>
                <td><?= htmlspecialchars($utilisateur['role']) ?></td>
                <td><?= htmlspecialchars($utilisateur['date_creation']) ?></td>
                <td class="actions">
                    <form action="" method="POST" style="display:inline;">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($utilisateur['id']) ?>">
                        <input type="text" name="nom" value="<?= htmlspecialchars($utilisateur['nom']) ?>" required>
                        <input type="email" name="email" value="<?= htmlspecialchars($utilisateur['email']) ?>" required>
                        <select name="role" required>
                            <option value="administrateur" <?= $utilisateur['role'] === 'administrateur' ? 'selected' : '' ?>>Administrateur</option>
                            <option value="conducteur" <?= $utilisateur['role'] === 'conducteur' ? 'selected' : '' ?>>Conducteur</option>
                            <option value="passager" <?= $utilisateur['role'] === 'passager' ? 'selected' : '' ?>>Passager</option>
                        </select>
                        <button type="submit" name="update" class="button">Mettre à jour</button>
                    </form>
                    <form action="" method="POST" style="display:inline;">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($utilisateur['id']) ?>">
                        <button type="submit" name="delete" class="button">Supprimer</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h2 class="title">Statistiques</h2>
    <p>Nombre total d'utilisateurs : <?= $utilisateurController->compterUtilisateurs(); ?></p>
</div>

<script>
document.getElementById('createUserForm').addEventListener('submit', function(event) {
    var nom = document.querySelector('input[name="nom"]').value.trim();
    var email = document.querySelector('input[name="email"]').value.trim();
    var motDePasse = document.querySelector('input[name="mot_de_passe"]').value.trim();
    var role = document.querySelector('select[name="role"]').value;

    var errors = [];

    if (nom === '') {
        errors.push('Le nom est requis.');
    }

    if (!validateEmail(email)) {
        errors.push('Un email valide est requis.');
    }

    if (motDePasse.length < 6) {
        errors.push('Le mot de passe doit comporter au moins 6 caractères.');
    }

    if (role === '') {
        errors.push('Le rôle est requis.');
    }

    if (errors.length > 0) {
        alert(errors.join('\n'));
        event.preventDefault(); // Prevent form submission if there are errors
    }
});

function validateEmail(email) {
    var re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}
</script>


<?php
$content = ob_get_clean();
include '../../base_back.php';
?>
