<?php
// Charger les données du header
$headerFile = CONTENT_PATH . '/header.json';
$headerData = json_decode(file_get_contents($headerFile), true);

// Déterminer la page courante
$currentPage = $_GET['page'] ?? 'home';

// Charger les données SEO de la page courante
$pageFile = CONTENT_PATH . '/' . $currentPage . '.json';
$pageData = file_exists($pageFile) ? json_decode(file_get_contents($pageFile), true) : null;

// Définir les valeurs SEO par défaut
$seoTitle = $pageData['seo']['title'] ?? $headerData['site_title'];
$seoDescription = $pageData['seo']['description'] ?? "Site officiel du restaurant " . $headerData['site_title'];
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($seoTitle); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($seoDescription); ?>">
    
    <!-- Autres méta tags SEO -->
    <meta property="og:title" content="<?php echo htmlspecialchars($seoTitle); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($seoDescription); ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo htmlspecialchars("https://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}"); ?>">
    
    <!-- Autres balises head -->
    <link rel="stylesheet" href="http://localhost:8000/assets/css/style.css">
</head>

<body class="font-sans bg-gray-100">
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <!-- Logo -->
                    <div class="flex-shrink-0 flex items-center">
                        <a href="/" class="text-xl font-bold text-gray-800">
                            <?php echo htmlspecialchars($headerData['site_title']); ?>
                        </a>
                    </div>

                    <!-- Navigation principale -->
                    <nav class="hidden sm:ml-6 sm:flex sm:space-x-8">
                        <?php foreach ($headerData['menu_items'] as $item): ?>
                            <a href="<?php echo htmlspecialchars($item['url']); ?>" 
                               class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-500 hover:text-gray-900">
                                <?php echo htmlspecialchars($item['title']); ?>
                            </a>
                        <?php endforeach; ?>
                    </nav>
                </div>

                <!-- Menu mobile -->
                <div class="sm:hidden">
                    <button type="button" class="mobile-menu-button inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Menu mobile (caché par défaut) -->
        <div class="sm:hidden hidden mobile-menu">
            <div class="pt-2 pb-3 space-y-1">
                <?php foreach ($headerData['menu_items'] as $item): ?>
                    <a href="<?php echo htmlspecialchars($item['url']); ?>" 
                       class="block pl-3 pr-4 py-2 text-base font-medium text-gray-500 hover:text-gray-900 hover:bg-gray-50">
                        <?php echo htmlspecialchars($item['title']); ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </header>
    <main>

<script>
    // Toggle menu mobile
    document.querySelector('.mobile-menu-button').addEventListener('click', function() {
        document.querySelector('.mobile-menu').classList.toggle('hidden');
    });
</script>