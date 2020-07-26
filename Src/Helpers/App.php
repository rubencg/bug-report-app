<?php
declare(strict_types=1);

namespace App\Helpers;

use DateTimeInterface, Exception, DateTime, DateTimeZone;

class App
{
    private $config = [];

    public function __construct()
    {
        $this->config = Config::get('app');
    }

    /**
     * Returns if debug mode is enabled
     * @return bool
     */
    public function isDebugMode(): bool
    {
        $debug = $this->config['debug'];
        return isset($debug) ? $debug : false;
    }

    /**
     * Returns environment
     * @return string
     */
    public function getEnvironment(): string
    {
        $env = $this->config['env'];
        return $this->isTestMode() ? 'test' : (isset($env) ? $env : 'production');
    }

    /**
     * Returns Log path
     * @return string
     * @throws Exception if log path is not defined
     */
    public function getLogPath(): string
    {
        $log_path = $this->config['log_path'];
        if(!isset($log_path)){
            throw new Exception('Log path is not defined');
        }
        return $log_path;
    }

    /**
     * Returns if php is running from console or browser
     * @return bool
     */
    public function isRunningFromConsole(): bool
    {
        return php_sapi_name() == 'cli' || php_sapi_name() == 'phpbg';
    }

    /**
     * @return DateTimeInterface
     * @throws Exception
     */
    public function getServerTime(): DateTimeInterface
    {
        return new DateTime('now', new DateTimeZone('America/Mexico_City'));
    }

    public function isTestMode(): bool
    {
        if(!$this->isRunningFromConsole()){
            return false;
        }

        return defined('PHPUNIT_RUNNING') && PHPUNIT_RUNNING == true;
    }
}