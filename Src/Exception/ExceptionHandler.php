<?php

declare(strict_types = 1);
namespace App\Exception;

use App\Helpers\App;
use ErrorException;
use Throwable;

class ExceptionHandler
{
    /**
     * @param Throwable $exception
     */
    public function handle(Throwable $exception): void
    {
        $application = new App();

        if ($application->isDebugMode()) {
            var_dump($exception);
        } else {
            echo "This should not have happened, please try again.";
        }
        exit();
    }

    /**
     * @param $severity
     * @param $message
     * @param $file
     * @param $line
     * @throws ErrorException
     */
    public function convertWarningsAndNoticesToExceptions($severity, $message, $file, $line)
    {
        throw new ErrorException($message, $severity, $severity, $file, $line);
    }
}