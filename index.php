<?php
$user = getenv("DB_USER");
$pass = getenv("DB_PASSWORD");
$db = getenv("DB_NAME");
$port = getenv("DB_PORT");
$host = getenv("DB_HOST");

try {
    $pdo = new PDO("pgsql:host={$host};port={$port};dbname={$db}", $user, $pass);
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
$sql = "SELECT * FROM priorites";
foreach ($pdo->query($sql) as $row) {
    print $row['nom_priorite'];
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <title>TodoList</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<main>
    <hgroup>
        <h1>To Do List </h1>
        <p>Liste des tâches à faire</p>
    </hgroup>
    <div>
        <form method="POST" action="">
            <h2>Crée une nouvelle tâche</h2>
        </form>
    </div>
</main>
<footer>
    Léo Merkel
</footer>
</body>
</html>