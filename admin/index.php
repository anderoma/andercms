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
            </main>
        </div>
    </div>
</body>

</html>