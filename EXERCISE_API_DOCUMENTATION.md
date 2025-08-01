# Documentation API - Système d'Exercices

## Vue d'ensemble

Le système d'exercices permet de créer et gérer des quiz pour chaque leçon. Il inclut :

- **Types de quiz** : quiz_single (une réponse) et quiz_multiple (plusieurs réponses)
- **Évaluation automatique** : Calcul automatique des scores et passage
- **Feedback après soumission** : Résultats détaillés avec explications
- **Score de passage** : 70% par défaut, configurable
- **Historique des tentatives** : Suivi des performances utilisateur
- **Statistiques** : Analyses des performances par exercice

## Structure des données

### Modèle Exercise
```json
{
  "id": 1,
  "lesson_id": 1,
  "title": "Quiz sur les bases de Laravel",
  "description": "Testez vos connaissances sur les fondamentaux de Laravel.",
  "type": "quiz_single",
  "difficulty_level": "easy",
  "points": 0,
  "time_limit": 15,
  "is_active": true,
  "order": 1,
  "passing_score": 70,
  "created_at": "2024-01-01T09:00:00.000000Z",
  "updated_at": "2024-01-01T09:00:00.000000Z"
}
```

### Modèle ExerciseQuestion
```json
{
  "id": 1,
  "exercise_id": 1,
  "question_text": "Qu'est-ce que Laravel ?",
  "question_type": "text",
  "points": 2,
  "order": 1,
  "created_at": "2024-01-01T09:00:00.000000Z",
  "updated_at": "2024-01-01T09:00:00.000000Z"
}
```

### Modèle ExerciseAnswer
```json
{
  "id": 1,
  "question_id": 1,
  "answer_text": "Un framework PHP",
  "is_correct": true,
  "explanation": "Laravel est un framework PHP moderne et élégant.",
  "order": 1,
  "created_at": "2024-01-01T09:00:00.000000Z",
  "updated_at": "2024-01-01T09:00:00.000000Z"
}
```

### Modèle UserExerciseAttempt
```json
{
  "id": 1,
  "user_id": 1,
  "exercise_id": 1,
  "score": 5,
  "max_score": 5,
  "percentage": 100.00,
  "time_spent": 8,
  "status": "completed",
  "is_passed": true,
  "started_at": "2024-01-01T10:00:00.000000Z",
  "completed_at": "2024-01-01T10:08:00.000000Z",
  "created_at": "2024-01-01T10:00:00.000000Z",
  "updated_at": "2024-01-01T10:08:00.000000Z"
}
```

## Endpoints disponibles

### 1. Lister tous les exercices

**GET** `/api/exercises`

**Headers:**
```
Accept: application/json
```

