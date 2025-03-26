<!-- sidebar.php -->
<aside class="w-64 h-full bg-white shadow-md">
    <nav class="h-full flex flex-col p-4 space-y-2">
        <a href="/admin" class="flex items-center p-2 text-base text-gray-900 rounded-lg hover:bg-gray-100 group">
            <svg class="w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
            </svg>
            <span class="ml-3">Dashboard</span>
        </a>

        <a href="/admin/upload.php" class="flex items-center p-2 text-base text-gray-900 rounded-lg hover:bg-gray-100 group">
            <svg class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"></path>
            </svg>
            <span class="ml-3">Médiathèque</span>
        </a>

        <a href="/admin/header.php" class="flex items-center p-2 text-base text-gray-900 rounded-lg hover:bg-gray-100 group">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" viewBox="0 0 16 16">
                <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2z" />
                <path d="M3 8.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5m0-5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5z" />
            </svg>
            <span class="ml-3">Menu</span>
        </a>

        <!-- Menu déroulant des pages -->
        <div class="relative">
            <button type="button" id="pagesDropdownButton" class="flex items-center p-2 w-full text-base text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100">
                <svg class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path>
                </svg>
                <span class="flex-1 ml-3 text-left whitespace-nowrap">Pages</span>
                <svg class="w-6 h-6 transition-transform duration-200" id="pagesDropdownIcon" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </button>
            <div id="pagesDropdownMenu" class="hidden py-2 space-y-2 transition-all duration-200">
                <?php
                // Lister les fichiers JSON du dossier content
                $sidebarJsonFiles = glob(CONTENT_PATH . '/*.json');
                $sidebarExcludeFiles = ['header.json', 'footer.json'];

                foreach ($sidebarJsonFiles as $sidebarFile) {
                    $sidebarFilename = basename($sidebarFile);
                    if (!in_array($sidebarFilename, $sidebarExcludeFiles)) {
                        $sidebarPageName = pathinfo($sidebarFilename, PATHINFO_FILENAME);
                        $sidebarPageData = json_decode(file_get_contents($sidebarFile), true);
                        $sidebarPageTitle = ucfirst($sidebarPageName);
                ?>
                        <a href="/admin/pages.php?page=<?php echo $sidebarPageName; ?>"
                            class="flex items-center p-2 pl-11 w-full text-base text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100">
                            <?php echo htmlspecialchars($sidebarPageTitle); ?>
                        </a>
                <?php
                    }
                }
                ?>
            </div>
        </div>
    </nav>
</aside>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const button = document.getElementById('pagesDropdownButton');
        const menu = document.getElementById('pagesDropdownMenu');
        const icon = document.getElementById('pagesDropdownIcon');

        button.addEventListener('click', function() {
            menu.classList.toggle('hidden');
            icon.classList.toggle('rotate-180');
        });

        // Fermer le menu si on clique en dehors
        document.addEventListener('click', function(event) {
            if (!button.contains(event.target) && !menu.contains(event.target)) {
                menu.classList.add('hidden');
                icon.classList.remove('rotate-180');
            }
        });
    });
</script>