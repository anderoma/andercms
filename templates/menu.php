<?php
//include __DIR__ . '/../config.php';

// Charger les données du menu
$menuFile = CONTENT_PATH . '/menu.json';
$menuData = json_decode(file_get_contents($menuFile), true);
?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-900 mb-4"><?php echo htmlspecialchars($menuData['title']); ?></h1>
        <p class="text-lg text-gray-600"><?php echo htmlspecialchars($menuData['description']); ?></p>
    </div>

    <div class="space-y-12">
        <?php foreach ($menuData['categories'] as $category): ?>
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                    <h2 class="text-2xl font-semibold text-gray-900"><?php echo htmlspecialchars($category['name']); ?></h2>
                </div>
                <div class="border-t border-gray-200">
                    <div class="divide-y divide-gray-200">
                        <?php foreach ($category['items'] as $item): ?>
                            <div class="px-4 py-5 sm:px-6">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <h3 class="text-lg font-medium text-gray-900">
                                            <?php echo htmlspecialchars($item['name']); ?>
                                        </h3>
                                        <p class="mt-1 text-sm text-gray-500">
                                            <?php echo htmlspecialchars($item['description']); ?>
                                        </p>
                                    </div>
                                    <div class="ml-4">
                                        <span class="text-lg font-medium text-gray-900">
                                            <?php echo number_format((float)$item['price'], 2, ',', ' '); ?> €
                                        </span>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>