@regression
Feature: Get registered places in Sonar by Sonar place id (UUID)
  In order to get a registered place in Sonar
  As a Sonar user
  I want to get the place information using the Sonar place id (UUID)

  @get_registered_uuid_in_facebook @sanity @facebook_e2e
  Scenario: Get a registered place by UUID in Facebook
    Given I want to update a "place" in sonar
    And the provider name is "Facebook"
    And I perform a request with the provider id "100473940700" to update the place
    And I get a "200 OK" response status code
    And the response is a JSON object
    And the response has an "id" property
    And the "id" property is a "string" type
    When I want to get a registered place in 'Sonar' by UUID
    And I perform a request with the UUID to get the place's information
    Then I get a "200 OK" response status code
    And the response is a JSON object
    And the response has a "name" property
    And the "name" property's value is "Hyatt at Olive 8"

  @get_registered_uuid_in_foursquare @sanity @foursquare_e2e
  Scenario: Get a registered place by UUID in Foursquare
    Given I want to update a "place" in sonar
    And the provider name is "Foursquare"
    And I perform a request with the provider id "4b7755f5f964a5200f932ee3" to update the place
    And I get a "200 OK" response status code
    And the response is a JSON object
    And the response has an "id" property
    And the "id" property is a "string" type
    When I want to get a registered place in 'Sonar' by UUID
    And I perform a request with the UUID to get the place's information
    Then I get a "200 OK" response status code
    And the response is a JSON object
    And the response has a "name" property
    And the "name" property's value is "Waikiki Beach Marriott Resort & Spa"

  @get_registered_place_wrong_uuid
  Scenario: Attempt to get a place in Facebook with a wrong UUID
    Given I want to update a "place" in sonar
    And the provider name is "Facebook"
    And I perform a request with the provider id "100473940700" to update the place
    And I get a "200 OK" response status code
    And the response is a JSON object
    And the response has an "id" property
    And the "id" property is a "string" type
    When I want to get a registered place in 'Sonar' by UUID
    And I perform a request without specifying the UUID
    Then I get a "404 Not Found" response status code
    And the response is a JSON object
    And the error message returned should contain the message "No route found"