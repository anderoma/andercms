<?php
include __DIR__ . '/../config.php';
include __DIR__ . '/function_admin.php';

// Récupérer le nom de la page depuis l'URL et nettoyer le paramètre
$pageName = isset($_GET['page']) ? basename($_GET['page']) : 'home';

$jsonFile = CONTENT_PATH . '/' . $pageName . '.json';

// Vérifier si le fichier existe
if (!file_exists($jsonFile)) {
    die('Page non trouvée');
}

// Charger les données JSON
$pageData = json_decode(file_get_contents($jsonFile), true);

// Traitement du formulaire
if (!empty($_POST)) {
    $pageData = updateData($pageData, $_POST);
    file_put_contents($jsonFile, json_encode($pageData, JSON_PRETTY_PRINT));
    $successMessage = "Page mise à jour avec succès.";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Éditer <?php echo ucfirst($pageName); ?></title>
    <link rel="stylesheet" href="http://localhost:8000/assets/css/style.css">
</head>
<body class="bg-gray-100 min-h-screen">
    <?php include BLOCKS_PATH . '/header.php'; ?>
    <div class="flex flex-col h-screen">
        <div class="flex flex-1">
            <?php include 'sidebar.php'; ?>

            <main class="flex-1 p-6">
                <div class="max-w-4xl mx-auto">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-3xl font-semibold">Éditer <?php echo ucfirst($pageName); ?></h1>
                        <a href="/<?php echo $pageName; ?>" target="_blank" 
                           class="bg-gray-800 text-white py-2 px-6 rounded-lg hover:bg-gray-900">
                            Voir la page
                        </a>
                    </div>

                    <?php if (isset($successMessage)): ?>
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6">
                            <?php echo $successMessage; ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" class="bg-white shadow-lg rounded-lg p-6">
                        <?php generateFormFields($pageData); ?>
                        
                        <div class="mt-6">
                            <button type="submit" class="bg-blue-500 text-white py-2 px-6 rounded-lg hover:bg-blue-600">
                                Sauvegarder les modifications
                            </button>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>

    <script>
    // Fonction pour ajouter un nouvel élément dans un tableau
    function addItem(key) {
        const container = document.getElementById(key + 'Container');
        const template = container.children[0].cloneNode(true);
        
        // Réinitialiser les valeurs
        template.querySelectorAll('input, textarea').forEach(input => {
            input.value = '';
        });
        
        container.appendChild(template);
    }
    </script>
</body>
</html> 