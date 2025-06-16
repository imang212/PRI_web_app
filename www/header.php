<?php
include_once 'config.php';
$currentPage = getCurrentPage();
$pageData = getPageData($currentPage);
$pageTitle = $pageData['title'];
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link href="output.css" rel="stylesheet">
    <style> #main {padding-top: 150px; padding-bottom: 100px; min-height: 800px;} </style>
</head>
<body class="bg-black text-white font-sans antialiased">
<div id="header" class="fixed w-full z-50">
  <div class="bg-gray-900 text-gray-300 p-4 pb-0 text-center">
    <p class="text-xl">Exoplanety - Objevování vesmíru</p>
  </div>
  <nav class="navbar bg-gray-900 border-b border-gray-700 shadow-lg">
    <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
      <div class="flex items-center space-x-3">
        <span class="text-xl font-bold tracking-wide">ExoWorlds</span>
      </div>
      <div class="space-x-6 hidden md:flex">
        <?php foreach ($pages as $pageKey => $pageInfo): ?>
          <a href="?page=<?php echo $pageKey; ?>"
             class="<?php echo isActivePage($pageKey) ? 'text-cyan-400' : 'hover:text-cyan-400'; ?> transition">
              <?php echo $pageInfo['nav_title']; ?>
          </a>
        <?php endforeach; ?>
      </div>
    </div>
  </nav>
</div>