**Réponse:**
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "lesson_id": 1,
            "title": "Quiz sur les bases de Laravel",
            "description": "Testez vos connaissances sur les fondamentaux de Laravel.",
            "type": "quiz_single",
            "difficulty_level": "easy",
            "points": 0,
            "time_limit": 15,
            "is_active": true,
            "order": 1,
            "passing_score": 70,
            "created_at": "2024-01-01T09:00:00.000000Z",
            "updated_at": "2024-01-01T09:00:00.000000Z",
            "lesson": {
                "id": 1,
                "title": "Introduction à Laravel",
                "content": "..."
            },
            "questions": [
                {
                    "id": 1,
                    "question_text": "Qu'est-ce que Laravel ?",
                    "question_type": "text",
                    "points": 2,
                    "order": 1,
                    "answers": [
                        {
                            "id": 1,
                            "answer_text": "Un framework PHP",
                            "is_correct": true,
                            "explanation": "Laravel est un framework PHP moderne et élégant.",
                            "order": 1
                        }
                    ]
                }
            ]
        }
    ]
}
```

### 2. Créer un exercice

**POST** `/api/exercises`

**Headers:**
```
Content-Type: application/json
Accept: application/json
```

**Body (JSON):**
```json
{
    "lesson_id": 1,
    "title": "Quiz sur les bases de Laravel",
    "description": "Testez vos connaissances sur les fondamentaux de Laravel.",
    "type": "quiz_single",
    "difficulty_level": "easy",
    "points": 0,
    "time_limit": 15,
    "is_active": true,
    "order": 1,
    "passing_score": 70,
    "questions": [
        {
            "question_text": "Qu'est-ce que Laravel ?",
            "question_type": "text",
            "points": 2,
            "order": 1,
            "answers": [
                {
                    "answer_text": "Un framework PHP",
                    "is_correct": true,
                    "explanation": "Laravel est un framework PHP moderne et élégant.",
                    "order": 1
                },
                {
                    "answer_text": "Un langage de programmation",
                    "is_correct": false,
                    "explanation": "Laravel est un framework, pas un langage.",
                    "order": 2
                }
            ]
        }
    ]
}
```

**Réponse:**
```json
{
    "success": true,
    "message": "Exercice créé avec succès.",
    "data": {
        "id": 1,
        "lesson_id": 1,
        "title": "Quiz sur les bases de Laravel",
        "description": "Testez vos connaissances sur les fondamentaux de Laravel.",
        "type": "quiz_single",
        "difficulty_level": "easy",
        "points": 0,
        "time_limit": 15,
        "is_active": true,
        "order": 1,
        "passing_score": 70,
        "created_at": "2024-01-01T09:00:00.000000Z",
        "updated_at": "2024-01-01T09:00:00.000000Z",
        "lesson": {
            "id": 1,
            "title": "Introduction à Laravel"
        },
        "questions": [
            {
                "id": 1,
                "question_text": "Qu'est-ce que Laravel ?",
                "question_type": "text",
                "points": 2,
                "order": 1,
                "answers": [
                    {
                        "id": 1,
                        "answer_text": "Un framework PHP",
                        "is_correct": true,
                        "explanation": "Laravel est un framework PHP moderne et élégant.",
                        "order": 1
                    }
                ]
            }
        ]
    }
}
```

### 3. Commencer un exercice

**POST** `/api/exercises/{id}/start`

**Headers:**
```
Content-Type: application/json
Accept: application/json
```

**Body (JSON):**
```json
{
    "user_id": 1
}
```

**Réponse:**
```json
{
    "success": true,
    "message": "Exercice commencé.",
    "data": {
        "id": 1,
        "user_id": 1,
        "exercise_id": 1,
        "score": 0,
        "max_score": 5,
        "percentage": 0.00,
        "time_spent": null,
        "status": "started",
        "is_passed": false,
        "started_at": "2024-01-01T10:00:00.000000Z",
        "completed_at": null,
        "exercise": {
            "id": 1,
            "title": "Quiz sur les bases de Laravel"
        },
        "user": {
            "id": 1,
            "name": "John Doe"
        }
    }
}
```

### 4. Soumettre les réponses

**POST** `/api/exercise-attempts/{id}/submit`

**Headers:**
```
Content-Type: application/json
Accept: application/json
```

**Body (JSON):**
```json
{
    "answers": [
        {
            "question_id": 1,
            "selected_answers": [1]
        },
        {
            "question_id": 2,
            "selected_answers": [4, 5]
        }
    ],
    "time_spent": 8
}
```

**Réponse:**
```json
{
    "success": true,
    "message": "Exercice terminé.",
    "data": {
        "attempt": {
            "id": 1,
            "user_id": 1,
            "exercise_id": 1,
            "score": 5,
            "max_score": 5,
            "percentage": 100.00,
            "time_spent": 8,
            "status": "completed",
            "is_passed": true,
            "started_at": "2024-01-01T10:00:00.000000Z",
            "completed_at": "2024-01-01T10:08:00.000000Z",
            "exercise": {
                "id": 1,
                "title": "Quiz sur les bases de Laravel"
            },
            "user": {
                "id": 1,
                "name": "John Doe"
            }
        },
        "results": {
            "score": 5,
            "max_score": 5,
            "percentage": 100.00,
            "is_passed": true,
            "passing_score": 70
        }
    }
}
```

### 5. Obtenir les résultats détaillés

**GET** `/api/exercise-attempts/{id}/results`

**Headers:**
```
Accept: application/json
```

**Réponse:**
```json
{
    "success": true,
    "data": {
        "attempt": {
            "id": 1,
            "user_id": 1,
            "exercise_id": 1,
            "score": 5,
            "max_score": 5,
            "percentage": 100.00,
            "time_spent": 8,
            "status": "completed",
            "is_passed": true,
            "started_at": "2024-01-01T10:00:00.000000Z",
            "completed_at": "2024-01-01T10:08:00.000000Z",
            "exercise": {
                "id": 1,
                "title": "Quiz sur les bases de Laravel",
                "questions": [
                    {
                        "id": 1,
                        "question_text": "Qu'est-ce que Laravel ?",
                        "answers": [
                            {
                                "id": 1,
                                "answer_text": "Un framework PHP",
                                "is_correct": true
                            }
                        ]
                    }
                ]
            },
            "user": {
                "id": 1,
                "name": "John Doe"
            },
            "user_answers": [
                {
                    "id": 1,
                    "question_id": 1,
                    "selected_answers": [1],
                    "is_correct": true,
                    "points_earned": 2
                }
            ]
        },
        "detailed_results": [
            {
                "question": "Qu'est-ce que Laravel ?",
                "user_answers": [1],
                "correct_answers": [1],
                "is_correct": true,
                "points_earned": 2,
                "max_points": 2,
                "explanation": "Laravel est un framework PHP moderne et élégant."
            }
        ],
        "summary": {
            "score": 5,
            "max_score": 5,
            "percentage": 100.00,
            "is_passed": true,
            "passing_score": 70,
            "time_spent": 8
        }
    }
}
```

### 6. Obtenir les exercices d'une leçon

**GET** `/api/lessons/{id}/exercises`

**Headers:**
```
Accept: application/json
```

**Réponse:**
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "lesson_id": 1,
            "title": "Quiz sur les bases de Laravel",
            "description": "Testez vos connaissances sur les fondamentaux de Laravel.",
            "type": "quiz_single",
            "difficulty_level": "easy",
            "points": 0,
            "time_limit": 15,
            "is_active": true,
            "order": 1,
            "passing_score": 70,
            "questions": [
                {
                    "id": 1,
                    "question_text": "Qu'est-ce que Laravel ?",
                    "question_type": "text",
                    "points": 2,
                    "order": 1,
                    "answers": [
                        {
                            "id": 1,
                            "answer_text": "Un framework PHP",
                            "is_correct": true,
                            "explanation": "Laravel est un framework PHP moderne et élégant.",
                            "order": 1
                        }
                    ]
                }
            ]
        }
    ]
}
```

