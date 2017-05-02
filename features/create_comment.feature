Feature: As a USER I want to COMMENT a POST

  Background:
    Given those users:
      | id | name        |
      | 1  | Bruce Wayne |
      | 2  | Clark Kent  |

    Given those posts:
      | id | title                         | content                                | author |
      | 1  | La sapete l'ultima su Batman? | Il suo peggior nemico è un pagliaccio! | 2      |

  Scenario: An user comment a post
    When the user 1 comment the post 1:
      | Hahah molto divertente, visto che il tuo è un sasso! BW |
    Then the comment is stored