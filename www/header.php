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
    <style>#main{padding-top:200px;padding-bottom:150px;min-height:868px;}body{margin:0;padding:0;min-height:100vh; background:radial-gradient(1px 1px at 25px 25px,white,transparent),radial-gradient(1px 1px at 75px 75px,white,transparent),radial-gradient(2px 2px at 125px 25px,white,transparent),radial-gradient(1px 1px at 175px 125px,white,transparent),radial-gradient(1px 1px at 225px 75px,white,transparent),radial-gradient(2px 2px at 275px 25px,white,transparent),radial-gradient(1px 1px at 325px 125px,white,transparent),radial-gradient(1px 1px at 375px 75px,white,transparent),radial-gradient(2px 2px at 50px 150px,white,transparent),radial-gradient(1px 1px at 150px 200px,white,transparent),radial-gradient(circle 120px at calc(100% - 60px) 60px,rgba(255,107,107,.9) 0%,rgba(238,90,90,.7) 25%,rgba(214,52,71,.5) 45%,rgba(165,94,234,.3) 65%,transparent 80%),radial-gradient(circle 80px at 80px calc(100% - 80px),rgba(78,205,196,.6) 0%,rgba(38,208,206,.4) 30%,rgba(29,209,161,.2) 60%,transparent 80%),radial-gradient(circle 40px at calc(100% - 150px) calc(100% - 40px),rgba(165,94,234,.7) 0%,rgba(136,84,208,.5) 30%,rgba(108,92,231,.3) 60%,transparent 80%),linear-gradient(135deg,#0c0a3e 0%,#161853 25%,#2d1b69 50%,#161853 75%,#0c0a3e 100%);background-size:400px 400px,400px 400px,400px 400px,400px 400px,400px 400px,400px 400px,400px 400px,400px 400px,400px 400px,400px 400px,cover,cover,cover,cover;background-repeat:repeat;background-attachment:fixed;font-family:Arial,sans-serif;color:#fff;}
      .background-with-image{background:linear-gradient(rgba(0,0,0,.3),rgba(0,0,0,.3)),url('https://cdn.pixabay.com/photo/2011/12/14/12/21/orion-nebula-11107_1280.jpg') center/cover no-repeat,linear-gradient(135deg,#0c0a3e 0%,#2d1b69 50%,#0c0a3e 100%);}.animated-planet-bg{position:relative;background:linear-gradient(135deg,#0c0a3e 0%,#161853 25%,#2d1b69 50%,#161853 75%,#0c0a3e 100%);overflow:hidden;}.animated-planet-bg::before{content:'';position:fixed;top:-100px;right:-100px;width:300px;height:300px;background:radial-gradient(circle,rgba(255,107,107,.8) 0%,rgba(238,90,90,.6) 20%,rgba(214,52,71,.4) 40%,rgba(165,94,234,.3) 60%,rgba(78,205,196,.2) 80%,transparent 100%);border-radius:50%;animation:planetGlow 4s ease-in-out infinite alternate;z-index:-1;}.animated-planet-bg::after{content:'';position:fixed;bottom:-150px;left:-150px;width:400px;height:400px;background:radial-gradient(circle,rgba(78,205,196,.6) 0%,rgba(38,208,206,.4) 30%,rgba(29,209,161,.3) 50%,transparent 70%);border-radius:50%;animation:planetGlow 6s ease-in-out infinite alternate reverse;z-index:-1;}@keyframes planetGlow{0%{opacity:.6;transform:scale(1);}100%{opacity:.9;transform:scale(1.1);}}.content{position:relative;z-index:10;background:rgba(31,41,55,.85);backdrop-filter:blur(10px);border-radius:12px;margin:20px;padding:30px;border:1px solid rgba(255,255,255,.1);box-shadow:0 10px 30px rgba(0,0,0,.3);}.exoplanet-background{margin:0;padding:0;min-height:100vh;background:radial-gradient(1px 1px at 25px 25px,white,transparent),radial-gradient(1px 1px at 75px 75px,white,transparent),radial-gradient(2px 2px at 125px 25px,white,transparent),radial-gradient(1px 1px at 175px 125px,white,transparent),radial-gradient(1px 1px at 225px 75px,white,transparent),radial-gradient(2px 2px at 275px 25px,white,transparent),radial-gradient(1px 1px at 325px 125px,white,transparent),radial-gradient(1px 1px at 375px 75px,white,transparent),radial-gradient(circle 120px at calc(100% - 60px) 60px,rgba(255,107,107,.9) 0%,rgba(238,90,90,.7) 25%,rgba(214,52,71,.5) 45%,rgba(165,94,234,.3) 65%,transparent 80%),radial-gradient(circle 80px at 80px calc(100% - 80px),rgba(78,205,196,.6) 0%,rgba(38,208,206,.4) 30%,rgba(29,209,161,.2) 60%,transparent 80%),linear-gradient(135deg,#0c0a3e 0%,#161853 25%,#2d1b69 50%,#161853 75%,#0c0a3e 100%);background-size:400px 400px,400px 400px,400px 400px,400px 400px,400px 400px,400px 400px,400px 400px,400px 400px,cover,cover,cover;background-repeat:repeat;font-family:Arial,sans-serif;color:#fff;}</style>

</head>
<body class="bg-black text-white font-sans antialiased">
<div id="header" class="fixed w-full z-50">
  <div class="bg-gray-900 text-gray-300 p-4 pb-0 text-center">
    <p class="text-2xl" style="font-size: x-large;">Exoplanety - Objevování vesmíru</p>
  </div>
  <nav class="navbar bg-gray-900 border-b border-gray-700 shadow-lg">
    <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
      <div class="flex items-center space-x-3">
        <img src="/images/exoplanet_ring.png" alt="ExoWorld Icon" class="w-8 h-8" style="height: 70px; width: 70px;  margin-left: -15px; margin-bottom: -30px; margin-top: -30px">
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