### 7. Obtenir l'historique des tentatives d'un utilisateur

**GET** `/api/users/{id}/exercise-history`

**Headers:**
```
Accept: application/json
```

**Réponse:**
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "user_id": 1,
            "exercise_id": 1,
            "score": 5,
            "max_score": 5,
            "percentage": 100.00,
            "time_spent": 8,
            "status": "completed",
            "is_passed": true,
            "started_at": "2024-01-01T10:00:00.000000Z",
            "completed_at": "2024-01-01T10:08:00.000000Z",
            "exercise": {
                "id": 1,
                "title": "Quiz sur les bases de Laravel",
                "lesson": {
                    "id": 1,
                    "title": "Introduction à Laravel"
                }
            }
        }
    ]
}
```

### 8. Obtenir les statistiques d'un exercice

**GET** `/api/exercises/{id}/stats`

**Headers:**
```
Accept: application/json
```

**Réponse:**
```json
{
    "success": true,
    "data": {
        "exercise": {
            "id": 1,
            "title": "Quiz sur les bases de Laravel",
            "lesson": {
                "id": 1,
                "title": "Introduction à Laravel"
            }
        },
        "stats": {
            "total_attempts": 25,
            "completed_attempts": 20,
            "passed_attempts": 18,
            "pass_rate": 90.00,
            "average_score": 85.50,
            "average_time": 12.30
        }
    }
}
```

## Validation des données

### Règles de validation pour les exercices :
- **lesson_id** : Obligatoire, doit exister dans la table lessons
- **title** : Obligatoire, chaîne de caractères, max 255 caractères
- **description** : Obligatoire, chaîne de caractères, max 1000 caractères
- **type** : Obligatoire, enum (quiz_single, quiz_multiple)
- **difficulty_level** : Obligatoire, enum (easy, medium, hard)
- **points** : Optionnel, entier, min 0
- **time_limit** : Optionnel, entier, min 1
- **is_active** : Optionnel, booléen
- **order** : Optionnel, entier, min 0
- **passing_score** : Optionnel, entier, min 0, max 100
- **questions** : Obligatoire, tableau, min 1 question
- **questions.*.question_text** : Obligatoire, chaîne de caractères, max 1000
- **questions.*.question_type** : Obligatoire, enum (text, image)
- **questions.*.points** : Obligatoire, entier, min 1
- **questions.*.order** : Obligatoire, entier, min 0
- **questions.*.answers** : Obligatoire, tableau, min 2 réponses
- **questions.*.answers.*.answer_text** : Obligatoire, chaîne de caractères, max 500
- **questions.*.answers.*.is_correct** : Obligatoire, booléen
- **questions.*.answers.*.explanation** : Optionnel, chaîne de caractères, max 1000
- **questions.*.answers.*.order** : Obligatoire, entier, min 0

### Messages d'erreur personnalisés :
```json
{
    "success": false,
    "message": "The given data was invalid.",
    "errors": {
        "lesson_id": ["La leçon est obligatoire."],
        "title": ["Le titre de l'exercice est obligatoire."],
        "type": ["Le type doit être : quiz_single ou quiz_multiple."],
        "difficulty_level": ["Le niveau de difficulté doit être : easy, medium ou hard."],
        "questions": ["Au moins une question est requise."],
        "questions.*.question_text": ["Le texte de la question est obligatoire."],
        "questions.*.answers": ["Au moins deux réponses sont requises."]
    }
}
```

## Codes de statut HTTP

- **200** : Succès (GET, PUT, DELETE)
- **201** : Créé avec succès (POST)
- **404** : Exercice non trouvé
- **422** : Erreur de validation
- **500** : Erreur serveur

## Types d'exercices

### Quiz à réponse unique (quiz_single)
- Une seule réponse correcte par question
- Score binaire : 0 ou points de la question
- Exemple : QCM classique

### Quiz à réponses multiples (quiz_multiple)
- Plusieurs réponses correctes possibles
- Score partiel : points proportionnels
- Exemple : "Sélectionnez tous les frameworks PHP"

## Système de scoring

### Calcul automatique :
```php
$totalScore = 0;
$maxScore = 0;

