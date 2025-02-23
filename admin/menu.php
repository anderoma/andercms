<?php
include __DIR__ . '/../config.php';

// Vérification de l'authentification (à implémenter)
// session_start();
// if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
//     header("Location: login.php");
//     exit;
// }

// Récupération du menu actuel
$menuFile = CONTENT_PATH . '/header.json';
$menuItems = [];
if (file_exists($menuFile)) {
    $headerData = json_decode(file_get_contents($menuFile), true);
    $menuItems = $headerData['menu'] ?? []; // On accède à la clé 'menu' dans header.json
}

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add':
                $newItem = [
                    'id' => uniqid(),
                    'title' => $_POST['title'],
                    'url' => $_POST['url'],
                    'order' => count($menuItems) + 1
                ];
                $menuItems[] = $newItem;
                break;

            case 'update':
                foreach ($_POST['items'] as $item) {
                    $menuItems[$item['id']] = [
                        'id' => $item['id'],
                        'title' => $item['title'],
                        'url' => $item['url'],
                        'order' => $item['order']
                    ];
                }
                break;

            case 'delete':
                unset($menuItems[$_POST['item_id']]);
                break;
        }

        // Sauvegarde des modifications
        $headerData['menu'] = array_values($menuItems); // Mise à jour de la section menu
        file_put_contents($menuFile, json_encode($headerData, JSON_PRETTY_PRINT));
        header('Location: menu.php?success=1');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion du Menu - Administration</title>
    <link rel="stylesheet" href="http://localhost:8000/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-8">Gestion du Menu</h1>

        <?php if (isset($_GET['success'])): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                Modifications enregistrées avec succès !
            </div>
        <?php endif; ?>

        <!-- Liste des éléments du menu -->
        <div class="bg-white shadow-md rounded-lg p-6 mb-8">
            <h2 class="text-xl font-semibold mb-4">Éléments du menu</h2>
            <div id="menuItems" class="space-y-4">
                <?php foreach ($menuItems as $item): ?>
                    <div class="flex items-center space-x-4 p-3 border rounded" data-id="<?php echo $item['id']; ?>">
                        <i class="fas fa-grip-vertical cursor-move text-gray-400"></i>
                        <input type="text" value="<?php echo htmlspecialchars($item['title']); ?>"
                            class="w-full px-4 py-2 rounded-lg border border-gray-300" placeholder="Titre">
                        <input type="text" value="<?php echo htmlspecialchars($item['url']); ?>"
                            class="w-full px-4 py-2 rounded-lg border border-gray-300" placeholder="URL">
                        <button onclick="deleteMenuItem('<?php echo $item['id']; ?>')"
                            class="text-red-500 hover:text-red-700">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Formulaire d'ajout -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-xl font-semibold mb-4">Ajouter un élément</h2>
            <form method="POST" class="space-y-4">
                <input type="hidden" name="action" value="add">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-2">Titre</label>
                        <input type="text" name="title" required
                            class="w-full px-4 py-2 rounded-lg border border-gray-300">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">URL</label>
                        <input type="text" name="url" required
                            class="w-full px-4 py-2 rounded-lg border border-gray-300">
                    </div>
                </div>
                <button type="submit"
                    class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 rounded-lg transition-colors">
                    Ajouter
                </button>
            </form>
        </div>
    </div>

    <script>
        // Fonction pour supprimer un élément
        function deleteMenuItem(itemId) {
            if (confirm('Êtes-vous sûr de vouloir supprimer cet élément ?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.innerHTML = `
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="item_id" value="${itemId}">
                `;
                document.body.appendChild(form);
                form.submit();
            }
        }

        // Sauvegarde automatique lors des modifications
        function saveChanges() {
            const items = [];
            document.querySelectorAll('#menuItems > div').forEach((item, index) => {
                items.push({
                    id: item.dataset.id,
                    title: item.querySelector('input:nth-child(2)').value,
                    url: item.querySelector('input:nth-child(3)').value,
                    order: index + 1
                });
            });

            const form = document.createElement('form');
            form.method = 'POST';
            form.innerHTML = `
                <input type="hidden" name="action" value="update">
                <input type="hidden" name="items" value="${JSON.stringify(items)}">
            `;
            document.body.appendChild(form);
            form.submit();
        }
    </script>
</body>

</html>