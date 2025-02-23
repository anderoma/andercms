<?php
//include __DIR__ . '/../config.php';

include BLOCKS_PATH . '/header.php';
$homeContent = json_decode(file_get_contents(CONTENT_PATH . '/home.json'), true);
?>

<!-- Hero Section -->
<header class="relative h-screen w-full">
    <div class="absolute inset-0 bg-black/50">
        <img src="<?php echo $homeContent['hero_image']; ?>" alt="Hero background" class="w-full h-full object-cover -z-10">
    </div>
    <div class="container mx-auto px-4 h-full flex items-center justify-center text-center">
        <div class="max-w-4xl">
            <h1 class="text-5xl md:text-6xl font-bold text-white mb-6"><?php echo $homeContent['hero_title']; ?></h1>
            <p class="text-xl text-white mb-8"><?php echo $homeContent['hero_subtitle']; ?></p>
            <a href="#reservation" class="inline-block bg-orange-500 hover:bg-orange-600 text-white font-semibold px-8 py-4 rounded-full transition-colors"><?php echo $homeContent['hero_cta']; ?></a>
        </div>
    </div>
</header>

<!-- Section Menu -->
<section id="menu" class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <h2 class="text-4xl font-bold text-center mb-12"><?php echo $homeContent['menu_title']; ?></h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach($homeContent['menu_items'] as $item): ?>
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <img src="<?php echo $item['image']; ?>" alt="<?php echo $item['title']; ?>" class="w-full h-64 object-cover">
                <div class="p-6">
                    <h3 class="text-xl font-semibold mb-2"><?php echo $item['title']; ?></h3>
                    <p class="text-gray-600"><?php echo $item['description']; ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Section À propos -->
<section id="about" class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <div>
                <h2 class="text-4xl font-bold mb-6"><?php echo $homeContent['about_title']; ?></h2>
                <p class="text-gray-600 text-lg"><?php echo $homeContent['about_content']; ?></p>
            </div>
            <div class="rounded-lg overflow-hidden shadow-lg">
                <img src="<?php echo $homeContent['about_image']; ?>" alt="Notre restaurant" class="w-full h-full object-cover">
            </div>
        </div>
    </div>
</section>

<!-- Section Contact et Réservation -->
<section id="contact" class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
            <div class="bg-gray-50 p-8 rounded-lg">
                <h2 class="text-3xl font-bold mb-6"><?php echo $homeContent['contact_title']; ?></h2>
                <div class="space-y-4 text-gray-600">
                    <p><?php echo $homeContent['address']; ?></p>
                    <p><?php echo $homeContent['phone']; ?></p>
                    <p><?php echo $homeContent['email']; ?></p>
                </div>
            </div>
            <div class="bg-gray-50 p-8 rounded-lg">
                <h2 class="text-3xl font-bold mb-6"><?php echo $homeContent['reservation_title']; ?></h2>
                <form id="reservation" action="<?php echo $homeContent['reservation_action']; ?>" method="POST" class="space-y-4">
                    <div>
                        <input type="text" placeholder="<?php echo $homeContent['form_name']; ?>" required 
                            class="w-full px-4 py-2 rounded-lg border border-gray-300">
                    </div>
                    <div>
                        <input type="email" placeholder="<?php echo $homeContent['form_email']; ?>" required 
                            class="w-full px-4 py-2 rounded-lg border border-gray-300">
                    </div>
                    <div>
                        <input type="tel" placeholder="<?php echo $homeContent['form_phone']; ?>" required 
                            class="w-full px-4 py-2 rounded-lg border border-gray-300">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <input type="date" required 
                            class="w-full px-4 py-2 rounded-lg border border-gray-300">
                        <input type="time" required 
                            class="w-full px-4 py-2 rounded-lg border border-gray-300">
                    </div>
                    <div>
                        <input type="number" placeholder="<?php echo $homeContent['form_guests']; ?>" min="1" max="10" required 
                            class="w-full px-4 py-2 rounded-lg border border-gray-300">
                    </div>
                    <button type="submit" 
                        class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 rounded-lg transition-colors">
                        <?php echo $homeContent['form_submit']; ?>
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<?php include BLOCKS_PATH . '/footer.php'; ?>