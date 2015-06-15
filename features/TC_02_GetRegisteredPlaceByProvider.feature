@regression
Feature: Get places in Sonar by provider id
  In order to get a registered place from a provider
  As a Sonar user
  I want to get the place information using the provider id

  @sanity @facebook_e2e
  Scenario: Get a registered place in Facebook
    Given I want to find a "place"
    And the provider name is "Facebook"
    When I perform a request with the provider id "100473940700" to get the place's information
    Then I get a "200 OK" response status code
    And the response is a JSON object
    And the response has an "id" property
    And the "id" property is a "string" type

  @sanity @foursquare_e2e
  Scenario: Get a registered place in Foursquare
    Given I want to find a "place"
    And the provider name is "Foursquare"
    When I perform a request with the provider id "4b7755f5f964a5200f932ee3" to get the place's information
    Then I get a "200 OK" response status code
    And the response is a JSON object
    And the response has an "id" property
    And the "id" property is a "string" type

  Scenario: Attempt to add new place in Twitter
    Given I want to find a "place"
    And the provider name is "Twitter"
    When I perform a request with the provider id "4b7755f5f964a5200f932ee3" to get the place's information
    Then I get a "404 Not Found" response status code
    And the response is a JSON object
    And the error message returned should be "Unknown provider with name: twitter"