<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/WebsiteScreenshot.php';

try {
    $getScreenshot = new WebsiteScreenshot();
    $getScreenshot->saveScreenshot(null);

} catch (Exception $ex) {
    print "エラー!: " . $ex->getMessage() . "<br/>";
    die();
}