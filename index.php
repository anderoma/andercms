<?php
// Inclure le fichier de configuration si nécessaire
include __DIR__ . '/config.php';

// Récupérer la partie de l'URL après le domaine (ex: /menu, /contact, ...)
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); // Récupère le chemin de l'URL
$requestUri = trim($requestUri, '/'); // Enlève les slashes en début et fin

// Si l'URL est vide, cela signifie qu'on veut afficher la page d'accueil par défaut
$page = $requestUri ?: 'home'; // Si la page est vide, afficher 'home'

// // Définir les pages disponibles et leurs fichiers associés
// $availablePages = [
//     'home' => '/pages/home.php',
//     'menu' => '/pages/menu.php',
//     'contact' => '/pages/contact.php', // Assurez-vous que le fichier contact.php existe
// ];

// Générer dynamiquement les pages disponibles à partir des fichiers JSON du dossier content
$availablePages = [];
$contentDir = __DIR__ . '/content';

// Vérifier si le dossier content existe
if (is_dir($contentDir)) {
    // Parcourir tous les fichiers du dossier content
    $files = scandir($contentDir);

    foreach ($files as $file) {
        // Ignorer les entrées . et ..
        if ($file === '.' || $file === '..') {
            continue;
        }

        // Ne traiter que les fichiers JSON
        if (pathinfo($file, PATHINFO_EXTENSION) === 'json' && is_file($contentDir . '/' . $file)) {
            // Récupérer le nom du fichier sans extension
            $pageName = pathinfo($file, PATHINFO_FILENAME);

            // Ajouter à la liste des pages disponibles
            $availablePages[$pageName] = '/pages/' . $pageName . '.php';
        }
    }
}

// Vérifier si la page demandée existe, sinon rediriger vers une page 404
if (array_key_exists($page, $availablePages)) {
    include __DIR__ . $availablePages[$page]; // Inclure la page correspondante
} else {
    // Si la page n'existe pas, afficher une page 404
    include 'pages/404.php';
}
