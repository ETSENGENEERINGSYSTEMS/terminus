Feature: Accessing the Dashboard
  In order script the opening of Dashboard pages
  As a user
  I need to be able to get the URL of my Dashboard from Terminus

  Background: I am authenticated and have a site named [[test_site_name]]
    Given I am authenticated
    And a site named "[[test_site_name]]"

  @vcr site_dashboard
  Scenario: Printing out the main Dashboard URL
    When I run "terminus dashboard:view --print"
    Then I should get: "https://[[dashboard_host]]/users/[[user_id]]"

  @vcr site_dashboard
  Scenario: Printing out the site Dashboard URL for a specific environment
    When I run "terminus dashboard:view [[test_site_name]].multidev --print"
    Then I should get: "https://[[dashboard_host]]/sites/11111111-1111-1111-1111111111111111#multidev/code"

  Scenario: Opening a Dashboard window automatically
    # We cannot test for it, but `terminus dashboard:view ...` without `--print`
    # should open the Dashboard at the URL it generates.
