<?php
// Inclure le fichier de configuration si nécessaire
include __DIR__ . '/../config.php';

// admin.php - Interface d'administration pour gérer les contenus

// Vérification de l'authentification (ajouter la logique plus tard)
// session_start();
// if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
//     header("Location: login.php");
//     exit;
// }

// Récupérer les contenus (exemple avec home.json)
$contentFile = CONTENT_PATH . '/home.json';
$contentData = json_decode(file_get_contents($contentFile), true);

// Variable pour savoir si le toast doit être affiché
$showToast = false;

if (!empty($_POST)) {
    // Traitement des données du formulaire
    $newContent = [
        'title' => $_POST['title'],
        'content' => $_POST['content'],
        'cta' => $_POST['cta'],
    ];

    // Sauvegarder dans le fichier JSON
    file_put_contents($contentFile, json_encode($newContent, JSON_PRETTY_PRINT));

    // Indicateur de succès
    $showToast = true;
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Modifier le contenu</title>
    <link rel="stylesheet" href="http://localhost:8000/assets/css/style.css">
    <script>
        // Fonction pour afficher le toast et recharger la page après 3 secondes
        function showToast() {
            const toast = document.getElementById('toast');
            toast.classList.remove('hidden');
            setTimeout(() => {
                toast.classList.add('hidden');
                location.reload(); // Recharge la page pour afficher les données mises à jour
            }, 3000); // Le toast reste visible pendant 3 secondes
        }

        // Exécuter la fonction showToast si $showToast est vrai
        <?php if ($showToast): ?>
            window.onload = showToast;
        <?php endif; ?>
    </script>
</head>

<body class="bg-gray-100 text-gray-900">

    <a href="/<?php echo basename($contentFile, '.json'); ?>" target="_blank" class="bg-gray-800 text-white py-2 px-6 rounded-lg hover:bg-gray-900">
        Voir la page <?php echo ucfirst(basename($contentFile, '.json')); ?>
    </a>

    <div class="max-w-4xl mx-auto p-6 bg-white shadow-lg rounded-lg mt-10">
        <h1 class="text-3xl font-semibold text-center mb-6">Modifier le contenu de la page d'accueil</h1>

        <form method="POST" class="space-y-4">
            <div>
                <label for="title" class="block text-lg font-medium">Titre</label>
                <input type="text" name="title" id="title" value="<?php echo htmlspecialchars($contentData['title']); ?>" class="w-full p-3 border border-gray-300 rounded-lg" required>
            </div>

            <div>
                <label for="content" class="block text-lg font-medium">Contenu</label>
                <textarea name="content" id="content" rows="6" class="w-full p-3 border border-gray-300 rounded-lg" required><?php echo htmlspecialchars($contentData['content']); ?></textarea>
            </div>

            <div>
                <label for="cta" class="block text-lg font-medium">Call to Action (CTA)</label>
                <input type="text" name="cta" id="cta" value="<?php echo htmlspecialchars($contentData['cta']); ?>" class="w-full p-3 border border-gray-300 rounded-lg" required>
            </div>

            <div class="text-center">
                <button type="submit" class="bg-blue-500 text-white py-2 px-6 rounded-lg hover:bg-blue-600">Sauvegarder les modifications</button>
            </div>
        </form>
    </div>

</body>

</html>