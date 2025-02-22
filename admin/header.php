<?php
include __DIR__ . '/../config.php';

// Récupérer les contenus
$headerFile = CONTENT_PATH . '/header.json';
$headerData = json_decode(file_get_contents($headerFile), true);

if (!empty($_POST)) {
    // Traitement des données du formulaire
    $newHeader = [
        'site_title' => $_POST['site_title'],
        'logo_url' => $_POST['logo_url'],
        'menu_items' => []
    ];

    // Traiter les éléments du menu
    for ($i = 0; $i < count($_POST['menu_title']); $i++) {
        if (!empty($_POST['menu_title'][$i]) && !empty($_POST['menu_url'][$i])) {
            $newHeader['menu_items'][] = [
                'title' => $_POST['menu_title'][$i],
                'url' => $_POST['menu_url'][$i]
            ];
        }
    }

    // Sauvegarder dans le fichier JSON
    file_put_contents($headerFile, json_encode($newHeader, JSON_PRETTY_PRINT));
    $headerData = $newHeader;
    $successMessage = "Header mis à jour avec succès.";
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Éditer le Header</title>
    <link rel="stylesheet" href="http://localhost:8000/assets/css/style.css">
</head>

<body class="bg-gray-100 min-h-screen">
    <?php include BLOCKS_PATH . '/header.php'; ?>
    <div class="flex flex-col h-screen">

        <!-- Main Content -->
        <div class="flex flex-1">
            <!-- Sidebar -->
            <?php include 'sidebar.php'; ?>

            <!-- Main Dashboard Area -->
            <main class="flex-1 p-6">
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="sm:flex sm:items-center">
                        <div class="sm:flex-auto">
                            <h1 class="text-2xl font-semibold text-gray-900">Configuration du Header</h1>
                            <p class="mt-2 text-sm text-gray-700">Gérez le contenu de l'en-tête de votre site</p>
                        </div>
                    </div>

                    <?php if (isset($successMessage)): ?>
                        <div class="mt-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                            <?php echo $successMessage; ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" class="mt-6 space-y-6">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h2 class="text-lg font-medium text-gray-900 mb-4">Informations générales</h2>
                            <div class="grid gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Titre du site</label>
                                    <input type="text" name="site_title" 
                                           value="<?php echo htmlspecialchars($headerData['site_title']); ?>" 
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">URL du logo</label>
                                    <input type="text" name="logo_url" 
                                           value="<?php echo htmlspecialchars($headerData['logo_url']); ?>" 
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="flex justify-between items-center mb-4">
                                <h2 class="text-lg font-medium text-gray-900">Éléments du menu</h2>
                                <button type="button" onclick="addMenuItem()" 
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                    Ajouter un item
                                </button>
                            </div>
                            <div id="menuItems" class="space-y-4">
                                <?php foreach ($headerData['menu_items'] as $index => $item): ?>
                                    <div class="flex gap-4 items-center bg-white p-4 rounded-md shadow-sm">
                                        <div class="flex-1">
                                            <input type="text" name="menu_title[]" placeholder="Titre" 
                                                   value="<?php echo htmlspecialchars($item['title']); ?>"
                                                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        </div>
                                        <div class="flex-1">
                                            <input type="text" name="menu_url[]" placeholder="URL" 
                                                   value="<?php echo htmlspecialchars($item['url']); ?>"
                                                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        </div>
                                        <button type="button" onclick="this.parentElement.remove()" 
                                                class="text-red-600 hover:text-red-800">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" 
                                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Sauvegarder les modifications
                            </button>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>

    <script>
        function addMenuItem() {
            const container = document.getElementById('menuItems');
            const newItem = document.createElement('div');
            newItem.className = 'flex gap-4 items-center bg-white p-4 rounded-md shadow-sm';
            newItem.innerHTML = `
                <div class="flex-1">
                    <input type="text" name="menu_title[]" placeholder="Titre" 
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                <div class="flex-1">
                    <input type="text" name="menu_url[]" placeholder="URL" 
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                <button type="button" onclick="this.parentElement.remove()" 
                        class="text-red-600 hover:text-red-800">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </button>
            `;
            container.appendChild(newItem);
        }
    </script>
</body>

</html> 