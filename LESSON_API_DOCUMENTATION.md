# Documentation API - CRUD des Leçons (IA)

## Endpoints pour la gestion des leçons générées par IA

### 1. Lister toutes les leçons

**GET** `/api/lessons`

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
            "course_id": 1,
            "title": "Introduction au HTML",
            "content": "<h2>Qu'est-ce que le HTML ?</h2><p>Le HTML (HyperText Markup Language) est le langage de balisage standard utilisé pour créer des pages web...</p>",
            "video_url": "https://www.youtube.com/watch?v=example1",
            "order": 1,
            "difficulty_level": "easy",
            "objectives": "Comprendre les bases du HTML, créer une première page web simple, maîtriser les éléments de base.",
            "prerequisites": "Aucun prérequis nécessaire.",
            "status": "published",
            "created_at": "2024-01-01T00:00:00.000000Z",
            "updated_at": "2024-01-01T00:00:00.000000Z",
            "course": {
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
                "created_at": "2024-01-01T00:00:00.000000Z",
                "updated_at": "2024-01-01T00:00:00.000000Z"
            }
        }
    ]
}
```

### 2. Créer une nouvelle leçon

**POST** `/api/lessons`

**Headers:**
```
Content-Type: application/json
Accept: application/json
```

**Body (JSON):**
```json
{
    "course_id": 1,
    "title": "Nouvelle Leçon",
    "content": "<h2>Contenu de la leçon</h2><p>Contenu HTML/Markdown généré par l'IA...</p>",
    "video_url": "https://www.youtube.com/watch?v=example",
    "order": 1,
    "difficulty_level": "easy",
    "objectives": "Objectifs d'apprentissage de cette leçon.",
    "prerequisites": "Prérequis pour cette leçon.",
    "status": "draft"
}
```

**Réponse:**
```json
{
    "success": true,
    "message": "Leçon créée avec succès.",
    "data": {
        "id": 2,
        "course_id": 1,
        "title": "Nouvelle Leçon",
        "content": "<h2>Contenu de la leçon</h2><p>Contenu HTML/Markdown généré par l'IA...</p>",
        "video_url": "https://www.youtube.com/watch?v=example",
        "order": 1,
        "difficulty_level": "easy",
        "objectives": "Objectifs d'apprentissage de cette leçon.",
        "prerequisites": "Prérequis pour cette leçon.",
        "status": "draft",
        "created_at": "2024-01-01T00:00:00.000000Z",
        "updated_at": "2024-01-01T00:00:00.000000Z",
        "course": {
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
            "created_at": "2024-01-01T00:00:00.000000Z",
            "updated_at": "2024-01-01T00:00:00.000000Z"
        }
    }
}
```

### 3. Obtenir une leçon spécifique

**GET** `/api/lessons/{id}`

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
        "course_id": 1,
        "title": "Introduction au HTML",
        "content": "<h2>Qu'est-ce que le HTML ?</h2><p>Le HTML (HyperText Markup Language) est le langage de balisage standard utilisé pour créer des pages web...</p>",
        "video_url": "https://www.youtube.com/watch?v=example1",
        "order": 1,
        "difficulty_level": "easy",
        "objectives": "Comprendre les bases du HTML, créer une première page web simple, maîtriser les éléments de base.",
        "prerequisites": "Aucun prérequis nécessaire.",
        "status": "published",
        "created_at": "2024-01-01T00:00:00.000000Z",
        "updated_at": "2024-01-01T00:00:00.000000Z",
        "course": {
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
            "created_at": "2024-01-01T00:00:00.000000Z",
            "updated_at": "2024-01-01T00:00:00.000000Z"
        }
    }
}
```

### 4. Mettre à jour une leçon

**PUT** `/api/lessons/{id}`

**Headers:**
```
Content-Type: application/json
Accept: application/json
```

