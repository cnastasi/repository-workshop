Feature: As a USER I want to see all the COMMENTS of a given POST

  Background:
    Given those users:
      | id | name        |
      | 1  | Bruce Wayne |
      | 2  | Clark Kent  |

    Given those posts:
      | id | title                         | content                                | author |
      | 1  | La sapete l'ultima su Batman? | Il suo peggior nemico è un pagliaccio! | 2      |

    Given those comments:
      | id | content                                                 | post | author |
      | 1  | Hahah molto divertente, visto che il tuo è un sasso! BW | 1    | 1      |

  Scenario: An user request all the comments of a post
    When I request all the comments of the post 1
    Then I see those comments:
      | id | content                                                 | post_id | user_id |
      | 1  | Hahah molto divertente, visto che il tuo è un sasso! BW | 1       | 1       |
