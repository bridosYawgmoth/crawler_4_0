<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace DB\Tables\CollectionMonitor;

use Cοnfig\DBNames;

/**
 * Description of User
 *
 * @author giavr
 */
class Users extends CollectionMonitor {

    /**
     *
     * @var int
     */
    protected $idUser;

    /**
     *
     * @var string
     */
    protected $userName;

    /**
     *
     * @var string
     */
    protected $password;

    /**
     * 
     * {@inheritdoc}
     */
    public static function GetTableName(): string {
        return "user_account";
    }



}
