# Documentation API - Système de Progression des Utilisateurs

## Vue d'ensemble

Le système de progression permet de suivre l'avancement de chaque utilisateur dans les cours et les leçons. Il inclut :

- **Suivi de progression** : Pourcentage de completion et temps passé
- **Statuts** : Non commencé, en cours, terminé, en pause
- **Favoris** : Cours marqués comme importants
- **Notes personnelles** : Notes prises par l'utilisateur
- **Historique** : Dernière activité et date de completion

## Structure des données

### Modèle UserProgress
```json
{
  "id": 1,
  "user_id": 1,
  "course_id": 1,
  "lesson_id": 2,
  "status": "in_progress",
  "progress_percentage": 75,
  "time_spent": 45,
  "last_accessed_at": "2024-01-01T10:30:00.000000Z",
  "completed_at": null,
  "notes": "Notes personnelles de l'utilisateur",
  "is_favorite": true,
  "created_at": "2024-01-01T09:00:00.000000Z",
  "updated_at": "2024-01-01T10:30:00.000000Z"
}
```

## Endpoints disponibles

### 1. Lister toutes les progressions

**GET** `/api/user-progress`

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
            "course_id": 1,
            "lesson_id": 2,
            "status": "in_progress",
            "progress_percentage": 75,
            "time_spent": 45,
            "last_accessed_at": "2024-01-01T10:30:00.000000Z",
            "completed_at": null,
            "notes": "Notes personnelles",
            "is_favorite": true,
            "created_at": "2024-01-01T09:00:00.000000Z",
            "updated_at": "2024-01-01T10:30:00.000000Z",
            "user": {
                "id": 1,
                "name": "John Doe",
                "email": "john@example.com"
            },
            "course": {
                "id": 1,
                "title": "Introduction au Développement Web",
                "description": "Apprenez les bases du développement web..."
            },
            "lesson": {
                "id": 2,
                "title": "Les bases du CSS",
                "content": "<h2>Introduction au CSS</h2>..."
            }
        }
    ]
}
```

### 2. Créer ou mettre à jour une progression

**POST** `/api/user-progress`

**Headers:**
```
Content-Type: application/json
Accept: application/json
```

**Body (JSON):**
```json
{
    "user_id": 1,
    "course_id": 1,
    "lesson_id": 2,
    "status": "in_progress",
    "progress_percentage": 75,
    "time_spent": 45,
    "notes": "Notes personnelles",
    "is_favorite": true
}
```

**Réponse:**
```json
{
    "success": true,
    "message": "Progression mise à jour avec succès.",
    "data": {
        "id": 1,
        "user_id": 1,
        "course_id": 1,
        "lesson_id": 2,
        "status": "in_progress",
        "progress_percentage": 75,
        "time_spent": 45,
        "notes": "Notes personnelles",
        "is_favorite": true,
        "last_accessed_at": "2024-01-01T10:30:00.000000Z",
        "completed_at": null,
        "created_at": "2024-01-01T09:00:00.000000Z",
        "updated_at": "2024-01-01T10:30:00.000000Z",
        "user": {
            "id": 1,
            "name": "John Doe",
            "email": "john@example.com"
        },
        "course": {
            "id": 1,
            "title": "Introduction au Développement Web"
        },
        "lesson": {
            "id": 2,
            "title": "Les bases du CSS"
        }
    }
}
```

### 3. Obtenir la progression d'un utilisateur spécifique

**GET** `/api/users/{userId}/progress`

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
            "course_id": 1,
            "lesson_id": 2,
            "status": "in_progress",
            "progress_percentage": 75,
            "time_spent": 45,
            "last_accessed_at": "2024-01-01T10:30:00.000000Z",
            "completed_at": null,
            "notes": "Notes personnelles",
            "is_favorite": true,
            "course": {
                "id": 1,
                "title": "Introduction au Développement Web"
            },
            "lesson": {
                "id": 2,
                "title": "Les bases du CSS"
            }
        }
    ]
}
```

### 4. Obtenir les cours en cours d'un utilisateur

