@regression
Feature: Delete a registered place in Sonar and all it's associations
  In order to manage useful information about places from different providers
  As a Sonar user
  I want to remove places using provider's information

  @delete_place_in_facebook @sanity @facebook_e2e
  Scenario: Delete a stored place in Facebook
    Given I want to remove a "place" in sonar
    And the provider name is "Facebook"
    When I perform a request with the provider id "100473940700" to delete the place
    Then I get a "200 OK" response status code
    And the response is a JSON object

  @get_deleted_place_in_facebook @sanity @facebook_e2e
  Scenario: Attempt to get a deleted place in Facebook
    Given I want to find a "place"
    And the provider name is "Facebook"
    When I perform a request with the provider id "100473940700" to get the place's information
    Then I get a "404 Not Found" response status code
    And the response is a JSON object
    And the error message returned should contain the message "No SourcePlace found"

  @delete_place_in_foursquare @sanity @foursquare_e2e
  Scenario: Delete a stored place in Foursquare
    Given I want to remove a "place" in sonar
    And the provider name is "Foursquare"
    When I perform a request with the provider id "4b7755f5f964a5200f932ee3" to delete the place
    Then I get a "200 OK" response status code
    And the response is a JSON object

  @get_deleted_place_in_foursquare @sanity @foursquare_e2e
  Scenario: Attempt to get a deleted place in Foursquare
    Given I want to find a "place"
    And the provider name is "Foursquare"
    When I perform a request with the provider id "4b7755f5f964a5200f932ee3" to get the place's information
    Then I get a "404 Not Found" response status code
    And the response is a JSON object
    And the error message returned should contain the message "No SourcePlace found"

  @delete_place_in_facebook_without_id
  Scenario: Attempt to delete a place in Facebook without provider id
    Given I want to remove a "place" in sonar
    And the provider name is "Facebook"
    When I perform a request without specifying a provider id
    Then I get a "404 Not Found" response status code
    And the response is a JSON object
    And the error message returned should contain the message "No route found"