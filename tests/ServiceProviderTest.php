<?php

use Locations\ServiceProvider;
use PHPUnit\Framework\TestCase;
use Locations\TownCommand;

require_once './vendor/autoload.php';

class ServiceProviderTest extends TestCase {

    /**
     * test normalizing city names
     * input: ['Little', 'London,', 'Dalblair']
     * output: ['Little London', 'Dalblair'] 
     */
    public function testNormalizeCityNames() {
        $res = ServiceProvider::normalizeCityNames(['Little', 'London,', 'Dalblair']);
        $this->assertArraySubset([
            ['Town' => 'Little London'],
            ['Town' => 'Dalblair']
                ], $res);
    }

    /**
     * test normalizeCityNames and soapCall with correct url and arguments
     * response should not be empty 
     */
    public function testSoapCallCorrect() {
        $arguments = ServiceProvider::normalizeCityNames(['Little', 'London,', 'Dalblair']);
        $ukLocations = new ServiceProvider();
        $res = $ukLocations->soapCall($arguments);
        $this->assertNotEmpty($res);
    }

    /**
     * test soapCall with wrong arguments
     * @expectedException BeSimple\SoapClient\SoapFaultWithTracingData
     */
    public function testSoapCallWrongArgument() {
        $ukLocations = new ServiceProvider();
        $ukLocations->soapCall(['London', 'Dalblair']);
    }

    /**
     * test soapCall with wrong url
     * @expectedException SoapFault
     */
    public function testSoapCallWrongUrl() {
        $ukLocations = new ServiceProvider();
        $ukLocations->setUrl("http://www.webservicex.net/location.asmx?WSDL");
        $ukLocations->soapCall(['Town' => 'Dalblair']);
    }

}
