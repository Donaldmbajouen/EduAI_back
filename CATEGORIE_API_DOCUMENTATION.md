# Documentation API - CRUD des Catégories

## Endpoints pour la gestion des catégories

### 1. Lister toutes les catégories

**GET** `/api/categories`

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
            "name": "Développement Web",
            "created_at": "2024-01-01T00:00:00.000000Z",
            "updated_at": "2024-01-01T00:00:00.000000Z"
        },
        {
            "id": 2,
            "name": "Développement Mobile",
            "created_at": "2024-01-01T00:00:00.000000Z",
            "updated_at": "2024-01-01T00:00:00.000000Z"
        }
    ]
}
```

### 2. Créer une nouvelle catégorie

**POST** `/api/categories`

**Headers:**
```
Content-Type: application/json
Accept: application/json
```

**Body (JSON):**
```json
{
    "name": "Nouvelle Catégorie"
}
```

**Réponse:**
```json
{
    "success": true,
    "message": "Catégorie créée avec succès.",
    "data": {
        "id": 3,
        "name": "Nouvelle Catégorie",
        "created_at": "2024-01-01T00:00:00.000000Z",
        "updated_at": "2024-01-01T00:00:00.000000Z"
    }
}
```

### 3. Obtenir une catégorie spécifique

**GET** `/api/categories/{id}`

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
        "name": "Développement Web",
        "created_at": "2024-01-01T00:00:00.000000Z",
        "updated_at": "2024-01-01T00:00:00.000000Z"
    }
}
```

### 4. Mettre à jour une catégorie

**PUT** `/api/categories/{id}`

**Headers:**
```
Content-Type: application/json
Accept: application/json
```

**Body (JSON):**
```json
{
    "name": "Catégorie Modifiée"
}
```

**Réponse:**
```json
{
    "success": true,
    "message": "Catégorie mise à jour avec succès.",
    "data": {
        "id": 1,
        "name": "Catégorie Modifiée",
        "created_at": "2024-01-01T00:00:00.000000Z",
        "updated_at": "2024-01-01T00:00:00.000000Z"
    }
}
```

### 5. Supprimer une catégorie

**DELETE** `/api/categories/{id}`

**Headers:**
```
Accept: application/json
```

**Réponse:**
```json
{
    "success": true,
    "message": "Catégorie supprimée avec succès."
}
```

## Validation des données

### Règles de validation pour le nom de catégorie :
- **Obligatoire** : Le nom est requis
- **Type** : Doit être une chaîne de caractères
- **Longueur maximale** : 255 caractères
- **Unicité** : Le nom doit être unique dans la table

### Messages d'erreur personnalisés :
```json
{
    "success": false,
    "message": "The given data was invalid.",
    "errors": {
        "name": [
            "Le nom de la catégorie est obligatoire.",
            "Cette catégorie existe déjà."
        ]
    }
}
```

## Codes de statut HTTP

- **200** : Succès (GET, PUT, DELETE)
- **201** : Créé avec succès (POST)
- **404** : Catégorie non trouvée
- **422** : Erreur de validation

## Exemples avec cURL

### Créer une catégorie
```bash
curl -X POST http://localhost:8000/api/categories \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{"name": "Nouvelle Catégorie"}'
```

### Lister toutes les catégories
```bash
curl -X GET http://localhost:8000/api/categories \
  -H "Accept: application/json"
```

### Mettre à jour une catégorie
```bash
curl -X PUT http://localhost:8000/api/categories/1 \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{"name": "Catégorie Modifiée"}'
```

### Supprimer une catégorie
```bash
curl -X DELETE http://localhost:8000/api/categories/1 \
  -H "Accept: application/json"
```

## Routes disponibles

| Méthode | URL | Description |
|---------|-----|-------------|
| GET | `/api/categories` | Lister toutes les catégories |
| POST | `/api/categories` | Créer une nouvelle catégorie |
| GET | `/api/categories/{id}` | Obtenir une catégorie spécifique |
| PUT | `/api/categories/{id}` | Mettre à jour une catégorie |
| DELETE | `/api/categories/{id}` | Supprimer une catégorie | 
