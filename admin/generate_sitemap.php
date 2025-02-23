<?php
include __DIR__ . '/../config.php';

function generateSitemap() {
    $pages = glob(CONTENT_PATH . '/*.json');
    
    $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"/>');
    
    foreach ($pages as $page) {
        $filename = basename($page, '.json');
        if ($filename === 'header' || $filename === 'footer') continue;
        
        $pageData = json_decode(file_get_contents($page), true);
        
        $url = $xml->addChild('url');
        $url->addChild('loc', 'https://' . $_SERVER['HTTP_HOST'] . '/' . $filename);
        $url->addChild('lastmod', date('Y-m-d'));
        $url->addChild('changefreq', 'weekly');
        $url->addChild('priority', $filename === 'home' ? '1.0' : '0.8');
    }
    
    $sitemapPath = __DIR__ . '/../public/sitemap.xml';
    if ($xml->asXML($sitemapPath)) {
        return true;
    }
    return false;
}

// Si appelé via POST, générer et rediriger
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (generateSitemap()) {
        header('Location: index.php?success=sitemap');
    } else {
        header('Location: index.php?error=sitemap');
    }
    exit;
} 