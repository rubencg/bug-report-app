<?php


namespace Tests\Unit;


use App\Database\PDOConnection;
use App\Database\QueryBuilder;
use App\Helpers\App;
use App\Helpers\Config;
use PHPUnit\Framework\TestCase;
class QueryBuilderTest extends TestCase
{
    private $queryBuilder;

    protected function setUp(): void
    {

        $this->queryBuilder = new QueryBuilder(new PDOConnection($this->getCredentials('pdo')));
        parent::setUp();
    }

    private function getCredentials(string $type)
    {
        return array_merge(
            Config::get('database', $type),
            ['db_name' => 'bug_app_testing']
        );
    }


    public function testItCanCreateRecords()
    {
        $data = "";
        $id = $this->queryBuilder->table('reports')->create($data);
        self::assertNotNull($id);

    }


    public function testItCanPerformRawQuery()
    {
//        $result = $this->queryBuilder->raw("SELECT * FROM reports");

//        self::assertNotNull($result);
    }


    public function testItCanPerformSelectQuery()
    {
        $expected_id = 1;
        $result = $this->queryBuilder
            ->table('reports')
            ->select('*')
            ->where('id', $expected_id)
//            ->first()
        ;

        var_dump($result->query);

        self::assertNotNull($result);
//        self::assertSame($expected_id, (int)$result->id);
    }

    public function testItCanPerformSelectQueryWithMultipleWhereClauses()
    {
        $expected_report_type = 'Report Type 1';
        $expected_id = 1;
        $result = $this->queryBuilder
            ->table('reports')
            ->select('*')
            ->where('id', $expected_id)->where('report_type', '=', $expected_report_type)
            ->first();

        self::assertNotNull($result);
        self::assertSame($expected_id, (int)$result->id);
        self::assertSame($expected_report_type, (string)$result->report_type);
    }

}