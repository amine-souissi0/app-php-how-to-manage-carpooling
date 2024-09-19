<a href="/public/login.php" style="color: red; text-decoration: none; font-weight: bold;">Déconnexion</a>

<h2>Rechercher des trajets</h2>
<form method="GET" action="">
    <input type="text" name="depart" placeholder="Lieu de départ">
    <input type="text" name="destination" placeholder="Destination">
    <input type="date" name="date_depart">
    <button type="submit">Rechercher</button>
</form>

<h2>Liste des trajets</h2>
<table>
    <thead>
        <tr>
            <th>Départ</th>
            <th>Destination</th>
            <th>Date/Heure</th>
            <th>Prix</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <!-- Loop through trips and display them -->
    </tbody>
</table>