foreach ($questions as $question) {
    $maxScore += $question->points;
    
    if ($userAnswer->is_correct) {
        $totalScore += $question->points;
    }
}

$percentage = ($totalScore / $maxScore) * 100;
$isPassed = $percentage >= $exercise->passing_score;
```

### Score de passage :
- **70% par défaut** (configurable)
- Calculé automatiquement après soumission
- Détermine si l'exercice est réussi

## Exemples avec cURL

### Créer un exercice
```bash
curl -X POST http://localhost:8000/api/exercises \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "lesson_id": 1,
    "title": "Quiz sur les bases de Laravel",
    "description": "Testez vos connaissances sur les fondamentaux de Laravel.",
    "type": "quiz_single",
    "difficulty_level": "easy",
    "time_limit": 15,
    "passing_score": 70,
    "questions": [
      {
        "question_text": "Qu'\''est-ce que Laravel ?",
        "question_type": "text",
        "points": 2,
        "order": 1,
        "answers": [
          {
            "answer_text": "Un framework PHP",
            "is_correct": true,
            "explanation": "Laravel est un framework PHP moderne et élégant.",
            "order": 1
          },
          {
            "answer_text": "Un langage de programmation",
            "is_correct": false,
            "explanation": "Laravel est un framework, pas un langage.",
            "order": 2
          }
        ]
      }
    ]
  }'
```

### Commencer un exercice
```bash
curl -X POST http://localhost:8000/api/exercises/1/start \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "user_id": 1
  }'
```

### Soumettre les réponses
```bash
curl -X POST http://localhost:8000/api/exercise-attempts/1/submit \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "answers": [
      {
        "question_id": 1,
        "selected_answers": [1]
      }
    ],
    "time_spent": 8
  }'
```

### Obtenir les résultats
```bash
curl -X GET http://localhost:8000/api/exercise-attempts/1/results \
  -H "Accept: application/json"
```

## Routes disponibles

| Méthode | URL | Description |
|---------|-----|-------------|
| GET | `/api/exercises` | Lister tous les exercices |
| POST | `/api/exercises` | Créer un exercice |
| GET | `/api/exercises/{id}` | Obtenir un exercice |
| PUT | `/api/exercises/{id}` | Mettre à jour un exercice |
| DELETE | `/api/exercises/{id}` | Supprimer un exercice |
| GET | `/api/lessons/{id}/exercises` | Exercices d'une leçon |
| GET | `/api/exercises/difficulty/{level}` | Exercices par difficulté |
| GET | `/api/exercises/type/{type}` | Exercices par type |
| POST | `/api/exercises/{id}/start` | Commencer un exercice |
| POST | `/api/exercise-attempts/{id}/submit` | Soumettre les réponses |
| GET | `/api/exercise-attempts/{id}/results` | Résultats détaillés |
| GET | `/api/users/{id}/exercise-history` | Historique utilisateur |
| GET | `/api/users/{id}/exercise-passed` | Tentatives réussies |
| GET | `/api/users/{id}/exercise-failed` | Tentatives échouées |
| GET | `/api/exercises/{id}/stats` | Statistiques d'un exercice |

## Fonctionnalités spéciales

### Évaluation automatique
- Calcul automatique des scores
- Vérification des réponses correctes
- Détermination du passage (70% par défaut)

### Feedback après soumission
- Résultats détaillés par question
- Explications des réponses correctes
- Score et pourcentage de réussite

### Gestion des tentatives
- Une tentative à la fois par utilisateur
- Historique complet des tentatives
- Statistiques de performance

### Types de questions
- **Text** : Questions textuelles
- **Image** : Questions avec images (futur)

### Niveaux de difficulté
- **Easy** : Facile
- **Medium** : Moyen
- **Hard** : Difficile

### Limite de temps
- Optionnelle (nullable)
- En minutes
- Suivi automatique du temps passé

### Relations automatiques
- Chargement automatique des leçons
- Questions et réponses incluses
- Optimisation des requêtes avec des index 
