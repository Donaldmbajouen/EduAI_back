# 🎓 EduAI - Documentation Complète

## 📋 Table des Matières

1. [Vue d'ensemble](#vue-densemble)
2. [Architecture du Projet](#architecture-du-projet)
3. [Installation et Configuration](#installation-et-configuration)
4. [Structure de la Base de Données](#structure-de-la-base-de-données)
5. [API Documentation](#api-documentation)
6. [Fonctionnalités](#fonctionnalités)
7. [Services et Utilitaires](#services-et-utilitaires)
8. [Sécurité et Authentification](#sécurité-et-authentification)
9. [Tests et Qualité](#tests-et-qualité)
10. [Déploiement](#déploiement)
11. [Maintenance et Support](#maintenance-et-support)
12. [Changelog](#changelog)

---

## 🎯 Vue d'ensemble

### Description du Projet

**EduAI** est une plateforme d'apprentissage en ligne moderne construite avec Laravel 10. Elle offre un système complet de gestion de cours, leçons, exercices et suivi de progression des utilisateurs.

### Objectifs Principaux

- ✅ **Gestion complète des utilisateurs** avec avatars et profils
- ✅ **Système de catégories** pour organiser les cours
- ✅ **Création et gestion de cours** avec ressources dynamiques
- ✅ **Leçons générées par IA** avec contenu riche
- ✅ **Système d'exercices** (quiz et exercices pratiques)
- ✅ **Suivi de progression** personnalisé par utilisateur
- ✅ **Boîte à suggestions** pour les nouveaux cours
- ✅ **Évaluation de niveau** au début des cours
- ✅ **Statistiques admin** complètes
- ✅ **API RESTful** complète

### Technologies Utilisées

- **Backend** : Laravel 10 (PHP 8.1+)
- **Base de données** : MySQL/PostgreSQL
- **Authentification** : Laravel Sanctum
- **Upload de fichiers** : Laravel Storage
- **API** : RESTful avec JSON
- **Documentation** : Markdown avec exemples cURL/JavaScript

---

## 🏗️ Architecture du Projet

### Structure des Dossiers

```
EduAI/
├── app/
│   ├── Http/
│   │   ├── Controllers/          # Contrôleurs API
│   │   ├── Requests/             # Validation des données
│   │   └── Middleware/           # Middleware personnalisés
│   ├── Models/                   # Modèles Eloquent
│   ├── Services/                 # Services métier
│   └── Providers/                # Providers Laravel
├── database/
│   ├── migrations/               # Migrations de base de données
│   ├── seeders/                  # Seeders pour les données de test
│   └── factories/                # Factories pour les tests
├── routes/
│   └── api.php                   # Routes API
├── config/                       # Configuration Laravel
├── storage/                      # Fichiers uploadés
├── public/                       # Fichiers publics
└── tests/                        # Tests automatisés
```

### Modèles de Données

#### **User** (Utilisateur)
- Gestion des profils avec avatars
- Relations avec tous les modules
- Authentification via Sanctum

#### **Categorie** (Catégorie)
- Organisation des cours
- Relations avec cours et suggestions

#### **Course** (Cours)
- Contenu principal de la plateforme
- Ressources dynamiques
- Métadonnées (rating, vues, etc.)

#### **Lesson** (Leçon)
- Contenu détaillé des cours
- Génération par IA
- Ordre et progression

#### **Exercise** (Exercice)
- Quiz et exercices pratiques
- Questions et réponses multiples
- Système de scoring

#### **UserProgress** (Progression)
- Suivi de progression par utilisateur
- États de complétion
- Favoris et notes

#### **CourseSuggestion** (Suggestion)
- Boîte à suggestions
- Système de votes
- Workflow d'approbation

#### **UserExerciseAttempt** (Tentative)
- Historique des tentatives
- Scores et résultats
- Temps de réalisation

---

## ⚙️ Installation et Configuration

### Prérequis

- **PHP** : 8.1 ou supérieur
- **Composer** : Dernière version
- **MySQL** : 5.7+ ou PostgreSQL 10+
- **Node.js** : 16+ (pour Vite)
- **Git** : Pour le versioning

### Installation

```bash
# 1. Cloner le projet
git clone https://github.com/votre-repo/EduAI.git
cd EduAI

# 2. Installer les dépendances PHP
composer install

# 3. Installer les dépendances Node.js
npm install

# 4. Copier le fichier d'environnement
cp .env.example .env

# 5. Générer la clé d'application
php artisan key:generate

# 6. Configurer la base de données dans .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=eduai
DB_USERNAME=root
DB_PASSWORD=

# 7. Exécuter les migrations
php artisan migrate

# 8. Créer le lien symbolique pour le stockage
php artisan storage:link

# 9. Peupler la base avec les données de test
php artisan db:seed

# 10. Compiler les assets
npm run build
```

### Configuration

#### Variables d'Environnement Importantes

```env
# Application
APP_NAME=EduAI
APP_ENV=production
APP_DEBUG=false
APP_URL=http://localhost:8000

# Base de données
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=eduai
DB_USERNAME=root
DB_PASSWORD=

# Upload de fichiers
FILESYSTEM_DISK=public
UPLOAD_MAX_FILESIZE=10M

# Cache et sessions
CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync
```

#### Configuration Upload

```php
// config/upload.php
return [
    'avatar' => [
        'path' => 'avatars',
        'max_size' => 2048, // 2MB
        'allowed_types' => ['jpg', 'jpeg', 'png', 'gif'],
        'dimensions' => [
            'width' => 300,
            'height' => 300
        ]
    ],
    'thumbnail' => [
        'path' => 'thumbnails',
        'max_size' => 5120, // 5MB
        'allowed_types' => ['jpg', 'jpeg', 'png'],
        'dimensions' => [
            'width' => 800,
            'height' => 600
        ]
    ]
];
```

---

## 🗄️ Structure de la Base de Données

### Tables Principales

#### **users**
```sql
- id (bigint, primary key)
- name (string)
- email (string, unique)
- password (string, hashed)
- avatar (string, nullable)
- active (boolean, default: true)
- created_at, updated_at
```

#### **categories**
```sql
- id (bigint, primary key)
- name (string)
- description (text, nullable)
- created_at, updated_at
```

#### **courses**
```sql
- id (bigint, primary key)
- title (string)
- description (text)
- level (enum: beginner, intermediate, advanced)
- category_id (foreign key)
- user_id (foreign key)
- is_published (boolean)
- thumbnail (string, nullable)
- rating (decimal, default: 0)
- views_count (integer, default: 0)
- created_at, updated_at
```

#### **lessons**
```sql
- id (bigint, primary key)
- course_id (foreign key)
- title (string)
- content (longtext)
- video_url (string, nullable)
- order (integer)
- difficulty_level (enum)
- objectives (text, nullable)
- prerequisites (text, nullable)
- status (enum: draft, published, archived)
- created_at, updated_at
```

#### **exercises**
```sql
- id (bigint, primary key)
- lesson_id (foreign key)
- title (string)
- description (text)
- type (enum: quiz_single, quiz_multiple)
- difficulty_level (enum)
- points (integer)
- time_limit (integer, nullable)
- is_active (boolean)
- order (integer)
- passing_score (integer, default: 70)
- created_at, updated_at
```

#### **user_progress**
```sql
- id (bigint, primary key)
- user_id (foreign key)
- course_id (foreign key)
- lesson_id (foreign key, nullable)
- status (enum: not_started, in_progress, completed)
- progress_percentage (integer, default: 0)
- is_favorite (boolean, default: false)
- notes (text, nullable)
- started_at (timestamp, nullable)
- completed_at (timestamp, nullable)
- created_at, updated_at
```

#### **course_suggestions**
```sql
- id (bigint, primary key)
- user_id (foreign key)
- title (string)
- description (text)
- level (enum)
- category_id (foreign key)
- justification (text)
- status (enum: pending, approved, rejected, implemented)
- votes_count (integer, default: 0)
- admin_notes (text, nullable)
- approved_at (timestamp, nullable)
- implemented_at (timestamp, nullable)
- created_at, updated_at
```

#### **user_exercise_attempts**
```sql
- id (bigint, primary key)
- user_id (foreign key)
- exercise_id (foreign key)
- score (integer)
- max_score (integer)
- percentage (decimal)
- time_spent (integer, nullable)
- status (enum: started, in_progress, completed, abandoned)
- is_passed (boolean)
- started_at (timestamp)
- completed_at (timestamp, nullable)
- created_at, updated_at
```

### Relations Clés

```php
// User Relations
User -> hasMany(Course)
User -> hasMany(UserProgress)
User -> hasMany(CourseSuggestion)
User -> hasMany(UserExerciseAttempt)

// Course Relations
Course -> belongsTo(Categorie)
Course -> belongsTo(User)
Course -> hasMany(Lesson)
Course -> hasMany(UserProgress)

// Lesson Relations
Lesson -> belongsTo(Course)
Lesson -> hasMany(Exercise)
Lesson -> hasMany(UserProgress)

// Exercise Relations
Exercise -> belongsTo(Lesson)
Exercise -> hasMany(UserExerciseAttempt)
```

---

## 🔌 API Documentation

### Base URL
```
http://localhost:8000/api
```

### Authentification
```bash
# Obtenir un token
curl -X POST "http://localhost:8000/api/auth/login" \
  -H "Content-Type: application/json" \
  -d '{"email": "user@example.com", "password": "password"}'

# Utiliser le token
curl -X GET "http://localhost:8000/api/users" \
  -H "Authorization: Bearer {token}" \
  -H "Accept: application/json"
```

### Endpoints Principaux

#### **Utilisateurs**
```bash
GET    /api/users                    # Liste des utilisateurs
POST   /api/users                    # Créer un utilisateur
GET    /api/users/{id}               # Détails d'un utilisateur
PUT    /api/users/{id}               # Modifier un utilisateur
DELETE /api/users/{id}               # Supprimer un utilisateur
```

#### **Catégories**
```bash
GET    /api/categories               # Liste des catégories
POST   /api/categories               # Créer une catégorie
GET    /api/categories/{id}          # Détails d'une catégorie
PUT    /api/categories/{id}          # Modifier une catégorie
DELETE /api/categories/{id}          # Supprimer une catégorie
```

#### **Cours**
```bash
GET    /api/courses                  # Liste des cours
POST   /api/courses                  # Créer un cours
GET    /api/courses/{id}             # Détails d'un cours
PUT    /api/courses/{id}             # Modifier un cours
DELETE /api/courses/{id}             # Supprimer un cours
GET    /api/users/{userId}/courses   # Cours d'un utilisateur
```

#### **Leçons**
```bash
GET    /api/lessons                  # Liste des leçons
POST   /api/lessons                  # Créer une leçon
GET    /api/lessons/{id}             # Détails d'une leçon
PUT    /api/lessons/{id}             # Modifier une leçon
DELETE /api/lessons/{id}             # Supprimer une leçon
GET    /api/courses/{course}/lessons # Leçons d'un cours
```

#### **Progression**
```bash
GET    /api/user-progress            # Liste des progressions
POST   /api/user-progress            # Créer une progression
GET    /api/user-progress/{id}       # Détails d'une progression
PUT    /api/user-progress/{id}       # Modifier une progression
DELETE /api/user-progress/{id}       # Supprimer une progression
GET    /api/users/{userId}/progress  # Progression d'un utilisateur
```

#### **Exercices**
```bash
GET    /api/exercises                # Liste des exercices
POST   /api/exercises                # Créer un exercice
GET    /api/exercises/{id}           # Détails d'un exercice
PUT    /api/exercises/{id}           # Modifier un exercice
DELETE /api/exercises/{id}           # Supprimer un exercice
POST   /api/exercises/{id}/start     # Commencer un exercice
POST   /api/exercise-attempts/{id}/submit # Soumettre un exercice
```

#### **Suggestions**
```bash
GET    /api/course-suggestions       # Liste des suggestions
POST   /api/course-suggestions       # Créer une suggestion
GET    /api/course-suggestions/{id}  # Détails d'une suggestion
PUT    /api/course-suggestions/{id}  # Modifier une suggestion
DELETE /api/course-suggestions/{id}  # Supprimer une suggestion
POST   /api/course-suggestions/{id}/vote # Voter sur une suggestion
```

#### **Évaluation de Niveau**
```bash
POST   /api/courses/{course}/assessment/start      # Commencer l'évaluation
POST   /api/courses/{course}/assessment/submit     # Soumettre l'évaluation
GET    /api/courses/{course}/assessment/recommendations # Obtenir les recommandations
GET    /api/courses/{course}/assessment/status      # Statut de l'évaluation
```

#### **Statistiques Admin**
```bash
GET    /api/admin/statistics         # Statistiques générales
```

### Exemples d'Utilisation

#### **Créer un utilisateur avec avatar**
```bash
curl -X POST "http://localhost:8000/api/users" \
  -H "Content-Type: application/json" \
  -F "name=John Doe" \
  -F "email=john@example.com" \
  -F "password=password123" \
  -F "avatar=@/path/to/avatar.jpg"
```

#### **Créer un cours avec ressources**
```bash
curl -X POST "http://localhost:8000/api/courses" \
  -H "Content-Type: application/json" \
  -d '{
    "title": "Introduction à Laravel",
    "description": "Apprenez les bases de Laravel",
    "level": "beginner",
    "category_id": 1,
    "user_id": 1,
    "is_published": true,
    "resources": [
      {
        "type": "pdf",
        "title": "Guide Laravel",
        "file": "base64_encoded_file"
      }
    ]
  }'
```

#### **Soumettre une tentative d'exercice**
```bash
curl -X POST "http://localhost:8000/api/exercise-attempts/1/submit" \
  -H "Content-Type: application/json" \
  -d '{
    "answers": [
      {
        "question_id": 1,
        "selected_answers": [1, 2]
      }
    ],
    "time_spent": 300
  }'
```

---

## 🚀 Fonctionnalités

### 1. **Gestion des Utilisateurs**
- ✅ Inscription et authentification
- ✅ Profils avec avatars
- ✅ Gestion des rôles et permissions
- ✅ Historique d'activité

### 2. **Système de Catégories**
- ✅ Organisation hiérarchique
- ✅ Gestion des métadonnées
- ✅ Relations avec cours et suggestions

### 3. **Gestion des Cours**
- ✅ Création et édition de cours
- ✅ Ressources dynamiques (PDF, vidéos, etc.)
- ✅ Système de publication
- ✅ Métadonnées (rating, vues, etc.)
- ✅ Cours par utilisateur

### 4. **Système de Leçons**
- ✅ Contenu riche (HTML, Markdown)
- ✅ Ordre et progression
- ✅ Métadonnées (objectifs, prérequis)
- ✅ Génération par IA (préparé)

### 5. **Système d'Exercices**
- ✅ Quiz à choix unique/multiple
- ✅ Exercices pratiques
- ✅ Système de scoring
- ✅ Feedback après soumission
- ✅ Historique des tentatives

### 6. **Suivi de Progression**
- ✅ Progression par cours/leçon
- ✅ États de complétion
- ✅ Favoris et notes
- ✅ Statistiques personnelles

### 7. **Boîte à Suggestions**
- ✅ Proposition de nouveaux cours
- ✅ Système de votes
- ✅ Workflow d'approbation
- ✅ Intégration avec catégories

### 8. **Évaluation de Niveau**
- ✅ Tests d'évaluation au début des cours
- ✅ Recommandations personnalisées
- ✅ Intégration IA (préparé)
- ✅ Pas de stockage permanent

### 9. **Statistiques Admin**
- ✅ Vue d'ensemble complète
- ✅ Métriques de croissance
- ✅ Performance des cours
- ✅ Engagement des utilisateurs

---

## 🔧 Services et Utilitaires

### **ImageUploadService**
```php
// Gestion centralisée des uploads d'images
class ImageUploadService
{
    public function uploadAvatar($file, $oldAvatar = null)
    public function uploadThumbnail($file, $oldThumbnail = null)
    public function deleteAvatar($filename)
    public function deleteThumbnail($filename)
}
```

### **CourseLevelAssessmentService**
```php
// Service d'évaluation de niveau
class CourseLevelAssessmentService
{
    public function generateAssessment($courseId, $userId)
    public function evaluateLevel($assessmentId, $answers)
    public function generateRecommendations($level)
}
```

### **Form Requests**
- `UserRequest` : Validation des utilisateurs
- `CourseRequest` : Validation des cours
- `LessonRequest` : Validation des leçons
- `ExerciseRequest` : Validation des exercices
- `UserProgressRequest` : Validation de la progression
- `CourseSuggestionRequest` : Validation des suggestions

---

## 🔒 Sécurité et Authentification

### **Laravel Sanctum**
```php
// Configuration dans config/sanctum.php
'stateful' => explode(',', env('SANCTUM_STATEFUL_DOMAINS', sprintf(
    '%s%s',
    'localhost,localhost:3000,127.0.0.1,127.0.0.1:8000,::1',
    env('APP_URL') ? ','.parse_url(env('APP_URL'), PHP_URL_HOST) : ''
))),
```

### **Middleware de Sécurité**
- `auth:sanctum` : Authentification API
- `admin` : Vérification des droits admin
- `CheckResourceState` : Vérification des états des ressources

### **Validation des Données**
```php
// Exemple de validation personnalisée
public function rules()
{
    return [
        'email' => 'required|email|unique:users,email,' . $this->user?->id,
        'avatar' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        'password' => $this->isMethod('PUT') ? 'nullable|min:8' : 'required|min:8',
    ];
}
```

### **Protection CSRF**
- Désactivée pour les API
- Validation des tokens pour les formulaires web

---

## 🧪 Tests et Qualité

### **Tests Unitaires**
```bash
# Exécuter tous les tests
php artisan test

# Tests spécifiques
php artisan test --filter=UserTest
php artisan test --filter=CourseTest
```

### **Tests de Fonctionnalités**
```php
// Exemple de test
public function test_user_can_create_course()
{
    $user = User::factory()->create();
    $category = Categorie::factory()->create();
    
    $response = $this->actingAs($user)
        ->postJson('/api/courses', [
            'title' => 'Test Course',
            'description' => 'Test Description',
            'category_id' => $category->id,
            'level' => 'beginner'
        ]);
    
    $response->assertStatus(201);
    $this->assertDatabaseHas('courses', ['title' => 'Test Course']);
}
```

### **Seeders pour les Tests**
```php
// DatabaseSeeder.php
public function run()
{
    $this->call([
        UserSeeder::class,
        CategorieSeeder::class,
        CourseSeeder::class,
        LessonSeeder::class,
        UserProgressSeeder::class,
        CourseSuggestionSeeder::class,
        ExerciseSeeder::class,
    ]);
}
```

---

## 🚀 Déploiement

### **Environnement de Production**

#### **Configuration Serveur**
```bash
# Nginx configuration
server {
    listen 80;
    server_name eduai.com;
    root /var/www/eduai/public;
    
    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";
    
    index index.php;
    
    charset utf-8;
    
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }
    
    error_page 404 /index.php;
    
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
    
    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

#### **Variables d'Environnement Production**
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://eduai.com

DB_CONNECTION=mysql
DB_HOST=production-db-host
DB_PORT=3306
DB_DATABASE=eduai_prod
DB_USERNAME=prod_user
DB_PASSWORD=secure_password

CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@eduai.com"
MAIL_FROM_NAME="${APP_NAME}"
```

#### **Script de Déploiement**
```bash
#!/bin/bash
# deploy.sh

echo "🚀 Déploiement EduAI..."

# 1. Pull des dernières modifications
git pull origin main

# 2. Installer les dépendances
composer install --no-dev --optimize-autoloader

# 3. Nettoyer le cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# 4. Exécuter les migrations
php artisan migrate --force

# 5. Optimiser l'application
php artisan optimize

# 6. Compiler les assets
npm run build

# 7. Redémarrer les services
sudo systemctl restart nginx
sudo systemctl restart php8.1-fpm

echo "✅ Déploiement terminé!"
```

### **Monitoring et Logs**

#### **Configuration des Logs**
```php
// config/logging.php
'channels' => [
    'stack' => [
        'driver' => 'stack',
        'channels' => ['single', 'daily'],
        'ignore_exceptions' => false,
    ],
    'single' => [
        'driver' => 'single',
        'path' => storage_path('logs/laravel.log'),
        'level' => env('LOG_LEVEL', 'debug'),
    ],
    'daily' => [
        'driver' => 'daily',
        'path' => storage_path('logs/laravel.log'),
        'level' => env('LOG_LEVEL', 'debug'),
        'days' => 14,
    ],
],
```

#### **Monitoring avec Laravel Telescope**
```bash
# Installation
composer require laravel/telescope --dev

# Publication
php artisan telescope:install

# Migration
php artisan migrate
```

---

## 🔧 Maintenance et Support

### **Tâches Planifiées**
```php
// app/Console/Kernel.php
protected function schedule(Schedule $schedule)
{
    // Nettoyage des anciens fichiers
    $schedule->call(function () {
        Storage::delete(Storage::files('temp'));
    })->daily();
    
    // Sauvegarde de la base de données
    $schedule->command('backup:run')->daily();
    
    // Nettoyage des logs
    $schedule->command('log:clear')->weekly();
}
```

### **Commandes Artisan Personnalisées**
```bash
# Nettoyer les avatars orphelins
php artisan eduai:clean-avatars

# Générer des statistiques
php artisan eduai:generate-stats

# Vérifier l'intégrité de la base
php artisan eduai:check-integrity
```

### **Sauvegarde et Restauration**
```bash
# Sauvegarde complète
php artisan backup:run

# Restauration
php artisan backup:restore backup-name
```

### **Optimisation des Performances**
```bash
# Optimiser l'autoloader
composer install --optimize-autoloader --no-dev

# Optimiser l'application
php artisan optimize

# Nettoyer le cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

---

## 📝 Changelog

### **Version 1.0.0** (2024-01-XX)

#### **Nouvelles Fonctionnalités**
- ✅ Système complet de gestion des utilisateurs
- ✅ Gestion des catégories et cours
- ✅ Système de leçons avec contenu riche
- ✅ Exercices et quiz avec scoring
- ✅ Suivi de progression personnalisé
- ✅ Boîte à suggestions avec votes
- ✅ Évaluation de niveau des cours
- ✅ Statistiques admin complètes
- ✅ API RESTful complète
- ✅ Upload et gestion d'images
- ✅ Authentification via Sanctum

#### **Améliorations Techniques**
- ✅ Architecture modulaire et extensible
- ✅ Validation robuste des données
- ✅ Gestion d'erreurs centralisée
- ✅ Documentation complète
- ✅ Tests unitaires et fonctionnels
- ✅ Optimisation des performances
- ✅ Sécurité renforcée

#### **Corrections de Bugs**
- ✅ Gestion des relations entre modèles
- ✅ Validation des uploads de fichiers
- ✅ Calculs de progression
- ✅ Système de scoring des exercices

---

## 📞 Support et Contact

### **Documentation Supplémentaire**
- [API Documentation](API_DOCUMENTATION.md)
- [Course API](COURSE_API_DOCUMENTATION.md)
- [Lesson API](LESSON_API_DOCUMENTATION.md)
- [Exercise API](EXERCISE_API_DOCUMENTATION.md)
- [User Progress API](USER_PROGRESS_API_DOCUMENTATION.md)
- [Course Suggestion API](COURSE_SUGGESTION_API_DOCUMENTATION.md)
- [Course Assessment API](COURSE_ASSESSMENT_API_DOCUMENTATION.md)
- [Admin Statistics API](ADMIN_STATISTICS_DOCUMENTATION.md)

### **Ressources Utiles**
- [Documentation Laravel](https://laravel.com/docs)
- [Laravel Sanctum](https://laravel.com/docs/sanctum)
- [Eloquent ORM](https://laravel.com/docs/eloquent)
- [Laravel Testing](https://laravel.com/docs/testing)

### **Contribution**
1. Fork le projet
2. Créer une branche feature (`git checkout -b feature/AmazingFeature`)
3. Commit les changements (`git commit -m 'Add some AmazingFeature'`)
4. Push vers la branche (`git push origin feature/AmazingFeature`)
5. Ouvrir une Pull Request

---

## 📄 Licence

Ce projet est sous licence MIT. Voir le fichier [LICENSE](LICENSE) pour plus de détails.

---

## 🙏 Remerciements

- **Laravel Team** pour le framework exceptionnel
- **Contributors** pour leurs contributions
- **Community** pour le support et les retours

---

*Cette documentation est maintenue à jour avec chaque version du projet.* 
