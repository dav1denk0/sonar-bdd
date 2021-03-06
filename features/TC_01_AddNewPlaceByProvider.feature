@regression
Feature: Add a new place in Sonar
  In order to store and normalize information about places from different providers
  As a Sonar user
  I want to add a new place using provider's information

  @add_place_to_facebook @sanity @facebook_e2e
  Scenario: Add new place in Facebook
    Given I want to add a new "place" in sonar
    And the provider name is "Facebook"
    When I perform a request with the provider id "100473940700" to add the place
    Then I get a "201 Created" response status code
    And the response is a JSON object
    And the response has an "id" property
    And the "id" property is a "string" type

  @add_place_to_foursquare @sanity @foursquare_e2e
  Scenario: Add new place in Foursquare
    Given I want to add a new "place" in sonar
    And the provider name is "Foursquare"
    When I perform a request with the provider id "4b7755f5f964a5200f932ee3" to add the place
    Then I get a "201 Created" response status code
    And the response is a JSON object
    And the response has an "id" property
    And the "id" property is a "string" type

  @add_place_to_twitter
  Scenario: Attempt to add new place in Twitter
    Given I want to add a new "place" in sonar
    And the provider name is "twitter"
    When I perform a request with the provider id "4b7755f5f964a5200f932ee3" to add the place
    Then I get a "404 Not Found" response status code
    And the response is a JSON object
    And the error message returned should be "Unknown provider with name: twitter"

  @add_place_to_facebook_without_id
  Scenario: Attempt to add new place in Facebook without provider id
    Given I want to add a new "place" in sonar
    And the provider name is "Facebook"
    When I perform a request without specifying a provider id
    Then I get a "404 Not Found" response status code
    And the response is a JSON object
    And the error message returned should contain the message "No route found"