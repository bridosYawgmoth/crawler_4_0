<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Crawler\CardMarket\Request;

use Config\RequestMethods;
use DB\Tables\Crawler\UserWebsiteCredentials;

/**
 * Description of ProductRequest
 *
 * @author giavr
 */
class ProductRequest extends CardMarketRequest {

    /**
     *
     * @var int
     */
    protected $idProduct;

    /**
     * 
     * {@inheritdoc}
     */
    protected function getMethod(): string {
        return RequestMethods::METHOD_GET;
    }

    /**
     * 
     * {@inheritdoc}
     */
    protected function getUrl(): string {
        return parent::getUrl() . "products/" . $this->idProduct;
    }

    /**
     * 
     * @param UserWebsiteCredentials $credentials
     * @param int $idProduct
     */
    public function __construct(UserWebsiteCredentials $credentials, int $idProduct) {
        parent::__construct($credentials);
        $this->idProduct = $idProduct;
        $this->prepareRequest();
    }

}
