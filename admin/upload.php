<?php
// Inclure le fichier de configuration si nécessaire
include __DIR__ . '/../config.php';

// Chemin du dossier des uploads
$uploadDir = UPLOADS_PATH;

// Assure-toi que le dossier existe
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// Gestion du téléchargement de fichiers
if (isset($_FILES['file'])) {
    $file = $_FILES['file'];
    $fileName = basename($file['name']);
    $targetFile = $uploadDir . $fileName;

    // Vérifier si le fichier est valide
    if (move_uploaded_file($file['tmp_name'], $targetFile)) {
        $successMessage = "Fichier téléchargé avec succès.";
    } else {
        $errorMessage = "Erreur lors du téléchargement.";
    }
}

// Suppression de fichiers
if (isset($_GET['delete'])) {
    $fileToDelete = $uploadDir . basename($_GET['delete']);
    if (file_exists($fileToDelete)) {
        unlink($fileToDelete);
        $successMessage = "Fichier supprimé avec succès.";
    } else {
        $errorMessage = "Fichier introuvable.";
    }
}

// Récupérer la liste des fichiers dans le répertoire des uploads
$files = array_diff(scandir($uploadDir), ['.', '..']);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Médiathèque</title>
    <link rel="stylesheet" href="http://localhost:8000/assets/css/style.css">

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('imageModal');
            const modalImage = document.getElementById('modalImage');
            const modalImageUrl = document.getElementById('modalImageUrl');
            const modalDeleteLink = document.getElementById('modalDeleteLink');
            const closeModalButton = document.getElementById('closeModalButton');

            document.querySelectorAll('.image-thumbnail').forEach(function(thumbnail) {
                thumbnail.addEventListener('click', function() {
                    const imageSrc = this.getAttribute('data-src');
                    const imageName = this.getAttribute('data-name');
                    modalImage.src = imageSrc;
                    modalImageUrl.textContent = imageSrc;
                    modalImageUrl.href = imageSrc;
                    modalDeleteLink.href = `?delete=${encodeURIComponent(imageName)}`;
                    modal.classList.remove('hidden');
                });
            });

            closeModalButton.addEventListener('click', function() {
                modal.classList.add('hidden');
            });

            window.addEventListener('click', function(event) {
                if (event.target === modal) {
                    modal.classList.add('hidden');
                }
            });
        });
    </script>
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
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Médiathèque</h2>
                    
                    <!-- Notifications -->
                    <?php if (isset($successMessage)): ?>
                        <div class="bg-green-500 text-white p-4 mb-4 rounded-lg">
                            <?php echo $successMessage; ?>
                        </div>
                    <?php elseif (isset($errorMessage)): ?>
                        <div class="bg-red-500 text-white p-4 mb-4 rounded-lg">
                            <?php echo $errorMessage; ?>
                        </div>
                    <?php endif; ?>

                    <!-- Formulaire d'upload -->
                    <form method="POST" enctype="multipart/form-data" class="flex items-center space-x-4 mb-6">
                        <input type="file" name="file" class="border border-gray-300 rounded-lg p-2 flex-1">
                        <button type="submit" class="bg-blue-500 text-white py-2 px-6 rounded-lg hover:bg-blue-600">Télécharger</button>
                    </form>

                    <!-- Liste des fichiers -->
                    <div class="grid grid-cols-3 gap-4">
                        <?php foreach ($files as $file): ?>
                            <div class="relative group">
                                <?php
                                $filePath = $uploadDir . $file;
                                $fileExtension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
                                if ($fileExtension === 'jpg' || $fileExtension === 'jpeg' || $fileExtension === 'png'): ?>
                                    <img src="/assets/images/<?php echo $file; ?>" 
                                         alt="<?php echo $file; ?>" 
                                         class="w-full h-auto object-cover rounded-lg image-thumbnail cursor-pointer" 
                                         data-src="/assets/images/<?php echo $file; ?>" 
                                         data-name="<?php echo $file; ?>">
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Modal -->
    <div id="imageModal" class="fixed inset-0 hidden">
        <!-- Overlay avec opacité -->
        <div class="absolute inset-0 bg-black opacity-50"></div>
        <!-- Contenu de la modal -->
        <div class="relative z-10 flex items-center justify-center min-h-screen p-4">
            <div class="bg-white p-6 rounded-lg shadow-lg text-center w-full max-w-md">
                <img id="modalImage" src="" alt="Image" class="w-full h-auto object-cover rounded-lg mb-4">
                <a id="modalImageUrl" href="" target="_blank" class="text-blue-500 hover:underline block mb-4">URL de l'image</a>
                <a id="modalDeleteLink" href="" class="text-red-500 hover:underline block mb-4">Supprimer l'image</a>
                <button id="closeModalButton" class="bg-gray-500 text-white py-2 px-6 rounded-lg hover:bg-gray-600">Fermer</button>
            </div>
        </div>
    </div>
</body>

</html>