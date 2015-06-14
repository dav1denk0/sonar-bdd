<?php

use Behat\Behat\Context\BehatContext;
use Symfony\Component\Yaml\Yaml;
use Hamcrest\Matcher;

require_once 'RequestContext.php';

class StepsContext extends BehatContext
{
    private $_requests_manager = null;

    public function __construct(array $parameters)
    {
        $_requests_manager = new RequestContext($parameters);
    }

    /**
     * @Given /^I want to add a new "([^"]*)" in sonar$/
     */
    public function iWantToAddANewInSonar($arg1)
    {

    }

    /**
     * @Given /^the provider name is "([^"]*)"$/
     */
    public function theProviderNameIs($arg1)
    {
        throw new PendingException();
    }

    /**
     * @When /^I perform a request with the provider id "([^"]*)" to add the place$/
     */
    public function iPerformARequestWithTheProviderIdToAddThePlace($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Then /^I get a "([^"]*)" response status code$/
     */
    public function iGetAResponseStatusCode($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Given /^the response has an "([^"]*)" property$/
     * @Given /^the response has a "([^"]*)" property$/
     */
    public function theResponseHasAnProperty($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Given /^the "([^"]*)" property is alphanumeric$/
     */
    public function thePropertyIsAlphanumeric($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Given /^the error message returned should be "([^"]*)"$/
     */
    public function theErrorMessageReturnedShouldBe($arg1)
    {
        throw new PendingException();
    }

    /**
     * @When /^I perform a request without specifying a provider id$/
     */
    public function iPerformARequestWithoutSpecifyingAProviderId()
    {
        throw new PendingException();
    }

    /**
     * @Given /^I want to find a "([^"]*)"$/
     */
    public function iWantToFindA($arg1)
    {
        throw new PendingException();
    }

    /**
     * @When /^I perform a request with the provider id "([^"]*)" to get the place's information$/
     */
    public function iPerformARequestWithTheProviderIdToGetThePlaceSInformation($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Given /^I want to remove a "([^"]*)" in sonar$/
     */
    public function iWantToRemoveAInSonar($arg1)
    {
        throw new PendingException();
    }

    /**
     * @When /^I perform a request with the provider id "([^"]*)" to delete the place$/
     */
    public function iPerformARequestWithTheProviderIdToDeleteThePlace($arg1)
    {
        throw new PendingException();
    }

    /**
     * @When /^I perform a request with the UUID "([^"]*)" to get the place's information$/
     */
    public function iPerformARequestWithTheUUIDToGetThePlaceSInformation($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Given /^the "([^"]*)" property in the response is the same as "([^"]*)"$/
     */
    public function thePropertyInTheResponseIsTheSameAs($arg1, $arg2)
    {
        throw new PendingException();
    }
}