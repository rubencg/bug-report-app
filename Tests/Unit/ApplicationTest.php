<?php


namespace Tests\Units;


use App\Helpers\App;
use PHPUnit\Framework\TestCase;

class ApplicationTest extends TestCase
{

    public function testItCanGetInstanceOfApplication()
    {
        self::assertInstanceOf(App::class, new App());
    }

    public function testItCanGetBasicApplicationDataSetFromAppClass()
    {
        $app = new App();
        self::assertTrue($app->isRunningFromConsole());
        self::assertSame('test', $app->getEnvironment());
        self::assertNotNull($app->getLogPath());
        self::assertInstanceOf(\DateTime::class, $app->getServerTime());
    }
}