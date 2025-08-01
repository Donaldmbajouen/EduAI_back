# Documentation API - Système de Suggestions de Cours

## Vue d'ensemble

Le système de suggestions permet aux utilisateurs de proposer de nouveaux cours qui n'existent pas encore sur la plateforme. Il inclut :

- **Proposer un cours** : Les utilisateurs peuvent suggérer de nouveaux cours
- **Voter** : Les utilisateurs peuvent voter pour/contre les suggestions
- **Statuts** : Gestion des suggestions (pending, approved, rejected, implemented)
- **Justification** : Les utilisateurs expliquent pourquoi le cours est nécessaire
- **Notes admin** : Les administrateurs peuvent ajouter des commentaires

## Structure des données

### Modèle CourseSuggestion
```json
{
  "id": 1,
  "user_id": 1,
  "title": "Développement avec Vue.js 3",
  "description": "Apprenez Vue.js 3 avec la Composition API...",
  "level": "intermediate",
  "category_id": 1,
  "justification": "Vue.js 3 est très populaire et il manque un cours complet...",
  "status": "pending",
  "votes_count": 15,
  "admin_notes": null,
  "approved_at": null,
  "implemented_at": null,
  "created_at": "2024-01-01T09:00:00.000000Z",
  "updated_at": "2024-01-01T09:00:00.000000Z"
}
```

### Modèle SuggestionVote
```json
{
  "id": 1,
  "user_id": 1,
  "course_suggestion_id": 1,
  "vote_type": "up",
  "created_at": "2024-01-01T10:00:00.000000Z",
  "updated_at": "2024-01-01T10:00:00.000000Z"
}
```

## Endpoints disponibles

### 1. Lister toutes les suggestions

**GET** `/api/course-suggestions`

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
            "title": "Développement avec Vue.js 3",
            "description": "Apprenez Vue.js 3 avec la Composition API...",
            "level": "intermediate",
            "category_id": 1,
            "justification": "Vue.js 3 est très populaire...",
            "status": "pending",
            "votes_count": 15,
            "admin_notes": null,
            "approved_at": null,
            "implemented_at": null,
            "created_at": "2024-01-01T09:00:00.000000Z",
            "updated_at": "2024-01-01T09:00:00.000000Z",
            "user": {
                "id": 1,
                "name": "John Doe",
                "email": "john@example.com"
            },
            "category": {
                "id": 1,
                "name": "Développement Web"
            },
            "votes": [
                {
                    "id": 1,
                    "user_id": 1,
                    "vote_type": "up",
                    "created_at": "2024-01-01T10:00:00.000000Z"
                }
            ]
        }
    ]
}
```

### 2. Créer une nouvelle suggestion

**POST** `/api/course-suggestions`

**Headers:**
```
Content-Type: application/json
Accept: application/json
```

**Body (JSON):**
```json
{
    "user_id": 1,
    "title": "Nouveau cours sur Laravel",
    "description": "Cours complet sur Laravel 10 avec les nouvelles fonctionnalités.",
    "level": "intermediate",
    "category_id": 1,
    "justification": "Laravel est très populaire et il manque un cours à jour."
}
```

**Réponse:**
```json
{
    "success": true,
    "message": "Suggestion de cours créée avec succès.",
    "data": {
        "id": 2,
        "user_id": 1,
        "title": "Nouveau cours sur Laravel",
        "description": "Cours complet sur Laravel 10 avec les nouvelles fonctionnalités.",
        "level": "intermediate",
        "category_id": 1,
        "justification": "Laravel est très populaire et il manque un cours à jour.",
        "status": "pending",
        "votes_count": 0,
        "admin_notes": null,
        "approved_at": null,
        "implemented_at": null,
        "created_at": "2024-01-01T11:00:00.000000Z",
        "updated_at": "2024-01-01T11:00:00.000000Z",
        "user": {
            "id": 1,
            "name": "John Doe",
            "email": "john@example.com"
        },
        "category": {
            "id": 1,
            "name": "Développement Web"
        }
    }
}
```

### 3. Obtenir une suggestion spécifique

**GET** `/api/course-suggestions/{id}`

**Headers:**
```
Accept: application/json
```

**Réponse:**
```json
{
    "success": true,
    "data": {
        "id": 1,
        "user_id": 1,
        "title": "Développement avec Vue.js 3",
        "description": "Apprenez Vue.js 3 avec la Composition API...",
        "level": "intermediate",
        "category_id": 1,
        "justification": "Vue.js 3 est très populaire...",
        "status": "pending",
        "votes_count": 15,
        "admin_notes": null,
        "approved_at": null,
        "implemented_at": null,
        "created_at": "2024-01-01T09:00:00.000000Z",
        "updated_at": "2024-01-01T09:00:00.000000Z",
        "user": {
            "id": 1,
            "name": "John Doe",
            "email": "john@example.com"
        },
        "category": {
            "id": 1,
            "name": "Développement Web"
        },
        "votes": [
            {
                "id": 1,
                "user_id": 1,
                "vote_type": "up",
                "created_at": "2024-01-01T10:00:00.000000Z"
            }
        ]
    }
}
```

### 4. Voter pour une suggestion

**POST** `/api/course-suggestions/{id}/vote`

**Headers:**
```
Content-Type: application/json
Accept: application/json
```

**Body (JSON):**
```json
{
    "user_id": 1,
    "vote_type": "up"
}
```

**Réponse:**
```json
{
    "success": true,
    "message": "Vote enregistré avec succès.",
    "data": {
        "id": 1,
        "user_id": 1,
        "title": "Développement avec Vue.js 3",
        "description": "Apprenez Vue.js 3 avec la Composition API...",
        "level": "intermediate",
        "category_id": 1,
        "justification": "Vue.js 3 est très populaire...",
        "status": "pending",
        "votes_count": 16,
        "user": {
            "id": 1,
            "name": "John Doe",
            "email": "john@example.com"
        },
        "category": {
            "id": 1,
            "name": "Développement Web"
        }
    }
}
```

### 5. Obtenir les suggestions populaires

**GET** `/api/course-suggestions/popular`

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
            "id": 3,
            "user_id": 1,
            "title": "DevOps avec Docker et Kubernetes",
            "description": "Maîtrisez Docker, Kubernetes et les pratiques DevOps modernes.",
            "level": "advanced",
            "category_id": 9,
            "justification": "Les compétences DevOps sont très recherchées sur le marché.",
            "status": "pending",
            "votes_count": 42,
            "user": {
                "id": 1,
                "name": "John Doe",
                "email": "john@example.com"
            },
            "category": {
                "id": 9,
                "name": "DevOps"
            }
        }
    ]
}
```

