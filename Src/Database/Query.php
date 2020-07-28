<?php


namespace App\Database;


use App\Exception\InvalidLogLevelArgument;

trait Query
{
    private function getQuery($operation): string
    {
        switch ($operation){
            case self::DML_TYPE_SELECT:
                return sprintf("SELECT %s FROM %s WHERE %s",
                    $this->fields,
                    $this->table,
                    implode(' and ', $this->placeholders)
                );
            case self::DML_TYPE_INSERT:
                return sprintf("INSERT INTO %s (%s) VALUES (%s)",
                    $this->table,
                    $this->fields,
                    implode(' , ', $this->placeholders)
                );
            case self::DML_TYPE_DELETE:
                return sprintf("DELETE FROM %s WHERE %s",
                    $this->table,
                    implode(' and ', $this->placeholders)
                );
            case self::DML_TYPE_UPDATE:
                return sprintf("UPDATE %s SET %s WHERE %s",
                    $this->table,
                    implode(' , ', $this->fields),
                    implode(' and ', $this->placeholders)
                );
            default:
                throw new InvalidLogLevelArgument('Dml type not supported');
        }
    }
}