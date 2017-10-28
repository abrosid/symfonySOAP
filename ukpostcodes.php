#!/usr/bin/env php
<?php

require_once __DIR__ . '/vendor/autoload.php';

use Symfony\Component\Console\Application;

$app=new Application("UK postcodes", "0.0.1");

$app->run();