**GET** `/api/users/{userId}/progress/in-progress`

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
            "course_id": 1,
            "lesson_id": 2,
            "status": "in_progress",
            "progress_percentage": 75,
            "time_spent": 45,
            "course": {
                "id": 1,
                "title": "Introduction au Développement Web"
            },
            "lesson": {
                "id": 2,
                "title": "Les bases du CSS"
            }
        }
    ]
}
```

### 5. Obtenir les cours terminés d'un utilisateur

**GET** `/api/users/{userId}/progress/completed`

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
            "course_id": 2,
            "lesson_id": null,
            "status": "completed",
            "progress_percentage": 100,
            "time_spent": 120,
            "completed_at": "2024-01-01T15:00:00.000000Z",
            "course": {
                "id": 2,
                "title": "React.js Avancé"
            }
        }
    ]
}
```

### 6. Obtenir les favoris d'un utilisateur

**GET** `/api/users/{userId}/progress/favorites`

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
            "course_id": 1,
            "lesson_id": null,
            "is_favorite": true,
            "course": {
                "id": 1,
                "title": "Introduction au Développement Web"
            }
        }
    ]
}
```

### 7. Mettre à jour la progression d'une leçon

**POST** `/api/users/{userId}/courses/{courseId}/lessons/{lessonId}/progress`

**Headers:**
```
Content-Type: application/json
Accept: application/json
```

**Body (JSON):**
```json
{
    "progress_percentage": 85,
    "time_spent": 15,
    "notes": "Section CSS Grid très intéressante"
}
```

**Réponse:**
```json
{
    "success": true,
    "message": "Progression de la leçon mise à jour.",
    "data": {
        "id": 1,
        "user_id": 1,
        "course_id": 1,
        "lesson_id": 2,
        "status": "in_progress",
        "progress_percentage": 85,
        "time_spent": 60,
        "notes": "Section CSS Grid très intéressante",
        "last_accessed_at": "2024-01-01T11:00:00.000000Z",
        "course": {
            "id": 1,
            "title": "Introduction au Développement Web"
        },
        "lesson": {
            "id": 2,
            "title": "Les bases du CSS"
        }
    }
}
```

### 8. Marquer un cours comme favori

**POST** `/api/users/{userId}/courses/{courseId}/favorite`

**Headers:**
```
Content-Type: application/json
Accept: application/json
```

**Body (JSON):**
```json
{
    "is_favorite": true
}
```

**Réponse:**
```json
{
    "success": true,
    "message": "Cours ajouté aux favoris.",
    "data": {
        "id": 1,
        "user_id": 1,
        "course_id": 1,
        "is_favorite": true,
        "last_accessed_at": "2024-01-01T11:00:00.000000Z",
        "course": {
            "id": 1,
            "title": "Introduction au Développement Web"
        }
    }
}
```

### 9. Mettre à jour une progression spécifique

**PUT** `/api/user-progress/{id}`

**Headers:**
```
Content-Type: application/json
Accept: application/json
```

**Body (JSON):**
```json
{
    "status": "completed",
    "progress_percentage": 100,
    "notes": "Cours terminé avec succès !"
}
```

**Réponse:**
```json
{
    "success": true,
    "message": "Progression mise à jour avec succès.",
    "data": {
        "id": 1,
        "user_id": 1,
        "course_id": 1,
        "lesson_id": 2,
        "status": "completed",
        "progress_percentage": 100,
        "time_spent": 60,
        "notes": "Cours terminé avec succès !",
        "completed_at": "2024-01-01T12:00:00.000000Z",
        "last_accessed_at": "2024-01-01T12:00:00.000000Z"
    }
}
```

### 10. Supprimer une progression

**DELETE** `/api/user-progress/{id}`

**Headers:**
```
Accept: application/json
```

**Réponse:**
```json
{
    "success": true,
    "message": "Progression supprimée avec succès."
}
```

## Validation des données

### Règles de validation :
- **user_id** : Obligatoire, doit exister dans la table users
- **course_id** : Obligatoire, doit exister dans la table courses
- **lesson_id** : Optionnel, doit exister dans la table lessons
- **status** : Optionnel, enum (not_started, in_progress, completed, paused)
- **progress_percentage** : Optionnel, entier, min 0, max 100
- **time_spent** : Optionnel, entier, min 0 (en minutes)
- **notes** : Optionnel, chaîne de caractères, max 1000 caractères
- **is_favorite** : Optionnel, boolean

### Messages d'erreur personnalisés :
```json
{
    "success": false,
    "message": "The given data was invalid.",
    "errors": {
        "user_id": ["L'utilisateur sélectionné n'existe pas."],
        "course_id": ["Le cours sélectionné n'existe pas."],
        "progress_percentage": ["Le pourcentage de progression ne peut pas dépasser 100."],
        "status": ["Le statut doit être : not_started, in_progress, completed ou paused."]
    }
}
```

## Codes de statut HTTP

- **200** : Succès (GET, PUT, DELETE)
- **201** : Créé avec succès (POST)
- **404** : Progression non trouvée
- **422** : Erreur de validation

## Statuts de progression

### Statuts disponibles :
- **not_started** : L'utilisateur n'a pas encore commencé
- **in_progress** : L'utilisateur est en train de suivre le cours/leçon
- **completed** : L'utilisateur a terminé le cours/leçon
- **paused** : L'utilisateur a mis en pause

### Mise à jour automatique :
- Le statut passe automatiquement à `in_progress` quand `progress_percentage > 0`
- Le statut passe automatiquement à `completed` quand `progress_percentage >= 100`
- `completed_at` est automatiquement défini quand le statut devient `completed`

## Exemples avec cURL

### Créer une progression
```bash
curl -X POST http://localhost:8000/api/user-progress \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "user_id": 1,
    "course_id": 1,
    "lesson_id": 2,
    "status": "in_progress",
    "progress_percentage": 75,
    "time_spent": 45,
    "notes": "Notes personnelles",
    "is_favorite": true
  }'
