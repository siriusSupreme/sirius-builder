<?php

use think\facade\App;

require __DIR__ . '/../vendor/topthink/framework/base.php';

App::run();

echo app('view')->fetch(__DIR__.'/test.html')->getContent();
