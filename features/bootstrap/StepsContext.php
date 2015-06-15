<?php

use Behat\Behat\Context\BehatContext;

require_once 'RequestContext.php';

class StepsContext extends BehatContext
{
    private $_requests_manager;

    public function __construct(array $parameters)
    {
        $this->_requests_manager = new RequestContext($parameters);
    }

    /**
     * @Given /^I want to add a new "([^"]*)" in sonar$/
     * @Given /^I want to update a "([^"]*)" in sonar$/
     */
    public function addEntityInSonar($entity_name)
    {
        $this->_requests_manager->addAnEntityByName($entity_name);
    }

    /**
     * @Given /^the provider name is "([^"]*)"$/
     */
    public function theProviderNameIs($provider_name)
    {
        $this->_requests_manager->addProviderToPathUrl($provider_name);
    }

    /**
     * @When /^I perform a request with the provider id "([^"]*)" to add the place$/
     * @Given /^I perform a request with the provider id "([^"]*)" to update the place$/
     * @When /^I perform a request with the provider id "([^"]*)" to get the place's information$/
     * @When /^I perform a request with the provider id "([^"]*)" to delete the place$/
     *
     */
    public function iPerformARequestWithTheProviderId($providerPlaceId)
    {
        $this->_requests_manager->executeProviderRequest($providerPlaceId);
    }

    /**
     * @Then /^I get a "([^"]*)" response status code$/
     */
    public function iGetAResponseStatusCode($response_code)
    {
        $actual_response = $this->_requests_manager->getResponseCodeStatusAndReason();
        PHPUnit_Framework_Assert::assertEquals($response_code, $actual_response,
            "The response is not the same, should be ".$response_code." but is ".$actual_response);
    }

    /**
     * @Then /^the response has an "([^"]*)" property$/
     * @Then /^the response has a "([^"]*)" property$/
     */
    public function theResponseHasAnProperty($property_name)
    {
        PHPUnit_Framework_Assert::assertTrue($this->_requests_manager->isPropertyNameInResponse($property_name),
            "The property name ".$property_name." is not present in the response");
    }

    /**
     * @Given /^the "([^"]*)" property is a "([^"]*)" type$/
     */
    public function thePropertyIsAType($property_name, $type)
    {
        PHPUnit_Framework_Assert::assertTrue($this->_requests_manager->checkPropertyTypeInData($property_name, $type),
            "The property name ".$property_name." is not ".$type." type");
    }

    /**
     * @Then /^the error message returned should be "([^"]*)"$/
     */
    public function theErrorMessageReturnedShouldBe($response_code)
    {
        $actual_response = $this->_requests_manager->getResponseErrorMessage();
        PHPUnit_Framework_Assert::assertEquals($response_code, $actual_response,
            "The response code is incorrect. It should be ".$response_code." but is ".$actual_response);
    }

    /**
     * @When /^I perform a request without specifying a provider id$/
     */
    public function iPerformARequestWithoutSpecifyingAProviderId()
    {
        $this->_requests_manager->executeProviderRequest("");
    }

    /**
     * @Given /^I want to find a "([^"]*)"$/
     */
    public function iWantToFindA($entityName)
    {
        $this->_requests_manager->getAnEntityByName($entityName);
    }

    /**
     * @Given /^I want to remove a "([^"]*)" in sonar$/
     */
    public function iWantToRemoveAInSonar($entityName)
    {
        $this->_requests_manager->removeAnEntityByName($entityName);
    }

    /**
     * @When /^I perform a request with the UUID to get the place's information$/
     */
    public function iPerformARequestWithTheUUIDToGetThePlaceSInformation()
    {
        $uuidValue = $this->_requests_manager->getPropertyValueByPropertyName('id');
        $this->_requests_manager->executeUuidRequest($uuidValue);
    }

    /**
     * @Then /^the response is a JSON object$/
     */
    public function theResponseIsAJSONObject()
    {
        PHPUnit_Framework_Assert::assertTrue($this->_requests_manager->isTheResponseAJsonObject(),
            "The response is not a JSON object");
    }

    /**
     * @Given /^the error message returned should contain the message "([^"]*)"$/
     */
    public function theErrorMessageReturnedShouldContainTheMessage($response_code)
    {
        $actual_response = $this->_requests_manager->getResponseErrorMessage();
        PHPUnit_Framework_Assert::assertContains($response_code, $actual_response,
            "The response code is incorrect. It should be ".$response_code." but is ".$actual_response);
    }

    /**
     * @Given /^the "([^"]*)" property's value is "([^"]*)"$/
     */
    public function thePropertySValueIs($propertyName, $propertyValue)
    {
        $actual_response = $this->_requests_manager->getPropertyValueByPropertyName($propertyName);
        PHPUnit_Framework_Assert::assertEquals($propertyValue, $actual_response,
            "The property value is incorrect. It should be ".$propertyValue." but it is ".$actual_response);
    }

    /**
     * @When /^I want to get a registered place in \'([^\']*)\' by UUID$/
     */
    public function iWantToGetARegisteredPlaceInByUUID($providerName)
    {
        $this->_requests_manager->addProviderToPathUrl($providerName);
    }

    /**
     * @Given /^I perform a request without specifying the UUID$/
     */
    public function iPerformARequestWithoutSpecifyingTheUUID()
    {
        $this->_requests_manager->executeUuidRequest("");
    }
}