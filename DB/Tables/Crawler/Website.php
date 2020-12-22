<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace DB\Tables\Crawler;

/**
 * Description of Website
 *
 * @author giavr
 */
class Website extends Crawler4_0 {

    /**
     *
     * @var int
     */
    protected $idWebsite;

    /**
     *
     * @var string 
     */
    protected $websiteName;

    /**
     *
     * @var string
     */
    protected $baseUrl;

    /**
     * 
     * {@inheritdoc}
     */
    public static function GetTableName(): string {
        return "website";
    }

    /**
     * 
     * @param int $idWebsite
     * @return static
     */
    public static function GetWebsite(int $idWebsite) {
        return static::GetObject($idWebsite);
    }

    /**
     * 
     * @return string
     */
    public function getbaseUrl(): string {
        return $this->baseUrl;
    }

}
