<?php

use League\Csv\Reader;
use League\Csv\Statement;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/WebsiteScreenshot.php';

try {
    $csvPath = __DIR__ . '/../data/mypage_list.csv';
    $csv = Reader::createFromPath($csvPath,'r');//読み取りモードでCSVを読み取る
    $csv->setHeaderOffset(0);//ヘッダーの設定

    $records = Statement::create()->process($csv);
    $screenData = [];//初期化
    foreach ($records as $record) {
        //mypage(4つめのカラム)が1のところのみに抽出
        if ($record['is_mypage'] === '1') {
            echo $record['clname'] . "\n";
            $screenData[$record['clname'] . 'exEvent'] = 'https://mypage.s-axol.jp/' . $record['nickname'];
            $screenData[$record['clname'] . 'Event'] = 'https://mypage.s-axol.jp/' . $record['nickname'] . '/events';
        } else {
            //処理しない
        }

    }
    var_dump($screenData);

    $getScreenshot = new WebsiteScreenshot();
    $getScreenshot->changeScreenshotSize(null, 4000);
    $getScreenshot->saveScreenshot('mypageScreenshot', $screenData);

} catch (Exception $ex) {
    print "エラー!: " . $ex->getMessage() . "\n";
    die();
}
