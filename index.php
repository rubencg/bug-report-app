<?php

declare(strict_types = 1);

require_once __DIR__.'/vendor/autoload.php';

set_exception_handler([new \App\Exception\ExceptionHandler(), 'HANDLE']);
