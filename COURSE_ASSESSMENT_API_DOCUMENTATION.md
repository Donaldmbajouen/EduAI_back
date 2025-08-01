# Documentation API - Tests d'Évaluation de Niveau

## Vue d'ensemble

Le système de tests d'évaluation de niveau permet d'évaluer le niveau de connaissance d'un utilisateur au début d'un cours. Il inclut :

- **Génération dynamique** : Questions basées sur le contenu du cours (IA à venir)
- **Évaluation temporaire** : Pas de stockage en base de données
- **Recommandations personnalisées** : Parcours adapté au niveau détecté
- **Cache intelligent** : Stockage temporaire avec expiration
- **Niveaux détectés** : beginner, intermediate, advanced

## Structure des données

### Test d'évaluation
```json
{
  "assessment_id": "assessment_64f8a1b2c3d4e",
  "course_id": 1,
  "user_id": 1,
  "course_title": "Introduction à Laravel",
  "category": "Développement Web",
  "questions": [
    {
      "id": 1,
      "question": "Qu'est-ce que HTML ?",
      "type": "single_choice",
      "options": [
        {"id": "a", "text": "Un langage de programmation", "correct": false},
        {"id": "b", "text": "Un langage de balisage", "correct": true},
        {"id": "c", "text": "Un framework CSS", "correct": false},
        {"id": "d", "text": "Un protocole réseau", "correct": false}
      ],
      "explanation": "HTML est un langage de balisage utilisé pour structurer le contenu web."
    }
  ],
  "total_questions": 3,
  "expires_at": "2024-01-01T10:30:00.000000Z",
  "created_at": "2024-01-01T10:00:00.000000Z"
}
```

### Résultat d'évaluation
```json
{
  "assessment_id": "assessment_64f8a1b2c3d4e",
  "level": "intermediate",
  "score": {
    "correct": 2,
    "total": 3,
    "incorrect": 1
  },
  "score_percentage": 66.67,
  "recommendations": {
    "level_description": "Niveau intermédiaire détecté",
    "learning_path": "Approfondissez vos connaissances",
    "focus_areas": [
      "Concepts avancés",
      "Bonnes pratiques",
      "Optimisations"
    ],
    "estimated_time": "3-4 heures",
    "suggested_approach": "Concentrez-vous sur les aspects que vous maîtrisez moins."
  },
  "suggested_lessons": {
    "start_from": "Leçon 3",
    "focus_lessons": "Leçons 3-7",
    "skip_lessons": "Leçons 1-2 (trop basiques)",
    "additional_resources": "Bonnes pratiques, patterns avancés"
  },
  "evaluated_at": "2024-01-01T10:15:00.000000Z"
}
```

## Endpoints disponibles

### 1. Commencer un test d'évaluation

