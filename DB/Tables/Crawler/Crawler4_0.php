<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace DB\Tables\Crawler;

/**
 * Description of Crawler4_0
 *
 * @author giavr
 */
abstract class Crawler4_0 extends \DB\DBTable {

    /**
     * 
     * {@inheritdoc}
     */
    public static function GetDBName(): string {
        return "crawler4_0";
    }

}
