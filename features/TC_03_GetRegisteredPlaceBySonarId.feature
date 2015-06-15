@regression
Feature: Get registered places in Sonar by Sonar place id (UUID)
  In order to get a registered place in Sonar
  As a Sonar user
  I want to get the place information using the Sonar place id (UUID)

  @sanity
  Scenario Outline: Get a registered place by UUID
    Given I want to find a "place"
    When I perform a request with the UUID "UUID" to get the place's information
    Then I get a "200 OK" response status code
    And the response is a JSON object
    And the response has a "provider_name" property
    And the "provider_name" property in the response is the same as "Provider"

    Examples:
    | UUID                                  | Provider    |
    | 99c7e60f-e235-4c34-9761-3cf5747f2b1a  | Facebook    |
    | 07678a57-3b10-4401-bf42-c9d1dc5a77ea  | Foursquare  |


  Scenario: Attempt to get a place with a wrong UUID
    Given I want to find a "place"
    When I perform a request with the UUID "UUID" to get the place's information
    Then I get a "404 Not Found" response status code
    And the response is a JSON object
    And the error message returned should be "Invalid UUID string"