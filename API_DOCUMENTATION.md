# Documentation API - Upload d'Images

## Endpoints pour la gestion des utilisateurs avec upload d'images

### 1. Créer un utilisateur avec avatar

**POST** `/api/users`

**Headers:**
```
Content-Type: multipart/form-data
Accept: application/json
```

**Body (form-data):**
```
name: "Doe"
firstname: "John"
email: "john.doe@example.com"
phone: "0123456789"
password: "password123"
avatar: [fichier image] (optionnel)
active: true
```

**Réponse:**
```json
{
    "success": true,
    "message": "Utilisateur créé avec succès.",
    "data": {
        "id": 1,
        "name": "Doe",
        "firstname": "John",
        "email": "john.doe@example.com",
        "phone": "0123456789",
        "avatar": "avatars/1234567890_abc123.jpg",
        "avatar_url": "http://localhost:8000/storage/avatars/1234567890_abc123.jpg",
        "active": true,
        "created_at": "2024-01-01T00:00:00.000000Z",
        "updated_at": "2024-01-01T00:00:00.000000Z"
    }
}
```

### 2. Mettre à jour un utilisateur avec avatar

**PUT** `/api/users/{id}`

**Headers:**
```
Content-Type: multipart/form-data
Accept: application/json
```

**Body (form-data):**
```
name: "Doe"
firstname: "John"
email: "john.doe@example.com"
phone: "0123456789"
password: "newpassword123" (optionnel)
avatar: [fichier image] (optionnel)
active: true
```

### 3. Obtenir un utilisateur

**GET** `/api/users/{id}`

**Réponse:**
```json
{
    "success": true,
    "data": {
        "id": 1,
        "name": "Doe",
        "firstname": "John",
        "email": "john.doe@example.com",
        "phone": "0123456789",
        "avatar": "avatars/1234567890_abc123.jpg",
        "avatar_url": "http://localhost:8000/storage/avatars/1234567890_abc123.jpg",
        "active": true,
        "created_at": "2024-01-01T00:00:00.000000Z",
        "updated_at": "2024-01-01T00:00:00.000000Z"
    }
}
```

## Validation des images

- **Types acceptés:** JPEG, PNG, JPG, GIF
- **Taille maximale:** 2MB
- **Champ:** `avatar` (optionnel)

## Stockage des images

- **Dossier:** `storage/app/public/avatars/`
- **URL publique:** `http://localhost:8000/storage/avatars/`
- **Nom de fichier:** `timestamp_randomstring.extension`

## Exemple avec cURL

```bash
curl -X POST http://localhost:8000/api/users \
  -H "Accept: application/json" \
  -F "name=Doe" \
  -F "firstname=John" \
  -F "email=john.doe@example.com" \
  -F "phone=0123456789" \
  -F "password=password123" \
  -F "avatar=@/path/to/image.jpg" \
  -F "active=true"
``` 
