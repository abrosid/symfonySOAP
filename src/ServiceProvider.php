<?php

namespace Locations;

use BeSimple\SoapClient\SoapClientBuilder;
use BeSimple\SoapClient\SoapClientOptionsBuilder;
use BeSimple\SoapCommon\SoapOptionsBuilder;
use BeSimple\SoapClient\SoapFaultWithTracingData;

/**
 * SOAP client provider for the web service
 * @link http://www.webservicex.net/uklocation.asmx?WSDL
 * @uses BeSimple\SoapClient\SoapClientBuilder
 * @uses BeSimple\SoapClient\SoapClientOptionsBuilder
 * @uses BeSimple\SoapCommon\SoapOptionsBuilder
 * @uses BeSimple\SoapClient\SoapFaultWithTracingData
 * @internal TASK: 3...use this public SOAP service: http://www.webservicex.net/uklocation.asmx?WSDL
 */
class ServiceProvider {

    /**
     *
     * @var String
     */
    private $url;

    /**
     *
     * @var \BeSimple\SoapClient\SoapClient
     */
    private $soapClient;

    /**
     *
     * @var []
     */
    private $arguments;

    /**
     * SOAP client service
     */
    public function __construct() {
        $this->url = "http://www.webservicex.net/uklocation.asmx?WSDL";
    }

    function getUrl() {
        return $this->url;
    }

    function setUrl(String $url) {
        $this->url = $url;
    }

        
    /**
     * Initializes SOAP client for $url with default options
     * @param array $args
     * @todo implement argumanet's validation, should be associative key=>value array
     */
    private function initSoapClient(array $args) {
        $this->arguments = $args;
        $soapClientBuilder = new SoapClientBuilder();
        $clientOptions = SoapClientOptionsBuilder::createWithDefaults();
        $soapOptions = SoapOptionsBuilder::createWithDefaults($this->url);
        $this->soapClient = $soapClientBuilder->build($clientOptions, $soapOptions);
    }

    /**
     * Normalizes city names, received from CLI input arguments array
     * Implodes to string using glue ' ', and then explodes to array using separator ','.
     * 
     * @param array $arr CLI argumets
     * @return array
     */
    static function normalizeCityNames(array $arr) {
        $sc = implode(" ", $arr);
        $ac = explode(',', $sc);
        $arguments = [];
        foreach ($ac as $value) {
            $cityName = (string) trim($value);
            if (strlen($cityName)) {
                $arguments[] = ['Town' => $cityName];
            }
        }
        return $arguments;
    }

    /**
     * Performs SOAP call
     * @throws SoapFaultWithTracingData
     */
    public function soapCall(array $arguments) {
        $this->initSoapClient($arguments);
        $res = [];
        foreach ($this->arguments as $argument) {
            try {
                $soapResponse = $this->soapClient->soapCall('GetUKLocationByTown', [$argument]);
                $xmlString = $soapResponse->getResponseObject()->GetUKLocationByTownResult;
                $arr = simplexml_load_string($xmlString);
                if (!empty($arr)) {
                    foreach ($arr as $value) {
                        $res[trim($value->PostCode)] = $value;
                    }
                }
            } catch (SoapFaultWithTracingData $fault) {
                throw $fault;
            }
        }
        return $res;
    }

}
