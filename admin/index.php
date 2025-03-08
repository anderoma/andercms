<?php include __DIR__ . '/../config.php'; ?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="http://localhost:8000/assets/css/style.css">
</head>


<body class="bg-gray-100 min-h-screen">
    <?php include BLOCKS_PATH . '/header.php';
    ?>
    <div class="flex flex-col h-screen">

        <!-- Main Content -->
        <div class="flex flex-1">
            <!-- Sidebar -->
            <?php include 'sidebar.php'; ?>

            <!-- Main Dashboard Area -->
            <main class="flex-1 p-6">
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Bienvenue sur le Dashboard</h2>
                    <p class="text-gray-600">
                        Utilisez le menu à gauche pour accéder à l'accueil ou à la médiathèque.
                    </p>
                </div>
                <div class="bg-white shadow-md rounded-lg p-6 mb-6 mt-4">
                    <h2 class="text-xl font-semibold mb-4">Outils SEO</h2>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="font-medium">Sitemap XML</h3>
                                <p class="text-sm text-gray-600">Générer le fichier sitemap.xml pour les moteurs de recherche</p>
                            </div>
                            <form action="/admin/generate_sitemap.php" method="POST">
                                <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-4 py-2 rounded-lg transition-colors">
                                    Générer le sitemap
                                </button>
                            </form>
                        </div>
                        <?php if (file_exists(__DIR__ . '/../sitemap.xml')): ?>
                            <div class="text-sm text-gray-600">
                                Dernier sitemap généré le : <?php echo date('d/m/Y H:i', filemtime(__DIR__ . '/../sitemap.xml')); ?>
                                <a href="/sitemap.xml" target="_blank" class="text-blue-500 hover:text-blue-700 ml-2">
                                    Voir le sitemap
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>

</html>