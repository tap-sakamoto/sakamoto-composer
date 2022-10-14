<?php

use League\Csv\Reader;
use League\Csv\Statement;
use League\Csv\Writer;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/WebsiteScreenshot.php';

try {
    //読み込みCSVのPath設定
    $csvPath = __DIR__ . '/../data/mypage_list.csv';
    $csv = Reader::createFromPath($csvPath);    //読み取りモードでCSVを読み取る
    $csv->setHeaderOffset(0);   //ヘッダーの設定

    //ループ回せるようにする
    $records = Statement::create()->process($csv);
    $screenEvent = [];// Eventページ
    $screenLogin = [];// ログインページ
    $notExistMypage = [];// Mypageを持たない学校リスト

    foreach ($records as $record) {
        //mypage(4つめのカラム)が1のところのみに抽出
        if ($record['is_mypage'] === '1') {
            $screenEvent[$record['clname'] . 'Event'] = 'https://mypage.s-axol.jp/' . $record['nickname'] . '/events';
            $screenLogin[$record['clname'] . 'Login'] = 'https://mypage.s-axol.jp/' . $record['nickname'];
        } else {
            $notExistMypage[] = $record;
        }
    }

    //CSVを出力する
    $writer = Writer::createFromPath(__DIR__ . '/../data/notExistMypageList.csv', 'w+');
    $writer->insertAll($notExistMypage);

    //スクリーンショットを取得する：Event
    $getScreenshot = new WebsiteScreenshot();
    $getScreenshot->changeScreenshotSize(null, 4000);
    $getScreenshot->saveScreenshot('EventMypage', $screenEvent);
    //スクリーンショットを取得する：Login
    $getScreenshot = new WebsiteScreenshot();
    $getScreenshot->saveScreenshot('LoginMypage', $screenLogin);

} catch (Exception $ex) {
    print "エラー!: " . $ex->getMessage() . "\n";
    die();
}

