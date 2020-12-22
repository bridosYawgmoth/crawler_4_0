<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace DB\Tables\Crawler;

use DB\Tables\Crawler\Crawler4_0;

/**
 * Description of UserWebsiteCredentials
 *
 * @author giavr
 */
class UserWebsiteCredentials extends Crawler4_0 {

    /**
     *
     * @var int 
     */
    protected $idUser;

    /**
     *
     * @var int 
     */
    protected $idWebsite;

    /**
     *
     * @var string 
     */
    protected $credentials;

    /**
     * 
     * {@inheritdoc}
     */
    public static function GetTableName(): string {
        return "user_website_credentials";
    }

    /**
     * 
     * @param int $idUser
     * @param int $idWebsite
     */
    public static function GetUserSiteCredentials(int $idUser, int $idWebsite) {
        $filters = [
            'idUser' => $idUser,
            'idWebsite' => $idWebsite,
        ];
        return static::FilterSingleResult($filters);
    }

    /**
     * 
     * @return string
     */
    public function getCredentials(): string {
        return $this->credentials;
    }

    /**
     * 
     * @return int
     */
    public function getIdWebsite(): int {
        return $this->idWebsite;
    }

}
