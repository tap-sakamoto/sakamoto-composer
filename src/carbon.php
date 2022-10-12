<?php

use Carbon\Carbon;

require_once __DIR__ . '/../vendor/autoload.php';

//printf("Right now is %s", Carbon::now()->toDateTimeString());
printf("Right now in Tokyo is %s", Carbon::now('Asia/Tokyo')); // automatically converted to string