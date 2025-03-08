<?php
include BLOCKS_PATH . '/header.php';

// Générer dynamiquement les pages disponibles à partir des fichiers JSON du dossier content
$pages = [];
$contentDir = __DIR__ . '/../content';

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
      $pages[] = $pageName;
    }
  }
}
?>

<div class="container mx-auto px-4 max-w-4xl mt-12 mb-12">
  <div class="bg-white shadow-md rounded-lg p-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Plan du site</h1>

    <div class="mb-6">
      <p class="text-gray-600 mb-2">Nombre total de pages: <?php echo count($pages); ?></p>
    </div>

    <?php if (empty($pages)) : ?>
      <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
        <div class="flex">
          <div class="ml-3">
            <p class="text-yellow-700">Aucune page n'a été trouvée.</p>
          </div>
        </div>
      </div>
    <?php else : ?>
      <div class="overflow-hidden border border-gray-200 rounded-md">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Titre</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">URL</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <?php foreach ($pages as $page) : ?>
              <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm font-medium text-gray-900"><?php echo $page; ?></div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <a href="/<?php echo $page; ?>" class="text-sm text-blue-600 hover:text-blue-800 hover:underline"><?php echo $page; ?></a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <div class="mt-8">
        <a href="/" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
          Retour à l'accueil
        </a>
      </div>
    <?php endif; ?>
  </div>
</div>

<?php include BLOCKS_PATH . '/footer.php'; ?>