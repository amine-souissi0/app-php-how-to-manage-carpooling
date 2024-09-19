<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="/public/assets/styles.css"> <!-- Include your CSS file here -->
</head>
<body>
    <header>
        <h1>Back Office</h1>
        <nav>
            <a href="/views/back/users.php">Gérer les utilisateurs</a>
            <a href="/views/back/trajets.php">Gérer les trajets</a>
            <a href="/public/logout.php">Déconnexion</a>
        </nav>
    </header>
    
    <main>
        <?= $content ?> <!-- This is where the content from other files will be displayed -->
    </main>
    
    <footer>
        <p>&copy; <?= date('Y') ?> Votre Société. Tous droits réservés.</p>
    </footer>
</body>
</html>
