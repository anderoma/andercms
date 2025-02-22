<?php
//include __DIR__ . '/../config.php';
include BLOCKS_PATH . '/header.php';

// Charger les données de contact
$contactFile = CONTENT_PATH . '/contact.json';
$contactData = json_decode(file_get_contents($contactFile), true);
?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-900 mb-4"><?php echo htmlspecialchars($contactData['title']); ?></h1>
        <p class="text-lg text-gray-600"><?php echo htmlspecialchars($contactData['description']); ?></p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Informations de contact -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h2 class="text-2xl font-semibold text-gray-900">Nos coordonnées</h2>
            </div>
            <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
                <div class="space-y-4">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Adresse</h3>
                        <p class="mt-1 text-gray-600">
                            <?php echo htmlspecialchars($contactData['address']['street']); ?><br>
                            <?php echo htmlspecialchars($contactData['address']['city']); ?><br>
                            <?php echo htmlspecialchars($contactData['address']['country']); ?>
                        </p>
                    </div>
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Contact</h3>
                        <p class="mt-1 text-gray-600">
                            Tél: <a href="tel:<?php echo htmlspecialchars($contactData['contact']['phone']); ?>" class="text-blue-600 hover:underline">
                                <?php echo htmlspecialchars($contactData['contact']['phone']); ?>
                            </a><br>
                            Email: <a href="mailto:<?php echo htmlspecialchars($contactData['contact']['email']); ?>" class="text-blue-600 hover:underline">
                                <?php echo htmlspecialchars($contactData['contact']['email']); ?>
                            </a>
                        </p>
                    </div>
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Horaires d'ouverture</h3>
                        <p class="mt-1 text-gray-600">
                            Du mardi au vendredi: <?php echo htmlspecialchars($contactData['hours']['weekdays']); ?><br>
                            Week-end: <?php echo htmlspecialchars($contactData['hours']['weekends']); ?><br>
                            Fermé le <?php echo htmlspecialchars($contactData['hours']['closed']); ?>
                        </p>
                    </div>
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Réseaux sociaux</h3>
                        <div class="mt-1 flex space-x-4">
                            <a href="<?php echo htmlspecialchars($contactData['social']['facebook']); ?>" target="_blank" class="text-blue-600 hover:text-blue-800">
                                <span class="sr-only">Facebook</span>
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2C6.477 2 2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.879V14.89h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.989C18.343 21.129 22 16.99 22 12c0-5.523-4.477-10-10-10z" />
                                </svg>
                            </a>
                            <a href="<?php echo htmlspecialchars($contactData['social']['instagram']); ?>" target="_blank" class="text-pink-600 hover:text-pink-800">
                                <span class="sr-only">Instagram</span>
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2c2.717 0 3.056.01 4.122.06 1.065.05 1.79.217 2.428.465.66.254 1.216.598 1.772 1.153.509.5.902 1.105 1.153 1.772.247.637.415 1.363.465 2.428.047 1.066.06 1.405.06 4.122 0 2.717-.01 3.056-.06 4.122-.05 1.065-.218 1.79-.465 2.428a4.883 4.883 0 01-1.153 1.772c-.5.508-1.105.902-1.772 1.153-.637.247-1.363.415-2.428.465-1.066.047-1.405.06-4.122.06-2.717 0-3.056-.01-4.122-.06-1.065-.05-1.79-.218-2.428-.465a4.89 4.89 0 01-1.772-1.153 4.904 4.904 0 01-1.153-1.772c-.247-.637-.415-1.363-.465-2.428C2.013 15.056 2 14.717 2 12c0-2.717.01-3.056.06-4.122.05-1.066.217-1.79.465-2.428a4.88 4.88 0 011.153-1.772A4.897 4.897 0 015.45 2.525c.638-.247 1.362-.415 2.428-.465C8.944 2.013 9.283 2 12 2zm0 5a5 5 0 100 10 5 5 0 000-10zm6.5-.25a1.25 1.25 0 10-2.5 0 1.25 1.25 0 002.5 0zM12 9a3 3 0 110 6 3 3 0 010-6z" />
                                </svg>
                            </a>
                            <a href="<?php echo htmlspecialchars($contactData['social']['twitter']); ?>" target="_blank" class="text-blue-400 hover:text-blue-600">
                                <span class="sr-only">Twitter</span>
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Formulaire de contact -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h2 class="text-2xl font-semibold text-gray-900">Envoyez-nous un message</h2>
            </div>
            <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
                <form action="#" class="space-y-8">
                    <div>
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Your email</label>
                        <input type="email" id="email" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 dark:shadow-sm-light" placeholder="name@flowbite.com" required>
                    </div>
                    <div>
                        <label for="subject" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Subject</label>
                        <input type="text" id="subject" class="block p-3 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 shadow-sm focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 dark:shadow-sm-light" placeholder="Let us know how we can help you" required>
                    </div>
                    <div class="sm:col-span-2">
                        <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Your message</label>
                        <textarea id="message" rows="6" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg shadow-sm border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Leave a comment..."></textarea>
                    </div>
                    <button type="submit" class="py-3 px-5 text-sm font-medium text-center text-white rounded-lg bg-blue-700 sm:w-fit hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Send message</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include BLOCKS_PATH . '/footer.php'; ?>