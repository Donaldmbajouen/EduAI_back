# Documentation API - CRUD des Cours

## Endpoints pour la gestion des cours

### 1. Lister tous les cours

**GET** `/api/courses`

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
            "title": "Introduction au Développement Web",
            "description": "Apprenez les bases du développement web avec HTML, CSS et JavaScript.",
            "level": "beginner",
            "is_published": true,
            "thumbnail": "thumbnails/1234567890_abc123.jpg",
            "thumbnail_url": "http://localhost:8000/storage/thumbnails/1234567890_abc123.jpg",
            "rating": "4.50",
            "views_count": 150,
            "category_id": 1,
            "category": {
                "id": 1,
                "name": "Développement Web",
                "created_at": "2024-01-01T00:00:00.000000Z",
                "updated_at": "2024-01-01T00:00:00.000000Z"
            },
            "created_at": "2024-01-01T00:00:00.000000Z",
            "updated_at": "2024-01-01T00:00:00.000000Z"
        }
    ]
}
```

### 2. Créer un nouveau cours

**POST** `/api/courses`

**Headers:**
```
Content-Type: multipart/form-data
Accept: application/json
```

**Body (form-data):**
```
title: "Nouveau Cours"
description: "Description du nouveau cours"
level: "beginner"
is_published: true
thumbnail: [fichier image] (optionnel)
rating: 4.5 (optionnel)
views_count: 0 (optionnel)
category_id: 1
```

**Réponse:**
```json
{
    "success": true,
    "message": "Cours créé avec succès.",
    "data": {
        "id": 2,
        "title": "Nouveau Cours",
        "description": "Description du nouveau cours",
        "level": "beginner",
        "is_published": true,
        "thumbnail": "thumbnails/1234567890_def456.jpg",
        "thumbnail_url": "http://localhost:8000/storage/thumbnails/1234567890_def456.jpg",
        "rating": "4.50",
        "views_count": 0,
        "category_id": 1,
        "category": {
            "id": 1,
            "name": "Développement Web",
            "created_at": "2024-01-01T00:00:00.000000Z",
            "updated_at": "2024-01-01T00:00:00.000000Z"
        },
        "created_at": "2024-01-01T00:00:00.000000Z",
        "updated_at": "2024-01-01T00:00:00.000000Z"
    }
}
```

### 3. Obtenir un cours spécifique

**GET** `/api/courses/{id}`

**Headers:**
```
Accept: application/json
```

**Note:** Cette requête incrémente automatiquement le compteur de vues.

**Réponse:**
```json
{
    "success": true,
    "data": {
        "id": 1,
        "title": "Introduction au Développement Web",
        "description": "Apprenez les bases du développement web avec HTML, CSS et JavaScript.",
        "level": "beginner",
        "is_published": true,
        "thumbnail": "thumbnails/1234567890_abc123.jpg",
        "thumbnail_url": "http://localhost:8000/storage/thumbnails/1234567890_abc123.jpg",
        "rating": "4.50",
        "views_count": 151,
        "category_id": 1,
        "category": {
            "id": 1,
            "name": "Développement Web",
            "created_at": "2024-01-01T00:00:00.000000Z",
            "updated_at": "2024-01-01T00:00:00.000000Z"
        },
        "created_at": "2024-01-01T00:00:00.000000Z",
        "updated_at": "2024-01-01T00:00:00.000000Z"
    }
}
```

### 4. Mettre à jour un cours

**PUT** `/api/courses/{id}`

**Headers:**
```
Content-Type: multipart/form-data
Accept: application/json
```

**Body (form-data):**
```
title: "Cours Modifié"
description: "Description modifiée"
level: "intermediate"
is_published: true
thumbnail: [fichier image] (optionnel)
rating: 4.8 (optionnel)
views_count: 100 (optionnel)
category_id: 2
```

**Réponse:**
```json
{
    "success": true,
    "message": "Cours mis à jour avec succès.",
    "data": {
        "id": 1,
        "title": "Cours Modifié",
        "description": "Description modifiée",
        "level": "intermediate",
        "is_published": true,
        "thumbnail": "thumbnails/1234567890_ghi789.jpg",
        "thumbnail_url": "http://localhost:8000/storage/thumbnails/1234567890_ghi789.jpg",
        "rating": "4.80",
        "views_count": 100,
        "category_id": 2,
        "category": {
            "id": 2,
            "name": "Développement Mobile",
            "created_at": "2024-01-01T00:00:00.000000Z",
            "updated_at": "2024-01-01T00:00:00.000000Z"
        },
        "created_at": "2024-01-01T00:00:00.000000Z",
        "updated_at": "2024-01-01T00:00:00.000000Z"
    }
}
```

### 5. Supprimer un cours

**DELETE** `/api/courses/{id}`

**Headers:**
```
Accept: application/json
```

**Réponse:**
```json
{
    "success": true,
    "message": "Cours supprimé avec succès."
}
```

## Validation des données

### Règles de validation :
- **title** : Obligatoire, chaîne de caractères, max 255 caractères
- **description** : Obligatoire, chaîne de caractères, max 1000 caractères
- **level** : Obligatoire, enum (beginner, intermediate, advanced)
- **is_published** : Optionnel, boolean
- **thumbnail** : Optionnel, image (jpeg, png, jpg, gif), max 2MB
- **rating** : Optionnel, numérique, min 0, max 5
- **views_count** : Optionnel, entier, min 0
- **category_id** : Obligatoire, doit exister dans la table categories

### Messages d'erreur personnalisés :
```json
{
    "success": false,
    "message": "The given data was invalid.",
    "errors": {
        "title": ["Le titre du cours est obligatoire."],
        "level": ["Le niveau doit être : beginner, intermediate ou advanced."],
        "category_id": ["La catégorie sélectionnée n'existe pas."]
    }
}
```

## Codes de statut HTTP

- **200** : Succès (GET, PUT, DELETE)
- **201** : Créé avec succès (POST)
- **404** : Cours non trouvé
- **422** : Erreur de validation

## Exemples avec cURL

### Créer un cours
```bash
curl -X POST http://localhost:8000/api/courses \
  -H "Accept: application/json" \
  -F "title=Nouveau Cours" \
  -F "description=Description du cours" \
  -F "level=beginner" \
  -F "is_published=true" \
  -F "category_id=1" \
  -F "thumbnail=@/path/to/image.jpg"
