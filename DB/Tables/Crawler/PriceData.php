<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace DB\Tables\Crawler;

/**
 * Description of PriceData
 *
 * @author giavr
 */
class PriceData extends Crawler4_0 {

    /**
     *
     * @var int
     */
    protected $idPricepoint;

    /**
     *
     * @var int
     */
    protected $idCard;

    /**
     *
     * @var int
     */
    protected $idWebsite;

    /**
     *
     * @var date
     */
    protected $date;

    /**
     * 
     * {@inheritdoc}
     */
    public static function GetTableName(): string {
        return "price_data";
    }

}
