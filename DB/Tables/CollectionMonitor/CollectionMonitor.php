<?php

namespace DB\Tables\CollectionMonitor;

use Cοnfig\DBNames;
use DB\DBTable;



/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CollectionMonitor
 *
 * @author giavr
 */
abstract class CollectionMonitor extends DBTable {

    /**
     * 
     * {@inheritdoc}
     */
    public static function GetDBName(): string {
        return "collection_monitor";//DBNames::COLLECTION_MONITOR_DB;
    }

}
