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
            echo '<label class="tag-checkbox">';
            echo '<input type="checkbox" name="tags[]" value="' . $id . '"> ' . $label;
            echo '</label>';
        } else {
            echo '<option value="' . $id . '">' . $label . '</option>';
        }
    }
}

if (isset($_POST['submit_task'])) {
    $title       = !empty($_POST['title']) ? trim($_POST['title']) : null;
    $description = !empty($_POST['description']) ? trim($_POST['description']) : null;
    $priorites   = !empty($_POST['priorites']) ? (int)$_POST['priorites'] : null;
    $contexte    = !empty($_POST['contexte']) ? (int)$_POST['contexte'] : null;
    $type        = !empty($_POST['type']) ? (int)$_POST['type'] : null;
    $status      = !empty($_POST['status']) ? (int)$_POST['status'] : null;
    $tags        = $_POST['tags'] ?? [];

    if ($title) {
        $check_sql = "SELECT COUNT(*) FROM tache WHERE LOWER(titre) = LOWER(?)";
        $check_stmt = $pdo->prepare($check_sql);
        $check_stmt->execute([$title]);
        $task_exists = $check_stmt->fetchColumn();

        if ($task_exists > 0) {
            echo '<p class="alert alert-error">Une tâche avec ce titre existe déjà.</p>';
        } else {
            $sql = "INSERT INTO tache (titre, description, date_crea, id_priorite, id_contexte, id_type, id_statut) VALUES (?, ?, NOW(), ?, ?, ?, ?)";
            $pdo->prepare($sql)->execute([$title, $description, $priorites, $contexte, $type, $status]);
            $tache_id = $pdo->lastInsertId();
            if (!empty($tags)) {
                $sql_tag = "INSERT INTO tache_tag (id_tache, id_tag) VALUES (?, ?)";
                $stmt_tag = $pdo->prepare($sql_tag);
                foreach ($tags as $tag) {
                    $stmt_tag->execute([$tache_id, $tag]);
                }
            }
            echo '<p class="alert alert-success">Tâche créée avec succès !</p>';
        }
    } else {
        echo '<p class="alert alert-error">Le titre de la tâche est obligatoire.</p>';
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
    <header class="page-header">
        <hgroup>
            <h1>To Do List</h1>
            <p>Liste des tâches à faire</p>
        </hgroup>
    </header>

    <div class="forms-container">
        <form method="POST" action="" class="form-card">
            <h2>Créer une nouvelle tâche</h2>
            <div class="form-group">
                <label for="title">Titre de la tâche</label>
                <input name="title" id="title" type="text" required>
            </div>

            <div class="form-group">
                <label for="descr">Description</label>
                <input name="description" id="descr" type="text">
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="priorites">Priorité</label>
                    <select name="priorites" id="priorites">
                        <option value="">--Choisir--</option>
                        <?php query_options($pdo, "priorites","id_priorite" ,"nom_priorite"); ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="contexte">Contexte</label>
                    <select name="contexte" id="contexte">
                        <option value="">--Choisir--</option>
                        <?php query_options($pdo, "contexte","id_contexte", "nom_contexte"); ?>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="type">Type</label>
                    <select name="type" id="type">
                        <option value="">--Choisir--</option>
                        <?php query_options($pdo, "type_tache","id_type", "nom_type"); ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="status">Statut</label>
                    <select name="status" id="status">
                        <option value="">--Choisir--</option>
                        <?php query_options($pdo, "statuts","id_statut", "libelle"); ?>
                    </select>
                </div>
            </div>

            <fieldset class="tags-fieldset">
                <legend>Tags :</legend>
                <div class="tags-grid">
                    <?php query_options($pdo, "tags","id_tag","nom_tag", true); ?>
                </div>
            </fieldset>

            <button type="submit" name="submit_task" class="btn-primary">Ajouter la tâche</button>
        </form>

        <form method="POST" action="" class="form-card form-tag">
            <h2>Créer un tag</h2>
            <div class="form-group">
                <label for="create_tag">Nom du tag :</label>
                <input id="create_tag" name="create_tag" type="text">
            </div>
            <button type="submit" name="submit_tag" class="btn-secondary">Créer</button>
        </form>
    </div>

    <section class="tasks-section">
        <h2>Tâches actuelles</h2>
        <div class="task-list">
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

            if (empty($tachesTriees)) {
                echo "<p class='empty-state'>Aucune tâche pour le moment.</p>";
            } else {
                foreach ($tachesTriees as $tache) {
                    $titre_secu = htmlspecialchars($tache['titre']);
                    $desc_secu = htmlspecialchars($tache['description']);

                    echo '<article class="task-card">';
                    echo "<header class='task-header'>";
                    echo "<h3>{$titre_secu}</h3>";
                    echo "<span class='task-date'>" . date('d/m/Y', strtotime($tache['date_crea'])) . "</span>";
                    echo "</header>";

                    if (!empty($desc_secu)) {
                        echo "<p class='task-desc'>{$desc_secu}</p>";
                    }

                    echo "<div class='task-meta'>";
                    if ($tache['nom_priorite']) echo "<span class='badge badge-priority'>{$tache['nom_priorite']}</span>";
                    if ($tache['nom_contexte']) echo "<span class='badge'>{$tache['nom_contexte']}</span>";
                    if ($tache['nom_type']) echo "<span class='badge'>{$tache['nom_type']}</span>";
                    echo "</div>";

                    if (!empty($tache['tags'])) {
                        echo "<div class='task-tags'>";
                        foreach ($tache['tags'] as $tag) {
                            echo "<span class='tag-badge'>#" . htmlspecialchars($tag) . "</span>";
                        }
                        echo "</div>";
                    }
                    echo '</article>';
                }
            }
            ?>
        </div>
    </section>
</main>
<footer class="page-footer">
    <p>Léo Merkel - 2026</p>
</footer>
</body>
</html>