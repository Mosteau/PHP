<?php
$filename = __DIR__ . "/data/todos.json";

// Récupère l'id de la tâche à modifier depuis la requête GET
$_GET = filter_input_array(INPUT_GET, FILTER_VALIDATE_INT);
$id = $_GET['id'] ?? '';

if ($id) {
    // Lit le contenu du fichier JSON contenant les tâches
    $data = file_get_contents($filename);
    $todos = json_decode($data, true) ?? [];

    if (count($todos)) {
        // Recherche l'index de la tâche à modifier dans le tableau des tâches
        $todoIndex = array_search($id, array_column($todos, 'id'));

        // Inverse l'état de la tâche (passage de "fait" à "non fait" et vice versa)
        $todos[$todoIndex]['done'] = !$todos[$todoIndex]['done'];

        // Écrit le tableau des tâches modifié dans le fichier JSON
        file_put_contents($filename, json_encode($todos));
    }
}

// Redirige vers la page d'accueil
header('Location: /');
