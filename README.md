# 🎓 EduAI - Plateforme d'Apprentissage Intelligente

[![Laravel](https://img.shields.io/badge/Laravel-10.x-red.svg)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.1+-blue.svg)](https://php.net)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

## 📖 Vue d'ensemble

**EduAI** est une plateforme d'apprentissage en ligne moderne construite avec Laravel 10. Elle offre un système complet de gestion de cours, leçons, exercices et suivi de progression des utilisateurs, avec une architecture prête pour l'intégration d'IA.

## ✨ Fonctionnalités Principales

### 🎯 **Gestion des Utilisateurs**
- ✅ Inscription et authentification sécurisée
- ✅ Profils avec avatars et métadonnées
- ✅ Gestion des rôles et permissions
- ✅ Historique d'activité complet

### 📚 **Système de Cours**
- ✅ Création et gestion de cours avec ressources dynamiques
- ✅ Système de catégories pour l'organisation
- ✅ Leçons générées par IA (préparé)
- ✅ Métadonnées complètes (rating, vues, etc.)

### 🎯 **Exercices et Évaluation**
- ✅ Quiz à choix unique/multiple
- ✅ Exercices pratiques avec feedback
- ✅ Système de scoring avancé
- ✅ Évaluation de niveau au début des cours

### 📊 **Suivi et Analytics**
- ✅ Progression personnalisée par utilisateur
- ✅ Statistiques admin complètes
- ✅ Boîte à suggestions avec votes
- ✅ Dashboard de performance

### 🔌 **API RESTful**
- ✅ API complète et documentée
- ✅ Authentification via Laravel Sanctum
- ✅ Validation robuste des données
- ✅ Gestion d'erreurs centralisée

## 🚀 Installation Rapide

### Prérequis
- PHP 8.1+
- Composer
- MySQL 5.7+ ou PostgreSQL 10+
- Node.js 16+

### Installation

```bash
# 1. Cloner le projet
git clone https://github.com/votre-repo/EduAI.git
cd EduAI

# 2. Installer les dépendances
composer install
npm install

# 3. Configuration
cp .env.example .env
php artisan key:generate

# 4. Configurer la base de données dans .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=eduai
DB_USERNAME=root
DB_PASSWORD=

# 5. Migrations et données de test
php artisan migrate
php artisan storage:link
php artisan db:seed

# 6. Compiler les assets
npm run build

# 7. Démarrer le serveur
php artisan serve
```

Votre application sera disponible sur `http://localhost:8000`

## 📚 Documentation

### 📖 Documentation Complète
- **[Documentation Complète](EDUAI_COMPLETE_DOCUMENTATION.md)** - Guide complet du projet

### 🔌 API Documentation
- **[API Générale](API_DOCUMENTATION.md)** - Vue d'ensemble de l'API
- **[Utilisateurs](API_DOCUMENTATION.md)** - Gestion des utilisateurs
- **[Catégories](CATEGORIE_API_DOCUMENTATION.md)** - Gestion des catégories
- **[Cours](COURSE_API_DOCUMENTATION.md)** - Gestion des cours
- **[Leçons](LESSON_API_DOCUMENTATION.md)** - Gestion des leçons
- **[Exercices](EXERCISE_API_DOCUMENTATION.md)** - Système d'exercices
- **[Progression](USER_PROGRESS_API_DOCUMENTATION.md)** - Suivi de progression
- **[Suggestions](COURSE_SUGGESTION_API_DOCUMENTATION.md)** - Boîte à suggestions
- **[Évaluation](COURSE_ASSESSMENT_API_DOCUMENTATION.md)** - Tests de niveau
- **[Statistiques Admin](ADMIN_STATISTICS_DOCUMENTATION.md)** - Dashboard admin

## 🏗️ Architecture

### Structure du Projet
```
EduAI/
├── app/
│   ├── Http/Controllers/          # Contrôleurs API
│   ├── Models/                    # Modèles Eloquent
│   ├── Services/                  # Services métier
│   └── Http/Requests/             # Validation des données
├── database/
│   ├── migrations/                # Schéma de base de données
│   └── seeders/                   # Données de test
├── routes/api.php                 # Routes API
└── config/                        # Configuration
```

### Modèles Principaux
- **User** - Gestion des utilisateurs et authentification
- **Course** - Cours et contenu principal
- **Lesson** - Leçons détaillées des cours
- **Exercise** - Exercices et quiz
- **UserProgress** - Suivi de progression
- **CourseSuggestion** - Boîte à suggestions
- **Categorie** - Organisation des cours

## 🔌 API Endpoints

### Authentification
```bash
POST /api/auth/login
POST /api/auth/register
POST /api/auth/logout
```

### Utilisateurs
```bash
GET    /api/users
POST   /api/users
GET    /api/users/{id}
PUT    /api/users/{id}
DELETE /api/users/{id}
```

### Cours
```bash
GET    /api/courses
POST   /api/courses
GET    /api/courses/{id}
PUT    /api/courses/{id}
DELETE /api/courses/{id}
```

### Exercices
```bash
GET    /api/exercises
POST   /api/exercises
POST   /api/exercises/{id}/start
POST   /api/exercise-attempts/{id}/submit
```

### Statistiques Admin
```bash
GET    /api/admin/statistics
```

## 🧪 Tests

```bash
# Exécuter tous les tests
php artisan test

# Tests spécifiques
php artisan test --filter=UserTest
php artisan test --filter=CourseTest
```

## 🚀 Déploiement

### Production
```bash
# Optimisation
composer install --no-dev --optimize-autoloader
php artisan optimize
npm run build

# Configuration
APP_ENV=production
APP_DEBUG=false
CACHE_DRIVER=redis
SESSION_DRIVER=redis
```

### Docker (Optionnel)
```bash
docker-compose up -d
```

## 🔧 Configuration

### Variables d'Environnement Importantes
```env
APP_NAME=EduAI
APP_ENV=production
APP_URL=https://votre-domaine.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_DATABASE=eduai
DB_USERNAME=root
DB_PASSWORD=

FILESYSTEM_DISK=public
UPLOAD_MAX_FILESIZE=10M
```

## 📊 Fonctionnalités Avancées

### 🤖 Intégration IA (Préparé)
- Génération automatique de leçons
- Évaluation de niveau intelligente
- Recommandations personnalisées
- Contenu adaptatif

### 📈 Analytics Avancés
- Statistiques en temps réel
- Métriques d'engagement
- Performance des cours
- Tendances utilisateurs

### 🔒 Sécurité
- Authentification JWT via Sanctum
- Validation robuste des données
- Protection CSRF
- Upload sécurisé des fichiers

## 🤝 Contribution

1. Fork le projet
2. Créer une branche feature (`git checkout -b feature/AmazingFeature`)
3. Commit les changements (`git commit -m 'Add some AmazingFeature'`)
4. Push vers la branche (`git push origin feature/AmazingFeature`)
5. Ouvrir une Pull Request

## 📝 Changelog

### Version 1.0.0
- ✅ Système complet de gestion des utilisateurs
- ✅ Gestion des catégories et cours
- ✅ Système de leçons avec contenu riche
- ✅ Exercices et quiz avec scoring
- ✅ Suivi de progression personnalisé
- ✅ Boîte à suggestions avec votes
- ✅ Évaluation de niveau des cours
- ✅ Statistiques admin complètes
- ✅ API RESTful complète

## 📄 Licence

Ce projet est sous licence MIT. Voir le fichier [LICENSE](LICENSE) pour plus de détails.

## 🙏 Remerciements

- **Laravel Team** pour le framework exceptionnel
- **Contributors** pour leurs contributions
- **Community** pour le support et les retours

---

## 📞 Support

- 📖 **[Documentation Complète](EDUAI_COMPLETE_DOCUMENTATION.md)**
- 🐛 **[Issues](https://github.com/votre-repo/EduAI/issues)**
- 💬 **[Discussions](https://github.com/votre-repo/EduAI/discussions)**

---

**EduAI** - Transformez l'apprentissage avec l'intelligence artificielle 🚀
