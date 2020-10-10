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
class Website extends DBTable{
    //put your code here
    public function GetTableName():string {
        return "website";
    }

}
