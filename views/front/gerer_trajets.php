<?php

session_start();
if ($_SESSION['role'] !== 'conducteur') {
    header("Location: ../public/login.php");
    exit();
}

require_once '../../config/database.php';
require_once '../../controllers/TrajetController.php';

$database = new Database();
$db = $database->getConnection();
$trajetController = new TrajetController($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['create'])) {
        $trajetController->creerTrajet($_POST);
    } elseif (isset($_POST['update'])) {
        $trajetController->mettreAJourTrajet($_POST['id'], $_POST);
    } elseif (isset($_POST['delete'])) {
        $trajetController->supprimerTrajet($_POST['id']);
    }
}

$trajets = $trajetController->lireTrajetsParConducteur();
?>
<a href="/public/login.php" style="color: red; text-decoration: none; font-weight: bold;">Déconnexion</a>

<h2>Gérer vos trajets</h2>

<!-- Form for adding a new trip -->
<h3>Ajouter un nouveau trajet</h3>
<form action="" method="POST">
    <input type="text" name="depart" placeholder="Lieu de départ" required>
    <input type="text" name="destination" placeholder="Destination" required>
    <input type="datetime-local" name="date" required>
    <input type="number" name="places_disponibles" placeholder="Nombre de places" required>
    <button type="submit" name="create">Créer</button>
</form>

<!-- Display the list of trips for the driver -->
<h3>Vos trajets</h3>
<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Départ</th>
            <th>Destination</th>
            <th>Date</th>
            <th>Places Disponibles</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($trajets as $trajet): ?>
        <tr>
            <td><?= $trajet['id'] ?></td>
            <td><?= $trajet['depart'] ?></td>
            <td><?= $trajet['destination'] ?></td>
            <td><?= $trajet['date'] ?></td>
            <td><?= $trajet['places_disponibles'] ?></td>
            <td>
                <!-- Form for updating the trip -->
                <form action="" method="POST">
                    <input type="hidden" name="id" value="<?= $trajet['id'] ?>">
                    <input type="text" name="depart" value="<?= $trajet['depart'] ?>" required>
                    <input type="text" name="destination" value="<?= $trajet['destination'] ?>" required>
                    <input type="datetime-local" name="date" value="<?= $trajet['date'] ?>" required>
                    <input type="number" name="places_disponibles" value="<?= $trajet['places_disponibles'] ?>" required>
                    <button type="submit" name="update">Mettre à jour</button>
                </form>

                <!-- Form for deleting the trip -->
                <form action="" method="POST">
                    <input type="hidden" name="id" value="<?= $trajet['id'] ?>">
                    <button type="submit" name="delete">Supprimer</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<!-- Form for searching trips -->
<h2>Rechercher et Trier les Trajets</h2>

<form action="" method="GET">
    <label for="depart">Départ :</label>
    <input type="text" name="depart" id="depart" placeholder="Départ" value="<?= isset($_GET['depart']) ? htmlspecialchars($_GET['depart']) : '' ?>">

    <label for="destination">Destination :</label>
    <input type="text" name="destination" id="destination" placeholder="Destination" value="<?= isset($_GET['destination']) ? htmlspecialchars($_GET['destination']) : '' ?>">

    <label for="date">Date :</label>
    <input type="date" name="date" id="date" value="<?= isset($_GET['date']) ? htmlspecialchars($_GET['date']) : '' ?>">

    <label for="sort_column">Trier par :</label>
    <select name="sort_column" id="sort_column">
        <option value="date" <?= (isset($_GET['sort_column']) && $_GET['sort_column'] == 'date') ? 'selected' : '' ?>>Date</option>
        <option value="depart" <?= (isset($_GET['sort_column']) && $_GET['sort_column'] == 'depart') ? 'selected' : '' ?>>Départ</option>
        <option value="destination" <?= (isset($_GET['sort_column']) && $_GET['sort_column'] == 'destination') ? 'selected' : '' ?>>Destination</option>
        <option value="places_disponibles" <?= (isset($_GET['sort_column']) && $_GET['sort_column'] == 'places_disponibles') ? 'selected' : '' ?>>Places Disponibles</option>
    </select>

    <label for="sort_order">Ordre :</label>
    <select name="sort_order" id="sort_order">
        <option value="ASC" <?= (isset($_GET['sort_order']) && $_GET['sort_order'] == 'ASC') ? 'selected' : '' ?>>Ascendant</option>
        <option value="DESC" <?= (isset($_GET['sort_order']) && $_GET['sort_order'] == 'DESC') ? 'selected' : '' ?>>Descendant</option>
    </select>

    <button type="submit">Rechercher et Trier</button>
</form>

<hr>

<!-- Table displaying the search results -->
<h2>Liste des Trajets</h2>
<table>
    <thead>
        <tr>
            <th>Départ</th>
            <th>Destination</th>
            <th>Date</th>
            <th>Places Disponibles</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Call the controller to get the search results
        $criteria = [
            'depart' => $_GET['depart'] ?? '',
            'destination' => $_GET['destination'] ?? '',
            'date' => $_GET['date'] ?? '',
        ];
        $sort_column = $_GET['sort_column'] ?? 'date';
        $sort_order = $_GET['sort_order'] ?? 'ASC';

        $trips = $trajetController->rechercherEtTrierTrajets($criteria, $sort_column, $sort_order);

        foreach ($trips as $trip) : ?>
            <tr>
                <td><?= htmlspecialchars($trip['depart']) ?></td>
                <td><?= htmlspecialchars($trip['destination']) ?></td>
                <td><?= htmlspecialchars($trip['date']) ?></td>
                <td><?= htmlspecialchars($trip['places_disponibles']) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
