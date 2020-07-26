<?php

declare(strict_types = 1);

require_once __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/Src/Exception/exception.php';

$logger = new \App\Logger\Logger();
$logger->log(\App\Logger\LogLevel::DEBUG, "THERE IS A DEBUG LOG", ['exception' => 'exception occurred']);
$logger->info("User account created", ['id'=>'5']);