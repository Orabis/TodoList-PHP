<?php
$user = getenv("DB_USER");
$pass = getenv("DB_PASSWORD");
$db = getenv("DB_NAME");
$port = getenv("DB_PORT");
$host = getenv("DB_HOST");

try {
    $pdo = new PDO("pgsql:host={$host};port={$port};dbname={$db}", $user, $pass);
} catch (PDOException $e) {
    echo "Error!: " . $e->getMessage();
    die();
}
function query_options($pdo, $table, $idColumn, $valueColumn, $is_tags = false){
    $sql = "SELECT * FROM $table";
    foreach ($pdo->query($sql) as $row) {
        $id = htmlspecialchars($row[$idColumn]);
        $label = htmlspecialchars($row[$valueColumn]);

        if ($is_tags) {
            echo '<label>';
            echo '<input type="checkbox" name="tags[]" value="' . $id . '"> ' . $label;
            echo '</label>';
        } else {
            echo '<option value="' . $id . '">' . $label . '</option>';
        }
    }
}

if (isset($_POST['submit_task'])) {
    $title       = !empty($_POST['title']) ? $_POST['title'] : null;
    $description = !empty($_POST['description']) ? $_POST['description'] : null;
    $priorites   = !empty($_POST['priorites']) ? (int)$_POST['priorites'] : null;
    $contexte    = !empty($_POST['contexte']) ? (int)$_POST['contexte'] : null;
    $type        = !empty($_POST['type']) ? (int)$_POST['type'] : null;
    $status      = !empty($_POST['status']) ? (int)$_POST['status'] : null;
    $tags        = $_POST['tags'] ?? [];
    $sql = "INSERT INTO tache (titre, description,date_crea, id_priorite, id_contexte,id_type, id_statut) VALUES (?, ?,NOW(),?, ?, ?, ?)";
    $pdo->prepare($sql)->execute([$title, $description, $priorites, $contexte, $type, $status]);
    $tache_id = $pdo->lastInsertId();
    $sql_tag = "INSERT INTO tache_tag (id_tache, id_tag) VALUES (?, ?)";
    $stmt_tag = $pdo->prepare($sql_tag);
    foreach ($tags as $tag) {
        $stmt_tag->execute([$tache_id, $tag]);
    }
    echo '<p>Tâche crée avec succès !</p>';
}
elseif (isset($_POST['submit_tag'])) {
    $name_tag = trim($_POST['create_tag'] ?? '');
    if (empty($name_tag)) {
        echo '<p>Veuillez renseigner un tag valide.</p>';
    } else {
        $sql = "INSERT INTO tags (nom_tag) VALUES (?)";
        $pdo->prepare($sql)->execute([$name_tag]);
        echo '<p>Tag créé avec succès !</p>';
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
                    <?php query_options($pdo, "priorites","id_priorite" ,"nom_priorite"); ?>
                </select>
            </label>
            <label>
                Contexte :
                <select name="contexte" id="contexte">
                    <option value="">--Choisir un Contexte</option>
                    <?php query_options($pdo, "contexte","id_contexte", "nom_contexte"); ?>
                </select>
            </label>
            <label>
                Type :
                <select name="type" id="type">
                    <option value="">--Choisir un Type--</option>
                    <?php query_options($pdo, "type_tache","id_type", "nom_type"); ?>
                </select>
            </label>
            <label>
                Statut :
                <select name="status" id="status">
                    <option value="">--Choisir un Status</option>
                    <?php query_options($pdo, "statuts","id_statut", "libelle"); ?>
                </select>
            </label>
            <fieldset>
                <legend>Tags :</legend>
                <?php query_options($pdo, "tags","id_tag","nom_tag", true); ?>
            </fieldset>
            <button type="submit" name="submit_task">Ajouter</button>
        </form>
        <form method="POST" action="">
            <label>
                Crée un tag :
                <input id="create_tag" name="create_tag" type="text">
            </label>
            <button type="submit" name="submit_tag">Crée</button>
        </form>
    </div>
    <?php
    $sql = "
    SELECT 
        tache.id_tache, tache.titre, tache.description, tache.date_crea,
        priorites.nom_priorite, 
        contexte.nom_contexte, 
        statuts.libelle, 
        type_tache.nom_type,
        tags.id_tag, tags.nom_tag
    FROM tache 
    LEFT JOIN priorites ON priorites.id_priorite = tache.id_priorite
    LEFT JOIN contexte ON contexte.id_contexte = tache.id_contexte
    LEFT JOIN statuts ON statuts.id_statut = tache.id_statut
    LEFT JOIN type_tache ON type_tache.id_type = tache.id_type
    LEFT JOIN tache_tag ON tache.id_tache = tache_tag.id_tache
    LEFT JOIN tags ON tache_tag.id_tag = tags.id_tag
    ";

    $tachesTriees = [];
    foreach ($pdo->query($sql) as $row) {
        $id = $row['id_tache'];
        if (!isset($tachesTriees[$id])) {
            $tachesTriees[$id] = [
                    'titre' => $row['titre'],
                    'description' => $row['description'],
                    'date_crea' => $row['date_crea'],
                    'nom_priorite' => $row['nom_priorite'],
                    'nom_contexte' => $row['nom_contexte'],
                    'nom_type' => $row['nom_type'],
                    'tags' => []
            ];
        }
        if ($row['id_tag']) {
            $tachesTriees[$id]['tags'][] = $row['nom_tag'];
        }
    }
    echo "<div>";
    echo "<h2>Tâches actuelles :</h2>";

    foreach ($tachesTriees as $tache) {
        $titre_secu = htmlspecialchars($tache['titre']);
        $desc_secu = htmlspecialchars($tache['description']);
        $liste_tags = implode(', ', $tache['tags']);

        echo "<p> $titre_secu | $desc_secu | $tache[date_crea] | $tache[nom_priorite] | $tache[nom_contexte] | $tache[nom_type] | Tags : $liste_tags </p>";
    }
    echo "</div>";
    ?>
</main>
<footer>
    <p>Léo Merkel - 2026</p>
</footer>
</body>
</html>