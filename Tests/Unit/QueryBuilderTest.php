<?php


namespace Tests\Unit;


use PHPUnit\Framework\TestCase;
class QueryBuilderTest extends TestCase
{
    private $queryBuilder;

    protected function setUp(): void
    {
        $this->queryBuilder = new QueryBuilder();
        parent::setUp();
    }


    public function testItCanCreateRecords()
    {
        $id = $this->queryBuilder->table('reports')->create($data);
        self::assertNotNull($id);

    }


    public function testItCanPerformRawQuery()
    {
        $result = $this->queryBuilder->raw("SELECT * FROM reports");

        self::assertNotNull($result);
    }

    public function testItCanPerformSelectQuery()
    {
        $expected_id = 1;
        $result = $this->queryBuilder
            ->table('reports')
            ->select('*')
            ->where('id', $expected_id)
            ->first();

        self::assertNotNull($result);
        self::assertSame($expected_id, (int)$result->id);
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