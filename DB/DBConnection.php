<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace DB;

use mysqli;

/**
 * Description of DBConnection
 *
 * @author giavr
 */
class DBConnection {

    /**
     *
     * @var mysqli 
     */
    protected static $connection;

    /**
     * 
     * @param string $dbName
     * @return static
     */
    public static function GetConnection(string $dbName) {
        if (!self::$connection) {
            self::Connect($dbName);
        }
        return new self();
    }

    /**
     * 
     * @param string $dbName
     */
    private static function Connect(string $dbName) {
        $conn = new mysqli("localhost", "root", "", $dbName);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        self::$connection = $conn;
    }

    public static function CloseConnection() {
        self::$connection->close();
        self::$connection = null;
    }

    /**
     * 
     * @param string $sql
     */
    public function runQuery(string $sql) {


        if ($result = self::$connection->query($sql)) {
            return $result;
        } else {
            echo "error:" . print_r(self::$connection->error, true)."<br>";
            return [];
        }
    }

}
