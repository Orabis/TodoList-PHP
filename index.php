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
function query_options($pdo, $table, $valueColumn, $is_tags = false)
{
    $sql = "SELECT * FROM $table";
    foreach ($pdo->query($sql) as $row) {
        if ($is_tags) {
            print '<label>';
            print '<input type="checkbox" name="tags[]" value="' . $row[$valueColumn] . '"> ' . $row[$valueColumn];
            print '</label><br>';
        } else {
            print '<option value="' . $row[$valueColumn] . '">' . $row[$valueColumn] . '</option>';
        }
    }
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
            <label>
                Titre de la tâche
                <input name="title" id="title" type="text">
            </label>
            <label>
                Description
                <input name="description" id="descr" type="text">
            </label>
            <label>
                Niveau de Priorité :
                <select name="priorites" id="priorites">
                    <option value="">--Choisir une Priorité--</option>
                    <?php query_options($pdo, "priorites", "nom_priorite"); ?>
                </select>
            </label>
            <label>
                Contexte :
                <select name="contexte" id="contexte">
                    <option value="">--Choisir un Contexte</option>
                    <?php query_options($pdo, "contextes", "nom_contexte"); ?>
                </select>
            </label>
            <label>
                Type :
                <select name="type" id="type">
                    <option value="">--Choisir un Type--</option>
                    <?php query_options($pdo, "type_tache", "nom_type"); ?>
                </select>
            </label>
            <label>
                Statut :
                <select name="status" id="status">
                    <option value="">--Choisir un Status</option>
                    <?php query_options($pdo, "status", "libelle"); ?>
                </select>
            </label>
            <fieldset>
                <legend>Tags :</legend>
                <?php query_options($pdo, "tags", "nom_tag", true); ?>
            </fieldset>
            <button type="submit">Ajouter</button>
        </form>
    </div>
</main>
<footer>
    <p>Léo Merkel - 2026</p>
</footer>
</body>
</html>