@regression
Feature: Get places in Sonar by provider id
  In order to get a registered place from a provider
  As a Sonar user
  I want to get the place information using the provider id

  @get_place_in_facebook @sanity @facebook_e2e
  Scenario: Get a registered place in Facebook
    Given I want to find a "place"
    And the provider name is "Facebook"
    When I perform a request with the provider id "100473940700" to get the place's information
    Then I get a "200 OK" response status code
    And the response is a JSON object
    And the response has an "provider_name" property
    And the "provider_name" property is a "string" type
    And the "provider_name" property's value is "facebook"
    And the response has an "name" property
    And the "name" property is a "string" type
    And the "name" property's value is "Hyatt at Olive 8"

  @get_place_in_foursquare @sanity @foursquare_e2e
  Scenario: Get a registered place in Foursquare
    Given I want to find a "place"
    And the provider name is "Foursquare"
    When I perform a request with the provider id "4b7755f5f964a5200f932ee3" to get the place's information
    Then I get a "200 OK" response status code
    And the response is a JSON object
    And the response has an "provider_name" property
    And the "provider_name" property is a "string" type
    And the "provider_name" property's value is "foursquare"
    And the "name" property is a "string" type
    And the "name" property's value is "Waikiki Beach Marriott Resort & Spa"

  @get_place_in_twitter
  Scenario: Attempt to get a registered place in Twitter
    Given I want to find a "place"
    And the provider name is "twitter"
    When I perform a request with the provider id "4534asg43sfa3425566dsftt" to get the place's information
    Then I get a "404 Not Found" response status code
    And the response is a JSON object
    And the error message returned should be "Unknown provider with name: twitter"