Feature: As a USER I want to create a POST

  Background:
    Given those users:
      | id | name        |
      | 1  | Bruce Wayne |

  Scenario: An user publish a post
    When the user 1 publish a post:
      | title   | This is a title   |
      | content | This is a content |
    Then the post is stored