```

### Obtenir la progression d'un utilisateur
```bash
curl -X GET http://localhost:8000/api/users/1/progress \
  -H "Accept: application/json"
```

### Mettre à jour la progression d'une leçon
```bash
curl -X POST http://localhost:8000/api/users/1/courses/1/lessons/2/progress \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "progress_percentage": 85,
    "time_spent": 15,
    "notes": "Section très intéressante"
  }'
```

### Marquer un cours comme favori
```bash
curl -X POST http://localhost:8000/api/users/1/courses/1/favorite \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "is_favorite": true
  }'
```

## Routes disponibles

| Méthode | URL | Description |
|---------|-----|-------------|
| GET | `/api/user-progress` | Lister toutes les progressions |
| POST | `/api/user-progress` | Créer/mettre à jour une progression |
| GET | `/api/user-progress/{id}` | Obtenir une progression spécifique |
| PUT | `/api/user-progress/{id}` | Mettre à jour une progression |
| DELETE | `/api/user-progress/{id}` | Supprimer une progression |
| GET | `/api/users/{userId}/progress` | Progression d'un utilisateur |
| GET | `/api/users/{userId}/progress/in-progress` | Cours en cours d'un utilisateur |
| GET | `/api/users/{userId}/progress/completed` | Cours terminés d'un utilisateur |
| GET | `/api/users/{userId}/progress/favorites` | Favoris d'un utilisateur |
| POST | `/api/users/{userId}/courses/{courseId}/lessons/{lessonId}/progress` | Mettre à jour la progression d'une leçon |
| POST | `/api/users/{userId}/courses/{courseId}/favorite` | Marquer un cours comme favori |

## Fonctionnalités spéciales

### Mise à jour automatique du statut
- Le système met automatiquement à jour le statut selon le pourcentage de progression
- Les dates `last_accessed_at` et `completed_at` sont gérées automatiquement

### Gestion des favoris
- Possibilité de marquer/démarquer des cours comme favoris
- Filtrage facile des cours favoris

### Notes personnelles
- Chaque utilisateur peut ajouter des notes privées
- Notes liées à un cours ou une leçon spécifique

### Suivi du temps
- Temps passé en minutes
- Cumul automatique du temps passé

### Relations automatiques
- Chargement automatique des données utilisateur, cours et leçons
- Optimisation des requêtes avec des index 