**Body (JSON):**
```json
{
    "title": "Leçon Modifiée",
    "content": "<h2>Contenu modifié</h2><p>Nouveau contenu généré par l'IA...</p>",
    "video_url": "https://www.youtube.com/watch?v=new-example",
    "order": 2,
    "difficulty_level": "medium",
    "objectives": "Nouveaux objectifs d'apprentissage.",
    "prerequisites": "Nouveaux prérequis.",
    "status": "published"
}
```

**Réponse:**
```json
{
    "success": true,
    "message": "Leçon mise à jour avec succès.",
    "data": {
        "id": 1,
        "course_id": 1,
        "title": "Leçon Modifiée",
        "content": "<h2>Contenu modifié</h2><p>Nouveau contenu généré par l'IA...</p>",
        "video_url": "https://www.youtube.com/watch?v=new-example",
        "order": 2,
        "difficulty_level": "medium",
        "objectives": "Nouveaux objectifs d'apprentissage.",
        "prerequisites": "Nouveaux prérequis.",
        "status": "published",
        "created_at": "2024-01-01T00:00:00.000000Z",
        "updated_at": "2024-01-01T00:00:00.000000Z",
        "course": {
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
            "created_at": "2024-01-01T00:00:00.000000Z",
            "updated_at": "2024-01-01T00:00:00.000000Z"
        }
    }
}
```

### 5. Supprimer une leçon

**DELETE** `/api/lessons/{id}`

**Headers:**
```
Accept: application/json
```

**Réponse:**
```json
{
    "success": true,
    "message": "Leçon supprimée avec succès."
}
```

### 6. Obtenir les leçons d'un cours spécifique

**GET** `/api/courses/{course_id}/lessons`

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
            "course_id": 1,
            "title": "Introduction au HTML",
            "content": "<h2>Qu'est-ce que le HTML ?</h2><p>Le HTML (HyperText Markup Language) est le langage de balisage standard utilisé pour créer des pages web...</p>",
            "video_url": "https://www.youtube.com/watch?v=example1",
            "order": 1,
            "difficulty_level": "easy",
            "objectives": "Comprendre les bases du HTML, créer une première page web simple, maîtriser les éléments de base.",
            "prerequisites": "Aucun prérequis nécessaire.",
            "status": "published",
            "created_at": "2024-01-01T00:00:00.000000Z",
            "updated_at": "2024-01-01T00:00:00.000000Z",
            "course": {
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
                "created_at": "2024-01-01T00:00:00.000000Z",
                "updated_at": "2024-01-01T00:00:00.000000Z"
            }
        }
    ]
}
```

### 7. Obtenir les leçons publiées d'un cours

**GET** `/api/courses/{course_id}/lessons/published`

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
            "course_id": 1,
            "title": "Introduction au HTML",
            "content": "<h2>Qu'est-ce que le HTML ?</h2><p>Le HTML (HyperText Markup Language) est le langage de balisage standard utilisé pour créer des pages web...</p>",
            "video_url": "https://www.youtube.com/watch?v=example1",
            "order": 1,
            "difficulty_level": "easy",
            "objectives": "Comprendre les bases du HTML, créer une première page web simple, maîtriser les éléments de base.",
            "prerequisites": "Aucun prérequis nécessaire.",
            "status": "published",
            "created_at": "2024-01-01T00:00:00.000000Z",
            "updated_at": "2024-01-01T00:00:00.000000Z",
            "course": {
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
                "created_at": "2024-01-01T00:00:00.000000Z",
                "updated_at": "2024-01-01T00:00:00.000000Z"
            }
        }
    ]
}
```

## Validation des données

### Règles de validation :
- **course_id** : Obligatoire, doit exister dans la table courses
- **title** : Obligatoire, chaîne de caractères, max 255 caractères
- **content** : Obligatoire, chaîne de caractères (contenu HTML/Markdown)
- **video_url** : Optionnel, URL valide, max 500 caractères
- **order** : Obligatoire, entier, min 1
- **difficulty_level** : Obligatoire, enum (easy, medium, hard)
- **objectives** : Optionnel, chaîne de caractères, max 1000 caractères
- **prerequisites** : Optionnel, chaîne de caractères, max 1000 caractères
- **status** : Obligatoire, enum (draft, review, published, archived)

