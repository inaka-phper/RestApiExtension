# language : en
#

Feature: REST API TEST 

  Scenario: Test GET Request
    When I set header "Authorization" with "Bearer 12345678"
    When I set parameter "username" with "hanhan1978"
    When I send GET request to "get" 
    Then I should get json response equal to '{"username":"hanhan1978","profile":"PHPer"}'
    Then the response status code should be 200
    Then the response content-type should be "application/json" 

  Scenario: Test GET Request With invalid username format
    When I set header "Authorization" with "Bearer 12345678"
    When I set parameter "username" with "ハンハン"
    When I send GET request to "get" 
    Then I should get json response equal to '{"error_code" : 101, "error_msg": "username should be alpha-numeric"}'
    Then the response status code should be 403 
    Then the response content-type should be "application/json" 

  Scenario: Test POST Request
    When I set header "Authorization" with "Bearer 12345678"
    When I set parameter "title" with "hanhan"
    When I set parameter "body" with "hanhan"
    When I set array parameter "tag" with "tag1,tag2,tag3"
    When I send POST request to "post" 
    Then I should get json response equal to '{"msg" : "register succeed"}'
    Then the response status code should be 200

  Scenario: Test POST Request Without Authorization Token
    When I set parameter "title" with "hanhan"
    When I set parameter "body" with "hanhan"
    When I set array parameter "tag" with "tag1,tag2,tag3"
    When I send POST request to "post" 
    Then I should get json response equal to '{"error_code" : 201, "error_msg": "authorization token is invalid"}'
    Then the response status code should be 403 

  Scenario: Test POST Request Without Authorization Token
    When I set parameter "title" with "hanhan"
    When I set parameter "body" with "hanhan"
    When I set array parameter "tag" with "tag1,tag2,tag3"
    When I send GET request to "post" 
    Then the response status code should be 405 