### 6. Obtenir les suggestions d'un utilisateur

**GET** `/api/users/{userId}/suggestions`

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
            "title": "Développement avec Vue.js 3",
            "description": "Apprenez Vue.js 3 avec la Composition API...",
            "level": "intermediate",
            "category_id": 1,
            "justification": "Vue.js 3 est très populaire...",
            "status": "pending",
            "votes_count": 15,
            "category": {
                "id": 1,
                "name": "Développement Web"
            }
        }
    ]
}
```

### 7. Obtenir les suggestions par statut (admin)

**GET** `/api/course-suggestions/status/{status}`

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
            "id": 2,
            "user_id": 1,
            "title": "Machine Learning pour Débutants",
            "description": "Introduction au machine learning avec Python...",
            "level": "beginner",
            "category_id": 6,
            "justification": "L'IA est un domaine en pleine expansion...",
            "status": "approved",
            "votes_count": 28,
            "approved_at": "2024-01-01T05:00:00.000000Z",
            "user": {
                "id": 1,
                "name": "John Doe",
                "email": "john@example.com"
            },
            "category": {
                "id": 6,
                "name": "Intelligence Artificielle"
            }
        }
    ]
}
```

### 8. Mettre à jour une suggestion (admin)

**PUT** `/api/course-suggestions/{id}`

**Headers:**
```
Content-Type: application/json
Accept: application/json
```

**Body (JSON):**
```json
{
    "status": "approved",
    "admin_notes": "Excellente suggestion, nous allons créer ce cours."
}
```

**Réponse:**
```json
{
    "success": true,
    "message": "Suggestion mise à jour avec succès.",
    "data": {
        "id": 1,
        "user_id": 1,
        "title": "Développement avec Vue.js 3",
        "description": "Apprenez Vue.js 3 avec la Composition API...",
        "level": "intermediate",
        "category_id": 1,
        "justification": "Vue.js 3 est très populaire...",
        "status": "approved",
        "votes_count": 15,
        "admin_notes": "Excellente suggestion, nous allons créer ce cours.",
        "approved_at": "2024-01-01T12:00:00.000000Z",
        "implemented_at": null,
        "user": {
            "id": 1,
            "name": "John Doe",
            "email": "john@example.com"
        },
        "category": {
            "id": 1,
            "name": "Développement Web"
        }
    }
}
```

### 9. Supprimer une suggestion

**DELETE** `/api/course-suggestions/{id}`

