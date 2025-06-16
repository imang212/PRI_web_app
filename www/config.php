<?php
$pages = [
    'home' => ['title' => 'ExoWorlds - Domů', 'file' => 'content/home.php', 'nav_title' => 'Domů'],
    'exoplanets' => ['title' => 'Exoplanety - Katalog', 'file' => 'content/exoplanets.php', 'nav_title' => 'Exoplanety'],
    'missions' => ['title' => 'Vesmírné mise', 'file' => 'content/missions.php', 'nav_title' => 'Mise'],
    'contact' => ['title' => 'Kontakt', 'file' => 'content/contact.php', 'nav_title' => 'Kontakt']
];
function getCurrentPage() {
    return $_GET['page'] ?? 'home';
}
function getPageData($page) {
    global $pages;
    return $pages[$page] ?? $pages['home'];
}
function isActivePage($page) {
    return getCurrentPage() === $page;
}
?>
