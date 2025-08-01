# 📊 API Documentation - Statistiques Admin

## Vue d'ensemble

Cette API fournit les statistiques générales les plus importantes pour évaluer l'état de la plateforme EduAI.

## 🔗 Endpoint

### Base URL
```
GET /api/admin/statistics
```

---

## 📈 Statistiques Générales

### Description
Statistiques complètes et essentielles pour l'évaluation de l'application, incluant vue d'ensemble, croissance, engagement, performance et tendances.

### Réponse
```json
{
  "success": true,
  "data": {
    "platform_overview": {
      "total_users": 1250,
      "active_users": 1180,
      "total_courses": 85,
      "published_courses": 72,
      "total_lessons": 420,
      "total_exercises": 1250,
      "total_categories": 12
    },
    "growth_metrics": {
      "new_users_this_month": 45,
      "new_users_this_week": 12,
      "new_courses_this_month": 8,
      "new_lessons_this_month": 35
    },
    "user_engagement": {
      "users_with_progress": 850,
      "total_progress_records": 8500,
      "completed_courses": 3200,
      "total_exercise_attempts": 15000,
      "completed_exercises": 12000,
      "average_course_completion_rate": 37.6
    },
    "course_performance": {
      "total_course_views": 25000,
      "average_course_rating": 4.2,
      "most_viewed_courses": [
        {
          "id": 1,
          "title": "Introduction à Laravel",
          "views_count": 1250,
          "rating": 4.8
        }
      ],
      "highest_rated_courses": [
        {
          "id": 1,
          "title": "Introduction à Laravel",
          "rating": 4.8,
          "views_count": 1250
        }
      ]
    },
    "exercise_performance": {
      "average_success_rate": 78.5,
      "total_exercise_attempts": 15000,
      "successful_attempts": 12000,
      "most_attempted_exercises": [
        {
          "id": 1,
          "title": "Quiz Laravel Basics",
          "attempts_count": 850
        }
      ]
    },
    "suggestions_metrics": {
      "total_suggestions": 45,
      "pending_suggestions": 12,
      "approved_suggestions": 25,
      "implemented_suggestions": 8
    },
    "top_active_users": [
      {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com",
        "progress_count": 25,
        "exercise_attempts_count": 150
      }
    ],
    "top_courses": [
      {
        "id": 1,
        "title": "Introduction à Laravel",
        "enrollments": 450,
        "completions": 320,
        "rating": 4.8,
        "views_count": 1250
      }
    ],
    "recent_trends": {
      "user_registration_trend": [
        {
          "date": "2024-01-01",
          "count": 5
        }
      ],
      "course_creation_trend": [
        {
          "date": "2024-01-01",
          "count": 2
        }
      ],
      "exercise_attempt_trend": [
        {
          "date": "2024-01-01",
          "count": 25
        }
      ]
    }
  }
}
```

---

## 📊 Métriques Clés

### 1. **Vue d'ensemble de la plateforme**
- `total_users` : Nombre total d'utilisateurs
- `active_users` : Utilisateurs actifs
- `total_courses` : Nombre total de cours
- `published_courses` : Cours publiés
- `total_lessons` : Nombre total de leçons
- `total_exercises` : Nombre total d'exercices
- `total_categories` : Nombre de catégories

### 2. **Métriques de croissance**
- `new_users_this_month` : Nouveaux utilisateurs ce mois
- `new_users_this_week` : Nouveaux utilisateurs cette semaine
- `new_courses_this_month` : Nouveaux cours ce mois
- `new_lessons_this_month` : Nouvelles leçons ce mois

### 3. **Engagement des utilisateurs**
- `users_with_progress` : Utilisateurs avec progression
- `total_progress_records` : Total des enregistrements de progression
- `completed_courses` : Cours complétés
- `total_exercise_attempts` : Total des tentatives d'exercices
- `completed_exercises` : Exercices complétés
- `average_course_completion_rate` : Taux de complétion moyen (%)

### 4. **Performance des cours**
- `total_course_views` : Total des vues de cours
- `average_course_rating` : Note moyenne des cours
- `most_viewed_courses` : Cours les plus vus (top 5)
- `highest_rated_courses` : Cours les mieux notés (top 5)

### 5. **Performance des exercices**
- `average_success_rate` : Taux de réussite moyen (%)
- `total_exercise_attempts` : Total des tentatives
- `successful_attempts` : Tentatives réussies
- `most_attempted_exercises` : Exercices les plus tentés (top 5)