```

### Lister tous les cours
```bash
curl -X GET http://localhost:8000/api/courses \
  -H "Accept: application/json"
```

### Mettre à jour un cours
```bash
curl -X PUT http://localhost:8000/api/courses/1 \
  -H "Accept: application/json" \
  -F "title=Cours Modifié" \
  -F "description=Nouvelle description" \
  -F "level=intermediate" \
  -F "category_id=2"
```

### Supprimer un cours
```bash
curl -X DELETE http://localhost:8000/api/courses/1 \
  -H "Accept: application/json"
```

## Routes disponibles

| Méthode | URL | Description |
|---------|-----|-------------|
| GET | `/api/courses` | Lister tous les cours |
| POST | `/api/courses` | Créer un nouveau cours |
| GET | `/api/courses/{id}` | Obtenir un cours spécifique |
| PUT | `/api/courses/{id}` | Mettre à jour un cours |
| DELETE | `/api/courses/{id}` | Supprimer un cours |

## Fonctionnalités spéciales

### Compteur de vues automatique
- Chaque fois qu'un cours est consulté via `GET /api/courses/{id}`, le compteur `views_count` est automatiquement incrémenté.

### Upload d'images
- Les thumbnails sont stockés dans `storage/app/public/thumbnails/`
- URLs accessibles via `http://localhost:8000/storage/thumbnails/`
- Suppression automatique des anciennes images lors de la mise à jour

### Relations
- Chaque cours est lié à une catégorie via `category_id`
- Les données de la catégorie sont incluses dans les réponses 
