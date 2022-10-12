<?php
require_once __DIR__ . '/../vendor/autoload.php';

use HeadlessChromium\BrowserFactory;

$pathToImage = __DIR__ . '/../contentImages/';

if (!is_dir($pathToImage)) {
    mkdir($pathToImage);
}

$browser = (new BrowserFactory())->createBrowser();
$urlToCapture = 'https://www.google.com';
$saveCaptureName = 'google.png';

try {

    $page = $browser->createPage();
    $page->setViewport(1280, 720);
    $page->navigate($urlToCapture)->waitForNavigation();

    $screenshot = $page->screenshot();
    $screenshot->saveToFile($pathToImage . $saveCaptureName);

} catch (Exception $ex) {
    // Something went wrong
}

