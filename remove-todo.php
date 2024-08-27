<?php
$filename = __DIR__ . "/data/todos.json"; // Chemin du fichier contenant les todos
$_GET = filter_input_array(INPUT_GET, FILTER_VALIDATE_INT); // Filtrer les valeurs de la superglobale $_GET pour s'assurer qu'elles sont des entiers
$id = $_GET['id'] ?? ''; // Récupérer l'ID du todo à supprimer depuis la superglobale $_GET

if ($id) {
    $todos = json_decode(file_get_contents($filename), true) ?? []; // Lire le contenu du fichier JSON et le décoder en tableau associatif
    if (count($todos)) {
        $todoIndex = array_search($id, array_column($todos, 'id')); // Trouver l'index du todo correspondant à l'ID dans le tableau des todos
        array_splice($todos, $todoIndex, 1); // Supprimer le todo du tableau
        file_put_contents($filename, json_encode($todos)); // Encoder le tableau des todos en JSON et le sauvegarder dans le fichier
    }
}

header('Location: /'); // Rediriger vers la page d'accueil