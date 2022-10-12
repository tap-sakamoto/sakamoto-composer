<?php
require_once __DIR__ . '/../vendor/autoload.php';

use HeadlessChromium\BrowserFactory;
use HeadlessChromium\Exception\CommunicationException;
use HeadlessChromium\Exception\CommunicationException\CannotReadResponse;
use HeadlessChromium\Exception\CommunicationException\InvalidResponse;
use HeadlessChromium\Exception\CommunicationException\ResponseHasError;
use HeadlessChromium\Exception\FilesystemException;
use HeadlessChromium\Exception\NavigationExpired;
use HeadlessChromium\Exception\NoResponseAvailable;
use HeadlessChromium\Exception\OperationTimedOut;
use HeadlessChromium\Exception\ScreenshotFailed;
use HeadlessChromium\Page;

class WebsiteScreenshot
{
    private Page $page;

    /**
     * @throws OperationTimedOut
     * @throws CommunicationException
     * @throws NoResponseAvailable
     */
    public function __construct()
    {
        $this->prepareScreenshot();
    }

    /**
     * @throws OperationTimedOut
     * @throws CommunicationException
     * @throws NoResponseAvailable
     */
    private function prepareScreenshot(): void
    {
        //スクリーンショット用意
        $browser = (new BrowserFactory())->createBrowser();//Chromeの場所を探しにいく
        $this->page = $browser->createPage();//ChromeのAPI設定的な
        $this->changeScreenshotSize();//空のページを開けてサイズを調整しているイメージ
    }

    /**
     * @throws CommunicationException
     * @throws NoResponseAvailable
     */
    public function changeScreenshotSize(?int $width =null, ?int $height=null): void
    {
        $setWidth = $width ?? 1280;
        $setHeight = $height ?? 1280;
        $this->page->setViewport($setWidth, $setHeight);//空のページを開けてサイズを調整しているイメージ
    }

    /**
     * @throws OperationTimedOut
     * @throws CommunicationException
     * @throws NoResponseAvailable
     * @throws FilesystemException
     * @throws NavigationExpired
     * @throws InvalidResponse
     * @throws CannotReadResponse
     * @throws ScreenshotFailed
     * @throws ResponseHasError
     */
    public function saveScreenshot(?string $userDirName=null): void
    {
        $putDirName = $userDirName ?? 'contentImages';
        //対象URL設定
        $pages = [
            'google' => 'https://www.google.com',
            'yahoo' => 'https://www.yahoo.co.jp/',
            'apple' => 'https://apple.com/',
            'facebook' => 'https://www.facebook.com/',
        ];

        //スクリーンショット取得
        foreach ($pages as $name => $url) {
            $this->page->navigate($url)->waitForNavigation();//URL入れて結果が返ってくるまで待ってる
            $screenshot = $this->page->screenshot();//API使ってスクリーンショット撮る
            $screenshot->saveToFile($this->preparePutDir($putDirName) . $name . '.png');
        }
    }


    private function preparePutDir(string $putDirName): string
    {
        //格納フォルダの用意
        $pathToImage = __DIR__ . '/../' . $putDirName . '/';

        //格納フォルダがなければ作成
        if (!is_dir($pathToImage)) {
            mkdir($pathToImage);
        }

        return ($pathToImage);
    }

}