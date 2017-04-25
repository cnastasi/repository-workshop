Feature: As a USER I want to create a post

  Background:
    Given those users:
      | id | name        |
      | 1  | Bruce Wayne |

  Scenario: An user publish a post
    When the user 1 publish a post:
      | title   | This is a title   |
      | content | This is a content |
    Then I can see the post:
      | id      | 1                 |
      | title   | This is a title   |
      | content | This is a content |
      | user_id | 1                 |