**POST** `/api/courses/{id}/assessment/start`

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
    "message": "Test d'évaluation généré avec succès.",
    "data": {
        "assessment_id": "assessment_64f8a1b2c3d4e",
        "course_title": "Introduction à Laravel",
        "category": "Développement Web",
        "total_questions": 3,
        "expires_at": "2024-01-01T10:30:00.000000Z",
        "questions": [
            {
                "id": 1,
                "question": "Qu'est-ce que HTML ?",
                "type": "single_choice",
                "options": [
                    {"id": "a", "text": "Un langage de programmation", "correct": false},
                    {"id": "b", "text": "Un langage de balisage", "correct": true},
                    {"id": "c", "text": "Un framework CSS", "correct": false},
                    {"id": "d", "text": "Un protocole réseau", "correct": false}
                ],
                "explanation": "HTML est un langage de balisage utilisé pour structurer le contenu web."
            },
            {
                "id": 2,
                "question": "Quelle est la différence entre GET et POST ?",
                "type": "multiple_choice",
                "options": [
                    {"id": "a", "text": "GET envoie les données dans l'URL", "correct": true},
                    {"id": "b", "text": "POST envoie les données dans le corps de la requête", "correct": true},
                    {"id": "c", "text": "GET est plus sécurisé que POST", "correct": false},
                    {"id": "d", "text": "POST peut envoyer plus de données", "correct": true}
                ],
                "explanation": "GET et POST sont des méthodes HTTP avec des caractéristiques différentes."
            }
        ]
    }
}
```

### 2. Soumettre les réponses et obtenir l'évaluation

**POST** `/api/courses/{id}/assessment/submit`

**Headers:**
```
Content-Type: application/json
Accept: application/json
```

**Body (JSON):**
```json
{
    "assessment_id": "assessment_64f8a1b2c3d4e",
    "user_id": 1,
    "answers": {
        "1": ["b"],
        "2": ["a", "b", "d"],
        "3": ["a"]
    }
}
```

**Réponse:**
```json
{
    "success": true,
    "message": "Évaluation terminée avec succès.",
    "data": {
        "assessment_id": "assessment_64f8a1b2c3d4e",
        "level": "intermediate",
        "score": {
            "correct": 2,
            "total": 3,
            "incorrect": 1
        },
        "score_percentage": 66.67,
        "recommendations": {
            "level_description": "Niveau intermédiaire détecté",
            "learning_path": "Approfondissez vos connaissances",
            "focus_areas": [
                "Concepts avancés",
                "Bonnes pratiques",
                "Optimisations"
            ],
            "estimated_time": "3-4 heures",
            "suggested_approach": "Concentrez-vous sur les aspects que vous maîtrisez moins."
        },
        "suggested_lessons": {
            "start_from": "Leçon 3",
            "focus_lessons": "Leçons 3-7",
            "skip_lessons": "Leçons 1-2 (trop basiques)",
            "additional_resources": "Bonnes pratiques, patterns avancés"
        },
        "evaluated_at": "2024-01-01T10:15:00.000000Z"
    }
}
```

### 3. Obtenir les recommandations personnalisées

**GET** `/api/courses/{id}/assessment/recommendations`

**Headers:**
```
Accept: application/json
```

**Query Parameters:**
```
assessment_id=assessment_64f8a1b2c3d4e&user_id=1
```

**Réponse:**
```json
{
    "success": true,
    "data": {
        "course": {
            "id": 1,
            "title": "Introduction à Laravel",
            "description": "Apprenez les bases de Laravel..."
        },
        "evaluation": {
            "assessment_id": "assessment_64f8a1b2c3d4e",
            "level": "intermediate",
            "score": {
                "correct": 2,
                "total": 3,
                "incorrect": 1
            },
            "score_percentage": 66.67,
            "recommendations": {
                "level_description": "Niveau intermédiaire détecté",
                "learning_path": "Approfondissez vos connaissances",
                "focus_areas": [
                    "Concepts avancés",
                    "Bonnes pratiques",
                    "Optimisations"
                ],
                "estimated_time": "3-4 heures",
                "suggested_approach": "Concentrez-vous sur les aspects que vous maîtrisez moins."
            },
            "suggested_lessons": {
                "start_from": "Leçon 3",
                "focus_lessons": "Leçons 3-7",
                "skip_lessons": "Leçons 1-2 (trop basiques)",
                "additional_resources": "Bonnes pratiques, patterns avancés"
            },
            "evaluated_at": "2024-01-01T10:15:00.000000Z"
        },
        "personalized_path": {
            "course_id": 1,
            "user_level": "intermediate",
            "recommended_lessons": [3, 4, 5, 6, 7],
            "skip_lessons": [1, 2],
            "focus_areas": [
                "Concepts avancés",
                "Bonnes pratiques"
            ],
            "estimated_completion_time": "3-4 heures"
        }
    }
}
```

### 4. Vérifier le statut d'un test

**GET** `/api/courses/{id}/assessment/status`

**Headers:**
```
Accept: application/json
```

**Query Parameters:**
```
assessment_id=assessment_64f8a1b2c3d4e&user_id=1
```

**Réponse (test en cours):**
```json
{
    "success": true,
    "data": {
        "status": "in_progress",
        "expires_at": "2024-01-01T10:30:00.000000Z",
        "total_questions": 3
    }
}
```

**Réponse (test terminé):**
```json
{
    "success": true,
    "data": {
        "status": "completed",
        "level": "intermediate",
        "score_percentage": 66.67,
        "evaluated_at": "2024-01-01T10:15:00.000000Z"
    }
}
```

**Réponse (test non commencé):**
```json
{
    "success": true,
    "data": {
        "status": "not_started"
    }
}
```

## Validation des données

### Règles de validation pour commencer un test :
- **user_id** : Obligatoire, doit exister dans la table users

### Règles de validation pour soumettre les réponses :
- **assessment_id** : Obligatoire, chaîne de caractères
- **user_id** : Obligatoire, doit exister dans la table users
- **answers** : Obligatoire, tableau
- **answers.*** : Obligatoire, chaîne de caractères

### Messages d'erreur personnalisés :
```json
{
    "success": false,
    "message": "The given data was invalid.",
    "errors": {
        "user_id": ["L'utilisateur est obligatoire."],
        "assessment_id": ["L'identifiant du test est obligatoire."],
        "answers": ["Les réponses sont obligatoires."]
    }
}
```

## Codes de statut HTTP

- **200** : Succès (GET)
- **201** : Créé avec succès (POST)
- **403** : Accès non autorisé
- **404** : Test non trouvé ou expiré
- **422** : Erreur de validation
- **500** : Erreur serveur

## Types de questions

### Questions à choix unique (single_choice)
- Une seule réponse correcte
- Format : `"1": ["b"]`

### Questions à choix multiples (multiple_choice)
- Plusieurs réponses correctes possibles
- Format : `"2": ["a", "b", "d"]`

## Niveaux détectés

### Beginner (0-49%)
- **Description** : Niveau débutant
- **Approche** : Contenu de base, explications détaillées
- **Temps estimé** : 4-6 heures
- **Focus** : Concepts de base, pratique régulière

### Intermediate (50-79%)
- **Description** : Niveau intermédiaire
- **Approche** : Contenu avancé, bonnes pratiques
- **Temps estimé** : 3-4 heures
- **Focus** : Concepts avancés, optimisations

### Advanced (80-100%)
- **Description** : Niveau avancé
- **Approche** : Contenu expert, optimisations
- **Temps estimé** : 2-3 heures
- **Focus** : Architecture avancée, optimisations poussées

## Gestion du cache

### Stockage temporaire :
- **Tests actifs** : 30 minutes
- **Résultats** : 24 heures
- **Pas de persistance** : Aucun stockage en base de données

### Clés de cache :
- `assessment_{assessment_id}` : Test en cours
- `assessment_result_{assessment_id}` : Résultat évalué

## Exemples avec cURL

### Commencer un test
```bash
curl -X POST http://localhost:8000/api/courses/1/assessment/start \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "user_id": 1
  }'
