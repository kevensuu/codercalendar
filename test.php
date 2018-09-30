<?php
require_once __DIR__ . '/vendor/autoload.php';

use CoderCalendar\Lucky;

var_dump(Lucky::today(strtotime('-2 days')));