<?php
require_once __DIR__ . '/../vendor/autoload.php';

use HeadlessChromium\BrowserFactory;

try {
    //格納フォルダの用意
    $pathToImage = __DIR__ . '/../contentImages/';
    if (!is_dir($pathToImage)) {
        mkdir($pathToImage);
    }

    //対象URL設定
    $pages = [
        'google' => 'https://www.google.com',
        'yahoo' => 'https://www.yahoo.co.jp/',
        'apple' => 'https://apple.com/',
    ];

    //スクリーンショット用意
    $browser = (new BrowserFactory())->createBrowser();
    $page = $browser->createPage();
    $page->setViewport(1280, 3000);

    //スクリーンショット取得
    foreach ($pages as $name => $url) {
        $page->navigate($url)->waitForNavigation();
        $screenshot = $page->screenshot();
        $screenshot->saveToFile($pathToImage . $name . '.png');
    }

} catch (Exception $ex) {
    print "エラー!: " . $ex->getMessage() . "<br/>";
    die();
}