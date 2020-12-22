<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace DB\Tables\Crawler;

use Cοnfig\DBNames;
use DB\DBTable;

/**
 * Description of Card
 *
 * @author giavr
 */
class Card extends DBTable {

    /**
     *
     * @var int 
     */
    protected $idCard;

    /**
     *
     * @var string 
     */
    protected $cardName;

    /**
     * 
     * {@inheritdoc}
     */
    public static function GetDBName(): string {
        return "card";
    }

    /**
     * 
     * {@inheritdoc}
     */
    public static function GetTableName(): string {
        return DBNames::CRAWLER_DB;
    }

}