**Headers:**
```
Accept: application/json
```

**Réponse:**
```json
{
    "success": true,
    "message": "Suggestion supprimée avec succès."
}
```

## Validation des données

### Règles de validation pour les suggestions :
- **user_id** : Obligatoire, doit exister dans la table users
- **title** : Obligatoire, chaîne de caractères, max 255 caractères
- **description** : Obligatoire, chaîne de caractères, max 1000 caractères
- **level** : Obligatoire, enum (beginner, intermediate, advanced)
- **category_id** : Obligatoire, doit exister dans la table categories
- **justification** : Optionnel, chaîne de caractères, max 1000 caractères

### Règles de validation pour les votes :
- **user_id** : Obligatoire, doit exister dans la table users
- **vote_type** : Obligatoire, enum (up, down)

### Messages d'erreur personnalisés :
```json
{
    "success": false,
    "message": "The given data was invalid.",
    "errors": {
        "title": ["Le titre du cours est obligatoire."],
        "level": ["Le niveau doit être : beginner, intermediate ou advanced."],
        "category_id": ["La catégorie sélectionnée n'existe pas."],
        "vote_type": ["Le type de vote doit être : up ou down."]
    }
}
```

## Codes de statut HTTP

- **200** : Succès (GET, PUT, DELETE)
- **201** : Créé avec succès (POST)
- **404** : Suggestion non trouvée
- **422** : Erreur de validation

## Statuts des suggestions

### Statuts disponibles :
- **pending** : En attente d'examen par l'admin
- **approved** : Approuvée par l'admin
- **rejected** : Rejetée par l'admin
- **implemented** : Le cours a été créé

### Gestion automatique :
- `approved_at` est automatiquement défini quand le statut devient `approved`
- `implemented_at` est automatiquement défini quand le statut devient `implemented`

## Exemples avec cURL

### Créer une suggestion
```bash
curl -X POST http://localhost:8000/api/course-suggestions \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "user_id": 1,
    "title": "Nouveau cours sur Laravel",
    "description": "Cours complet sur Laravel 10 avec les nouvelles fonctionnalités.",
    "level": "intermediate",
    "category_id": 1,
    "justification": "Laravel est très populaire et il manque un cours à jour."
  }'
```

### Voter pour une suggestion
```bash
curl -X POST http://localhost:8000/api/course-suggestions/1/vote \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "user_id": 1,
    "vote_type": "up"
  }'
```

### Obtenir les suggestions populaires
```bash
curl -X GET http://localhost:8000/api/course-suggestions/popular \
  -H "Accept: application/json"
```

### Approuver une suggestion (admin)
```bash
curl -X PUT http://localhost:8000/api/course-suggestions/1 \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "status": "approved",
    "admin_notes": "Excellente suggestion, nous allons créer ce cours."
  }'
```

## Routes disponibles

| Méthode | URL | Description |
|---------|-----|-------------|
| GET | `/api/course-suggestions` | Lister toutes les suggestions |
| POST | `/api/course-suggestions` | Créer une nouvelle suggestion |
| GET | `/api/course-suggestions/{id}` | Obtenir une suggestion spécifique |
| PUT | `/api/course-suggestions/{id}` | Mettre à jour une suggestion (admin) |
| DELETE | `/api/course-suggestions/{id}` | Supprimer une suggestion |
| POST | `/api/course-suggestions/{id}/vote` | Voter pour une suggestion |
| GET | `/api/course-suggestions/popular` | Suggestions populaires |
| GET | `/api/users/{userId}/suggestions` | Suggestions d'un utilisateur |
| GET | `/api/course-suggestions/status/{status}` | Suggestions par statut |

## Fonctionnalités spéciales

### Système de vote intelligent
- Un utilisateur ne peut voter qu'une fois par suggestion
- Voter à nouveau avec le même type annule le vote
- Voter avec un type différent change le vote
- Compteur de votes mis à jour automatiquement

### Gestion des statuts
- **pending** : En attente d'examen
- **approved** : Approuvée, prête à être implémentée
- **rejected** : Rejetée avec justification
- **implemented** : Le cours a été créé

### Notes administratives
- Les admins peuvent ajouter des notes privées
- Notes visibles seulement pour les admins
- Historique des décisions administratives

### Tri automatique
- Suggestions triées par popularité (votes_count)
- Filtrage par statut pour les admins
- Suggestions d'un utilisateur spécifique

### Relations automatiques
- Chargement automatique des données utilisateur et catégorie
- Votes inclus dans les réponses détaillées
- Optimisation des requêtes avec des index 
