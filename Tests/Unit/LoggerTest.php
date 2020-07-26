<?php


namespace Tests\Units;


use App\Contracts\LoggerInterface;
use App\Exception\InvalidLogLevelArgument;
use App\Helpers\App;
use App\Logger\Logger;
use App\Logger\LogLevel;
use PHPUnit\Framework\TestCase;

class LoggerTest extends TestCase
{
    /**
     * @var Logger
     */
    private $logger;

    protected function setUp(): void
    {
        $this->logger = new Logger();
        parent::setUp();
    }

    public function testItImplementsTheLoggerInterface()
    {
        self::assertInstanceOf(LoggerInterface::class, $this->logger);

    }

    public function testItCanCreateDifferentTypesOfLogLevels()
    {
        $this->logger->info('Testing Info logs');
        $this->logger->error('Testing Error logs');
        $this->logger->log(LogLevel::ALERT ,'Testing Alert logs');
        $app = new App();

        $fileName = sprintf("%s/%s-%s.log",$app->getLogPath(), $app->getEnvironment(), date("j.n.Y"));
        $contentOfFile = file_get_contents($fileName);

        self::assertFileExists($fileName);
        self::assertStringContainsString('Testing Info logs', $contentOfFile);
        self::assertStringContainsString('Testing Error logs', $contentOfFile);
        self::assertStringContainsString('Testing Alert logs', $contentOfFile);

        unlink($fileName);
        self::assertFileDoesNotExist($fileName);
    }


    public function testItThrowsInvalidLogLevelArgumentExceptionWhenGivenAWrongLogLevel()
    {
        self::expectException(InvalidLogLevelArgument::class);
        $this->logger->log('Wrong-Level' ,'Testing Alert logs');
    }


}