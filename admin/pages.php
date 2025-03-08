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
                <div class="max-w-7xl mx-auto">
                    <!-- En-tête avec titre et bouton -->
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-3xl font-semibold">Éditer <?php echo ucfirst($pageName); ?></h1>
                        <div class="flex gap-4">
                            <button type="button" onclick="saveAllChanges()"
                                class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-6 py-2 rounded-lg transition-colors">
                                Sauvegarder
                            </button>
                            <a href="/<?php echo $pageName; ?>" target="_blank"
                                class="bg-gray-800 text-white py-2 px-6 rounded-lg hover:bg-gray-900">
                                Voir la page
                            </a>
                        </div>
                    </div>

                    <?php if (isset($successMessage)): ?>
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6">
                            <?php echo $successMessage; ?>
                        </div>
                    <?php endif; ?>

                    <!-- Interface d'édition visuelle -->
                    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                        <!-- Hero Section -->
                        <div class="relative h-[400px] group">
                            <img src="<?php echo $pageData['hero_image']; ?>"
                                class="w-full h-full object-cover"
                                alt="Hero background">
                            <div class="absolute inset-0 bg-black/50 flex items-center justify-center">
                                <div class="text-center text-white space-y-4 p-8">
                                    <div class="editable-field" data-field="hero_title">
                                        <h1 class="text-5xl font-bold mb-4"><?php echo $pageData['hero_title']; ?></h1>
                                        <button class="edit-btn hidden group-hover:block">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </div>
                                    <div class="editable-field" data-field="hero_subtitle">
                                        <p class="text-xl"><?php echo $pageData['hero_subtitle']; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Menu Section -->
                        <div class="p-8">
                            <h2 class="text-3xl font-bold mb-6">Notre Menu</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                                <?php foreach ($pageData['menu_items'] as $index => $item): ?>
                                    <div class="menu-item group relative">
                                        <img src="<?php echo $item['image']; ?>"
                                            class="w-full h-64 object-cover rounded-lg"
                                            alt="<?php echo $item['title']; ?>">
                                        <div class="p-4">
                                            <div class="editable-field" data-field="menu_items[<?php echo $index; ?>][title]">
                                                <h3 class="text-xl font-semibold"><?php echo $item['title']; ?></h3>
                                            </div>
                                            <div class="editable-field" data-field="menu_items[<?php echo $index; ?>][description]">
                                                <p class="text-gray-600"><?php echo $item['description']; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <!-- Autres sections... -->
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Modal d'édition -->
    <div id="editModal" class="fixed inset-0 hidden">
        <!-- Overlay avec opacité -->
        <div class="absolute inset-0 bg-black opacity-50"></div>
        <!-- Contenu de la modal -->
        <div class="relative z-10 flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg p-6 max-w-lg w-full">
                <h3 class="text-lg font-semibold mb-4">Modifier le contenu</h3>
                <textarea id="editContent" class="w-full px-4 py-2 rounded-lg border border-gray-300 h-32"></textarea>
                <div class="flex justify-end gap-4 mt-4">
                    <button onclick="closeEditModal()"
                        class="px-4 py-2 text-gray-600 hover:text-gray-800">
                        Annuler
                    </button>
                    <button onclick="saveEdit()"
                        class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-4 py-2 rounded-lg">
                        Sauvegarder
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentEditField = null;

        document.querySelectorAll('.editable-field').forEach(field => {
            field.addEventListener('click', () => {
                currentEditField = field;
                const content = field.querySelector('h1, h2, h3, p').textContent;
                document.getElementById('editContent').value = content;
                document.getElementById('editModal').classList.remove('hidden');
            });
        });

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }

        function saveEdit() {
            const newContent = document.getElementById('editContent').value;
            currentEditField.querySelector('h1, h2, h3, p').textContent = newContent;
            closeEditModal();
            // Ici, ajoutez la logique pour sauvegarder les modifications
        }

        function saveAllChanges() {
            // Logique pour sauvegarder toutes les modifications
        }
    </script>
</body>

</html>