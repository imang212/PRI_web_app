<?php
include_once 'config.php';
include 'header.php';

$currentPage = getCurrentPage();
$pageData = getPageData($currentPage);

if (file_exists($pageData['file'])) {
    include $pageData['file'];
} else {
    include 'content/404.php';
}

include 'footer.php';
?>