### 6. **Métriques des suggestions**
- `total_suggestions` : Total des suggestions
- `pending_suggestions` : Suggestions en attente
- `approved_suggestions` : Suggestions approuvées
- `implemented_suggestions` : Suggestions implémentées

### 7. **Utilisateurs et cours populaires**
- `top_active_users` : Utilisateurs les plus actifs (top 5)
- `top_courses` : Cours les plus populaires (top 5)

### 8. **Tendances récentes**
- `user_registration_trend` : Tendances d'inscription (30 jours)
- `course_creation_trend` : Tendances de création de cours (30 jours)
- `exercise_attempt_trend` : Tendances de tentatives d'exercices (30 jours)

---

## 🔧 Utilisation

### Exemple avec cURL
```bash
curl -X GET "http://localhost:8000/api/admin/statistics" \
  -H "Accept: application/json"
```

### Exemple avec JavaScript
```javascript
async function getAdminStats() {
  try {
    const response = await fetch('/api/admin/statistics', {
      method: 'GET',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
      }
    });
    
    const data = await response.json();
    return data;
  } catch (error) {
    console.error('Erreur lors de la récupération des statistiques:', error);
    throw error;
  }
}

// Utilisation
getAdminStats().then(stats => {
  console.log('Statistiques admin:', stats);
  
  // Exemples d'utilisation des données
  console.log('Total utilisateurs:', stats.data.platform_overview.total_users);
  console.log('Taux de complétion:', stats.data.user_engagement.average_course_completion_rate + '%');
  console.log('Taux de réussite exercices:', stats.data.exercise_performance.average_success_rate + '%');
});
```

---

## 🎯 Cas d'Usage

### Dashboard Admin
```javascript
function updateDashboard(stats) {
  // Mise à jour des compteurs principaux
  document.getElementById('total-users').textContent = stats.platform_overview.total_users;
  document.getElementById('total-courses').textContent = stats.platform_overview.total_courses;
  document.getElementById('completion-rate').textContent = stats.user_engagement.average_course_completion_rate + '%';
  document.getElementById('success-rate').textContent = stats.exercise_performance.average_success_rate + '%';
  
  // Mise à jour des tendances
  updateGrowthChart(stats.growth_metrics);
  updateTrendsChart(stats.recent_trends);
}
```

### Rapports Automatiques
```javascript
function generateReport(stats) {
  const report = {
    date: new Date().toISOString().split('T')[0],
    summary: {
      totalUsers: stats.platform_overview.total_users,
      newUsersThisMonth: stats.growth_metrics.new_users_this_month,
      completionRate: stats.user_engagement.average_course_completion_rate,
      successRate: stats.exercise_performance.average_success_rate,
      averageRating: stats.course_performance.average_course_rating
    },
    topPerformers: {
      users: stats.top_active_users,
      courses: stats.top_courses
    }
  };
  
  return report;
}
```

---

## 🔒 Sécurité

⚠️ **Important** : Cet endpoint est destiné à l'administration et doit être protégé par une authentification appropriée.

### Middleware Recommandé
```php
// Dans routes/api.php
Route::get('admin/statistics', [AdminStatisticsController::class, 'getGeneralStats'])
    ->middleware(['auth:sanctum', 'admin']);
```

---

## 📈 Indicateurs de Performance

### Métriques Clés à Surveiller

1. **Croissance** : `new_users_this_month`, `new_courses_this_month`
2. **Engagement** : `average_course_completion_rate`, `users_with_progress`
3. **Qualité** : `average_course_rating`, `average_success_rate`
4. **Performance** : `total_course_views`, `total_exercise_attempts`
5. **Feedback** : `total_suggestions`, `approved_suggestions`

### Seuils d'Alerte Recommandés

- **Taux de complétion** < 30% → Améliorer l'engagement
- **Taux de réussite** < 70% → Revoir la difficulté des exercices
- **Note moyenne** < 3.5 → Améliorer la qualité des cours
- **Nouveaux utilisateurs** < 10/mois → Améliorer le marketing

---

## 🎯 Conclusion

Cette API de statistiques fournit une vue complète et essentielle de l'état de la plateforme EduAI, permettant aux administrateurs de :

1. **Évaluer** rapidement l'état de la plateforme
2. **Identifier** les tendances de croissance
3. **Mesurer** l'engagement des utilisateurs
4. **Optimiser** les performances
5. **Prendre** des décisions éclairées

Toutes les métriques importantes sont regroupées dans une seule réponse pour faciliter l'intégration dans un dashboard admin. 