### Messages d'erreur personnalisés :
```json
{
    "success": false,
    "message": "The given data was invalid.",
    "errors": {
        "course_id": ["Le cours sélectionné n'existe pas."],
        "title": ["Le titre de la leçon est obligatoire."],
        "difficulty_level": ["Le niveau de difficulté doit être : easy, medium ou hard."],
        "status": ["Le statut doit être : draft, review, published ou archived."]
    }
}
```

## Codes de statut HTTP

- **200** : Succès (GET, PUT, DELETE)
- **201** : Créé avec succès (POST)
- **404** : Leçon non trouvée
- **422** : Erreur de validation

## Exemples avec cURL

### Créer une leçon
```bash
curl -X POST http://localhost:8000/api/lessons \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "course_id": 1,
    "title": "Nouvelle Leçon",
    "content": "<h2>Contenu de la leçon</h2><p>Contenu HTML/Markdown généré par l'\''IA...</p>",
    "video_url": "https://www.youtube.com/watch?v=example",
    "order": 1,
    "difficulty_level": "easy",
    "objectives": "Objectifs d'\''apprentissage de cette leçon.",
    "prerequisites": "Prérequis pour cette leçon.",
    "status": "draft"
  }'
```

### Lister toutes les leçons
```bash
curl -X GET http://localhost:8000/api/lessons \
  -H "Accept: application/json"
```

### Obtenir les leçons d'un cours
```bash
curl -X GET http://localhost:8000/api/courses/1/lessons \
  -H "Accept: application/json"
```

### Obtenir les leçons publiées d'un cours
```bash
curl -X GET http://localhost:8000/api/courses/1/lessons/published \
  -H "Accept: application/json"
```

### Mettre à jour une leçon
```bash
curl -X PUT http://localhost:8000/api/lessons/1 \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "title": "Leçon Modifiée",
    "content": "<h2>Contenu modifié</h2><p>Nouveau contenu généré par l'\''IA...</p>",
    "status": "published"
  }'
```

### Supprimer une leçon
```bash
curl -X DELETE http://localhost:8000/api/lessons/1 \
  -H "Accept: application/json"
```

## Routes disponibles

| Méthode | URL | Description |
|---------|-----|-------------|
| GET | `/api/lessons` | Lister toutes les leçons |
| POST | `/api/lessons` | Créer une nouvelle leçon |
| GET | `/api/lessons/{id}` | Obtenir une leçon spécifique |
| PUT | `/api/lessons/{id}` | Mettre à jour une leçon |
| DELETE | `/api/lessons/{id}` | Supprimer une leçon |
| GET | `/api/courses/{course_id}/lessons` | Obtenir les leçons d'un cours |
| GET | `/api/courses/{course_id}/lessons/published` | Obtenir les leçons publiées d'un cours |

## Fonctionnalités spéciales

### Génération par IA
- Les leçons sont conçues pour être générées par l'IA
- Le contenu peut être en HTML, Markdown ou texte brut
- Support des vidéos via URL YouTube ou autres plateformes

### Gestion des statuts
- **draft** : Brouillon (non visible)
- **review** : En cours de révision
- **published** : Publiée (visible)
- **archived** : Archivée (non visible)

### Niveaux de difficulté
- **easy** : Facile (débutant)
- **medium** : Moyen (intermédiaire)
- **hard** : Difficile (avancé)

### Relations
- Chaque leçon est liée à un cours via `course_id`
- Les données du cours sont incluses dans les réponses
- Tri automatique par ordre (`order`)

### Scopes disponibles
- `published()` : Filtre les leçons publiées
- `ordered()` : Trie par ordre croissant 
