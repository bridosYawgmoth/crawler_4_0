<?php

namespace DB;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace DB;

/**
 * Description of Website
 *
 * @author giavr
 */
abstract class DBTable {

    /**
     * 
     * @return static[]
     */
    public static function SelectAll() {
        $sql = "SELECT * FROM " . static::GetTableName();
        return static::QueryTable($sql);
    }

    /**
     * 
     * @param string $sql
     * @return static[]
     */
    private static function QueryTable(string $sql) {
        $connection = DBConnection::GetConnection(static::GetDBName());
        if (!$connection) {
            echo"No connection";
            return [];
        }
        $result = $connection->runQuery($sql);
        if (!$result) {
            echo"No result";
            return [];
        }
        $columns = self::GetColumns();
        if (!$columns) {
            echo"No columns";
            return [];
        }
        $objects = [];
        $objectName = static::class;
        while ($row = $result->fetch_assoc()) {
            $object = new $objectName($row);
            $objects[] = $object;
        }
        //echo "objects: " . print_r($objects, true);
        return $objects;
    }

    /**
     * 
     * @param int $idObject
     * @return static
     */
    public static function GetObject(int $idObject) {
        $result = static::SelectAll();
        if (count($result) > 1) {
            die("error multi result");
        }
        $object = reset($result);
        return $object;
    }

    /**
     * 
     * @param array $filters
     * @return static[]
     */
    public static function Filter(array $filters) {
        $sql = static::SqlFromFilter($filters);
        return static::QueryTable($sql);
    }

    /**
     * 
     * @param array $filters
     * @return static
     */
    public static function FilterSingleResult(array $filters) {
        $sql = static::SqlFromFilter($filters);
        //echo $sql;
        $result = static::QueryTable($sql);
        if (count($result) > 1) {
            die("multi result");
        }
        //echo "result" . print_r($result, true)."<br>";
        return reset($result);
    }

    /**
     * 
     * @param array $filters
     * @return string
     */
    private static function SqlFromFilter(array $filters) {
        $clause = [];
        foreach ($filters as $key => $value) {
            $clause[] = $key . " = " . $value;
        }

        $sql = "SELECT * FROM " . static::GetTableName();
        if ($clause) {
            $stringClause = implode(" AND ", $clause);
            $sql .= " WHERE " . $stringClause;
        }
        return $sql;
    }

    /**
     *  
     * @return string
     */
    public abstract static function GetTableName(): string;

    /**
     *  
     * @return string
     */
    public abstract static function GetDBName(): string;

    /**
     * 
     * @return arrays
     */
    protected static function GetColumns(): array {
        $columns = [];
        $connection = DBConnection::GetConnection(static::GetDBName());

        $className = static::GetTableName();
        $sql = "SELECT *
                    FROM INFORMATION_SCHEMA.COLUMNS
                    WHERE TABLE_NAME = '" . $className . "'";
        //echo $sql;
        $result = $connection->runQuery($sql);
        if ($result) {
            /* fetch object array */
            while ($row = $result->fetch_row()) {
                $columns[] = $row[3];
            }
        } else {
            var_dump("problem");
            die();
        }
        $connection::CloseConnection();
        return $columns;
    }

    /**
     * 
     * @return \Util\DBFieldNameType
     */
    public static function GetColumnNamesAndTypes(): array {
        $sql = "SELECT * FROM " . static::GetTableName() . " LIMIT 1";
        $connection = DBConnection::GetConnection(static::GetDBName());
        $types = [];
        if ($result = $connection->runQuery($sql)) {
            // Get field information for all fields

            while ($fieldinfo = $result->fetch_field()) {
                $types[] = new \Util\DBFieldNameType($fieldinfo->name, $fieldinfo->type);
            }
        }
        $connection::CloseConnection();
        return $types;
    }

    /**
     * 
     * @param array $specs
     */
    public function __construct(array $specs) {
        foreach ($specs as $name => $spec) {
            $this->$name = $spec;
        }
    }

    /**
     * 
     */
    public function insert() {
        $columns = static::GetColumnNamesAndTypes();
        $pairs = [];
        foreach ($columns as $column) {
            if ($column->getNeedsEscaping()) {
                $value = "'" . $this->{$column->getName()} . "'";
            } else {
                $value = $this->{$column->getName()};
            }
            $pairs[$column->getName()] = $value;
        }
        $pairs = array_filter($pairs);
        $keys = array_keys($pairs);
        $values = array_values($pairs);
        $keyString = implode(",", $keys);
        $valueString = implode(",", $values);
        $tableName = static::GetTableName();
        $insert = "INSERT INTO " . $tableName . "(" . $keyString . ")VALUES(" . $valueString . ")";
        echo $insert;
        $connection = DBConnection::GetConnection(static::GetDBName());
        $connection->runQuery($insert);
        $connection::CloseConnection();
    }

}
