Feature: As a USER I want to see all my POSTS

  Background:
    Given those users:
      | id | name        |
      | 1  | Bruce Wayne |
      | 2  | Clark Kent  |

    Given those posts:
      | id | title                         | content                                | author |
      | 1  | La sapete l'ultima su Batman? | Il suo peggior nemico è un pagliaccio! | 2      |

  Scenario: An user requests all his post
    Given I'm the user 2
    When I request all my posts
    Then I see those posts:
      | id | title                         | content                                | user_id |
      | 1  | La sapete l'ultima su Batman? | Il suo peggior nemico è un pagliaccio! | 2       |