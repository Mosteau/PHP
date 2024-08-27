<?php
const ERROR_REQUIRED = 'Veuillez renseigner une todo'; // Message d'erreur si aucune todo n'est renseignée
const ERROR_TOO_SHORT = 'Veuillez entrer au moins 5 caractères'; // Message d'erreur si la todo est trop courte
$filename = __DIR__ . "/data/todos.json"; // Chemin vers le fichier de sauvegarde des todos
$error = ''; // Variable pour stocker les éventuelles erreurs
$todo = ''; // Variable pour stocker la todo en cours d'ajout
$todos = []; // Tableau pour stocker toutes les todos

if (file_exists($filename)) {
    $data = file_get_contents($filename);
    $todos = json_decode($data, true) ?? []; // Charger les todos depuis le fichier JSON
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS); // Filtrer les données POST pour éviter les attaques XSS
    $todo = $_POST['todo'] ?? ''; // Récupérer la valeur de la todo depuis le formulaire

    if (!$todo) {
        $error = ERROR_REQUIRED; // Vérifier si la todo est vide
    } else if (mb_strlen($todo) < 5) {
        $error = ERROR_TOO_SHORT; // Vérifier si la todo est trop courte
    }

    if (!$error) {
        $todos = [...$todos, [
            'name' => $todo,
            'done' => false,
            'id' => time()
        ]]; // Ajouter la nouvelle todo au tableau des todos
        file_put_contents($filename, json_encode($todos)); // Sauvegarder les todos dans le fichier JSON
        $todo = ''; // Réinitialiser la variable todo
        header('Location: /'); // Rediriger vers la page d'accueil
    }
}
?>


<!DOCTYPE html>
<html lang="fr">
<?php require_once 'includes/head.php' ?>

<body>
    <div class="container">
        <?php require_once 'includes/header.php' ?>
        <div class="content">
            <div class="todo-container">
                <h1>Ma Todo</h1>
                <form class="todo-form" action="/" method="post">
                    <input value="<?= $todo ?>" name="todo" type="text"> <!-- Champ de saisie de la nouvelle todo -->
                    <button class="btn btn-primary">Ajouter</button> <!-- Bouton pour ajouter la todo -->
                </form>
                <?php if ($error) : ?>
                    <p class="text-danger"><?= $error ?></p> <!-- Afficher le message d'erreur s'il y en a un -->
                <?php endif; ?>
                <ul class="todo-list">
                    <?php foreach ($todos as $t) : ?>
                        <li class="todo-item <?= $t['done'] ? 'low-opacity' : '' ?>">
                            <span class="todo-name"><?= $t['name'] ?></span> <!-- Afficher le nom de la todo -->
                            <a href="/edit-todo.php?id=<?= $t['id'] ?>">
                                <button class="btn btn-primary btn-small"><?= $t['done'] ? 'Annuler' : 'Valider' ?></button> <!-- Bouton pour marquer la todo comme validée ou annuler la validation -->
                            </a>
                            <a href="/remove-todo.php?id=<?= $t['id'] ?>">
                                <button class="btn btn-danger btn-small">Supprimer</button> <!-- Bouton pour supprimer la todo -->
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <?php require_once 'includes/footer.php' ?>
    </div>
</body>

</html>