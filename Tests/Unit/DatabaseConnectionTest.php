<?php


namespace Tests\Unit;


use App\Contracts\DatabaseConnectionInterface;
use App\Database\MySqliConnection;
use App\Database\PDOConnection;
use App\Exception\MissingArgumentException;
use App\Helpers\Config;
use PHPUnit\Framework\TestCase;

class DatabaseConnectionTest extends TestCase
{
    public function testItThrowsMissingArgumentExceptionWithWrongCredentialKeys()
    {
        self::expectException(MissingArgumentException::class);
        $credentials = [];
        new PDOConnection($credentials);
    }

    public function testItCanConnectToDatabaseWithPdoApi()
    {
        $credentials = $this->getCredentials('pdo');

        $pdoHandler = (new PDOConnection($credentials))->connect();
        self::assertInstanceOf(PDOConnection::class, $pdoHandler);
        return $pdoHandler;
    }

    /**
     * @depends testItCanConnectToDatabaseWithPdoApi
     * @param DatabaseConnectionInterface $handler
     */
    public function testItIsAValidPdoConnection(DatabaseConnectionInterface $handler)
    {
        self::assertInstanceOf(\PDO::class, $handler->getConnection());
    }

    public function testItCanConnectToDatabaseWithMySqliApi()
    {
        $credentials = $this->getCredentials('mysqli');

        $handler = (new MySqliConnection($credentials))->connect();
        self::assertInstanceOf(MySqliConnection::class, $handler);
        return $handler;
    }

    /**
     * @depends testItCanConnectToDatabaseWithMySqliApi
     * @param DatabaseConnectionInterface $handler
     */
    public function testItIsAValidMySqliConnection(DatabaseConnectionInterface $handler)
    {
        self::assertInstanceOf(\mysqli::class, $handler->getConnection());
    }

    private function getCredentials(string $type)
    {
        return array_merge(
            Config::get('database', $type),
            ['db_name' => 'bug_app_testing']
        );
    }


}