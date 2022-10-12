<?php
require_once __DIR__ . '/../vendor/autoload.php';

//echo \Omoon\KansaiDialect\KansaiDialect::translate('いいね');


$holidayRepository = new \Japanese\Holiday\Repository();
var_dump($holidayRepository->isHoliday('2022-10-11'));
//print_r($holidayRepository->getHolidayDate(2022, 'スポーツの日'));
