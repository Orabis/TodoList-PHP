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
// TODO Refacto to a function for use in html
$sql = "SELECT * FROM priorites";
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
            <label for="priorites"> Niveau de Priorité :</label>
            <select name="priorites" id="priorites">
                <option value="">--Choisir une priorité--</option>
                <?php foreach ($pdo->query($sql) as $row) {
                    print '<option value="' . $row['nom_priorite'] . '">' . $row['nom_priorite'] . '</option>';
                } ?>
            </select>
        </form>
    </div>
</main>
<footer>
    Léo Merkel
</footer>
</body>
</html>