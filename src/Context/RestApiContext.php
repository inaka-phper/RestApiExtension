<?php
namespace Behat\RestApiExtension\Context;

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

/**
 * Defines application features from the specific context.
 */
class RestApiContext implements Context, SnippetAcceptingContext
{
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    private $_headers;
    private $_params;

    private $_ch;
    private $_responseBody;

    private $_parameters;

    public function setParameters($params){
        $this->_parameters = $params;
    }
    private function baseUrl(){
        return $this->_parameters["base_url"];
    }
    /**
     * Initializes context.
     * Every scenario gets its own context object.
     *
     * @param array $parameters context parameters (set them up through behat.yml)
     */
    public function __construct()
    {
        $this->_headers = array();
        $this->_params = array();
    }

    /**
     * @When /^I set header "([^"]*)" with "([^"]*)"$/
     */
    public function iSetHeaderWith($arg1, $arg2)
    {
        $this->_headers[] = "$arg1: $arg2";
    }

    /**
     * @When /^I set parameter "([^"]*)" with "([^"]*)"$/
     */
    public function iSetParameterWith($arg1, $arg2)
    {
        $this->_params[$arg1] = $arg2;
    }

    /**
     * @When /^I set array parameter "([^"]*)" with "([^"]*)"$/
     */
    public function iSetArrayParameterWith($arg1, $arg2)
    {
        $this->_params[$arg1] = explode(',',$arg2);
    }

    /**
     * @When /^I send GET request to "([^"]*)"$/
     */
    public function iSendGetRequestTo($arg1)
    {
        $ch = curl_init(); // init
//        curl_setopt($conn, CURLOPT_SSL_VERIFYPEER, false);
//        curl_setopt($conn, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER,$this->_headers);
        curl_setopt($ch, CURLOPT_URL, $this->baseUrl().$arg1."?".http_build_query($this->_params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
        $response = curl_exec($ch); 
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
        $header = substr($response, 0, $header_size);
        $this->_responseBody = $response;
        $this->_ch = $ch;
    }

    /**
     * @Then /^I should get json response equal to '([^']*)'$/
     */
    public function iShouldGetJsonResponseEqualTo($arg1)
    {
        $ar1 = json_decode($arg1, true);
        $ar2 = json_decode($this->_responseBody, true);
        $diff = array_diff($ar1, $ar2);
        if(count($diff) > 0 ){
            throw new \Exception("Expected => $arg1, \n Actual => $this->_responseBody");
        }
    }

    /**
     * @Then /^the response status code should be (\d+)$/
     */
    public function theResponseStatusCodeShouldBe($arg1)
    {
        $actual   = curl_getinfo($this->_ch, CURLINFO_HTTP_CODE);
        $expected = intval($arg1);
        if($actual !== $expected){
            throw new \Exception("Expected => $expected, Actual => $actual");
        }
    }


    /**
     * @Then /^the response content-type should be "([^"]*)"$/
     */
    public function theResponseContentTypeShouldBe($expected)
    {
        $actual = curl_getinfo($this->_ch, CURLINFO_CONTENT_TYPE);
        if($actual !== $expected){
            throw new \Exception("Expected => $expected, Actual => $actual");
        }
    }



    /**
     * @When /^I send POST request to "([^"]*)"$/
     */
    public function iSendPostRequestTo($arg1)
    {
        $ch = curl_init(); // init
//        curl_setopt($conn, CURLOPT_SSL_VERIFYPEER, false);
//        curl_setopt($conn, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER,$this->_headers);
        curl_setopt($ch, CURLOPT_URL, $this->baseUrl().$arg1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
        curl_setopt($ch,CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($this->_params));
        $response = curl_exec($ch); 
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
        $header = substr($response, 0, $header_size);
        $this->_responseBody = $response;
        $this->_ch = $ch;
    }
//
// Place your definition and hook methods here:
//
//    /**
//     * @Given /^I have done something with "([^"]*)"$/
//     */
//    public function iHaveDoneSomethingWith($argument)
//    {
//        doSomethingWith($argument);
//    }
//
}