```

### Soumettre les réponses
```bash
curl -X POST http://localhost:8000/api/courses/1/assessment/submit \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "assessment_id": "assessment_64f8a1b2c3d4e",
    "user_id": 1,
    "answers": {
      "1": ["b"],
      "2": ["a", "b", "d"],
      "3": ["a"]
    }
  }'
```

### Obtenir les recommandations
```bash
curl -X GET "http://localhost:8000/api/courses/1/assessment/recommendations?assessment_id=assessment_64f8a1b2c3d4e&user_id=1" \
  -H "Accept: application/json"
```

### Vérifier le statut
```bash
curl -X GET "http://localhost:8000/api/courses/1/assessment/status?assessment_id=assessment_64f8a1b2c3d4e&user_id=1" \
  -H "Accept: application/json"
```

## Routes disponibles

| Méthode | URL | Description |
|---------|-----|-------------|
| POST | `/api/courses/{id}/assessment/start` | Commencer un test d'évaluation |
| POST | `/api/courses/{id}/assessment/submit` | Soumettre les réponses |
| GET | `/api/courses/{id}/assessment/recommendations` | Obtenir les recommandations |
| GET | `/api/courses/{id}/assessment/status` | Vérifier le statut du test |

## Fonctionnalités spéciales

### Génération dynamique (IA à venir)
- **TODO** : L'IA analysera le contenu du cours
- **TODO** : Génération de questions pertinentes
- **TODO** : Évaluation plus précise des réponses

### Évaluation temporaire
- Pas de stockage en base de données
- Cache intelligent avec expiration
- Sécurité et confidentialité

### Recommandations personnalisées
- Parcours adapté au niveau
- Leçons suggérées et à éviter
- Temps d'apprentissage estimé

### Gestion des erreurs
- Tests expirés automatiquement
- Validation des utilisateurs
- Messages d'erreur clairs

### Types de questions supportés
- **Text** : Questions textuelles
- **Single choice** : Une seule réponse
- **Multiple choice** : Plusieurs réponses

### Niveaux de difficulté
- **Beginner** : Débutant (0-49%)
- **Intermediate** : Intermédiaire (50-79%)
- **Advanced** : Avancé (80-100%)

### Relations automatiques
- Chargement automatique des cours
- Questions basées sur la catégorie
- Optimisation des requêtes avec cache 
