<?php

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

    public static function Select() {
        $sql = "SELECT * FROM " . static::GetTableName();
    }
    
    public abstract function GetTableName();

}
