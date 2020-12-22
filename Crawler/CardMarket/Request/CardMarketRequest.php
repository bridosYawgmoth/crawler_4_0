<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Crawler\CardMarket\Request;

use Config\CardmarketCrawlingConfig;
use DB\Tables\Crawler\UserWebsiteCredentials;
use DB\Tables\Crawler\Website;

/**
 * Description of CardMarketRequest
 *
 * @author giavr
 */
abstract class CardMarketRequest {

    /**
     *
     * @var string
     */
    protected $appToken;

    /**
     *
     * @var string
     */
    protected $appSecret;

    /**
     *
     * @var string
     */
    protected $accessToken;

    /**
     *
     * @var string
     */
    protected $accessTokenSecret;

    /**
     *
     * @var string
     */
    protected $url;

    /**
     *
     * @var UserWebsiteCredentials
     */
    protected $userCredentials;

    /**
     *
     * @var json
     */
    protected $response;

    /**
     * 
     * @param UserWebsiteCredentials $credentials
     */
    public function __construct(UserWebsiteCredentials $userCredentials) {
        $this->userCredentials = $userCredentials;

        $this->setupCredentials();
    }

    /**
     * 
     */
    private function setupCredentials() {
        $credentials = json_decode($this->userCredentials->getCredentials());
        $this->accessTokenSecret = $credentials->accessTokenSecret;
        $this->accessToken = $credentials->accessToken;
        $this->appSecret = $credentials->appSecret;
        $this->appToken = $credentials->appToken;
    }

    protected function prepareRequest() {
        $this->url = $this->getUrl();
        $this->method = $this->getMethod();
        $params = array(
            'realm' => $this->url,
            'oauth_consumer_key' => $this->appToken,
            'oauth_token' => $this->accessToken,
            'oauth_nonce' => CardmarketCrawlingConfig::NONCE,
            'oauth_timestamp' => CardmarketCrawlingConfig::TIMESTAMP,
            'oauth_signature_method' => CardmarketCrawlingConfig::SIGNATURE_METHOD,
            'oauth_version' => CardmarketCrawlingConfig::OATH_VERSION,
        );

        $baseString = strtoupper($this->method) . "&";
        $baseString .= rawurlencode($this->url) . "&";
        $encodedParams = array();
        foreach ($params as $key => $value) {
            if ("realm" != $key) {
                $encodedParams[rawurlencode($key)] = rawurlencode($value);
            }
        }
        ksort($encodedParams);
        $values = array();
        foreach ($encodedParams as $key => $value) {
            $values[] = $key . "=" . $value;
        }
        $paramsString = rawurlencode(implode("&", $values));
        $baseString .= $paramsString;

        $signatureKey = rawurlencode($this->appSecret) . "&" . rawurlencode($this->accessTokenSecret);

        /**
         * Create the OAuth signature
         * Attention: Make sure to provide the binary data to the Base64 encoder
         *
         * @var $oAuthSignature string OAuth signature value
         */
        $rawSignature = hash_hmac("sha1", $baseString, $signatureKey, true);
        $oAuthSignature = base64_encode($rawSignature);

        /*
         * Include the OAuth signature parameter in the header parameters array
         */
        $params['oauth_signature'] = $oAuthSignature;

        /*
         * Construct the header string
         */
        $header = "Authorization: OAuth ";

        $headerParams = array();
        foreach ($params as $key => $value) {
            $headerParams[] = $key . "=\"" . $value . "\"";
        }
        $header .= implode(", ", $headerParams);

        //die($header);
        $this->header = $header;
        $this->baseString = $baseString;
    }

    public function execute($data = FALSE) {
        $curlHandle = curl_init();
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlHandle, CURLOPT_URL, $this->url);
        curl_setopt($curlHandle, CURLOPT_HTTPHEADER, array($this->header));
        //print_r($this->header);
        curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, false);
        if ($this->method == "PUT") {
            //echo "in put<br>";
            curl_setopt($curlHandle, CURLOPT_CUSTOMREQUEST, "PUT");
            //curl_setopt($curlHandle, CURLOPT_POSTFIELDS, http_build_query($data));
            //curl_setopt($curlHandle, CURLOPT_HTTPHEADER, array('Content-Type: application/xml'));
            curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $data);
        }
        //print_r($this->header);
        //print_r($data);
        /**
         * Execute the request, retrieve information about the request and response, and close the connection
         *
         * @var $content string Response to the request
         * @var $info array Array with information about the last request on the $curlHandle
         */
        $content = curl_exec($curlHandle);



        /*
         * Convert the response string into an object
         *
         * If you have chosen XML as response format (which is standard) use simplexml_load_string
         * If you have chosen JSON as response format use json_decode
         *
         * @var $decoded \SimpleXMLElement|\stdClass Converted Object (XML|JSON)
         */
        // $decoded            = json_decode($content);
        // echo "<pre>";
        //print_r($content);
        // echo "</pre>";
        $decoded = json_decode($content);
        $info = curl_getinfo($curlHandle);
        curl_close($curlHandle);
        if ($info["http_code"] == 200) {
            $this->response = $decoded;
//            echo "status: <pre>";
//            print_r($info);
//            echo "</pre>";
//            echo "resp: <pre>";
//            print_r($decoded);
//            echo "</pre>";
            //return $this->response;
        } else {
            echo "status: <pre>";
            print_r($info);
            echo "</pre>";
            echo "resp: <pre>";
            print_r($content);
            echo "</pre>";

            die("error in resp<br>");
        }
        // echo "status: <pre>";
        // print_r($info);
        // echo "</pre>";
        // echo "resp: <pre>";
        // print_r($decoded);
        // echo "</pre>";

        die();
    }

    /**
     * 
     * @return string
     */
    protected function getUrl(): string {
        $idWebsite = $this->userCredentials->getIdWebsite();
        print_r("before");
        $website = Website::GetWebsite($idWebsite);
        $baseUrl = $website->getbaseUrl();
        return $baseUrl . CardmarketCrawlingConfig::API_VERSION_2 . "/output.json/";
    }

    /**
     *
     * @return string
     */
    protected abstract function getMethod(): string;
}
