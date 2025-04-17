# Microblogging Platform

Une plateforme de microblogging moderne avec une API RESTful et une interface utilisateur réactive.

## 🚀 Fonctionnalités

- **Authentification** : Inscription, connexion et gestion de profil
- **Posts** : Création, consultation de posts
- **Interactions** : Likes, commentaires et hashtags
- **Réseau social** : Suivi d'autres utilisateurs
- **Interface** : Design responsive et expérience utilisateur optimisée

## 🛠️ Technologies

### Backend (Laravel)
- PHP 8.2+
- Laravel 10
- PostgreSQL
- Sanctum pour l'authentification
- API RESTful

### Frontend (Vue.js)
- Vue 3
- TypeScript
- Vite
- Tailwind CSS
- Vue Router

## 📦 Installation

### Prérequis
- PHP 8.2+
- Composer
- Node.js 18+
- PostgreSQL
- ServBay (pour le développement local)

### Backend

1. Cloner le repository :
```bash
git clone [URL_DU_REPO]
cd backBlog
```

2. Installer les dépendances :
```bash
composer install
```

3. Configurer l'environnement :
```bash
cp .env.example .env
```
Modifier le fichier `.env` avec vos paramètres de base de données.

4. Générer la clé d'application :
```bash
php artisan key:generate
```

5. Exécuter les migrations et les seeders :
```bash
php artisan migrate:fresh --seed
```

6. Démarrer le serveur de développement :
```bash
php artisan serve
```

### Frontend

1. Se déplacer dans le dossier frontend :
```bash
cd frontBlog
```

2. Installer les dépendances :
```bash
npm install
```

3. Démarrer le serveur de développement :
```bash
npm run dev
```

## 🔧 Configuration

### Variables d'environnement

#### Backend (.env)
```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=microblogging
DB_USERNAME=your_username
DB_PASSWORD=your_password

APP_URL=http://localhost:8000
FRONTEND_URL=http://localhost:5173
```

#### Frontend (.env)
```env
VITE_API_URL=http://localhost:8000/api
```

## 📚 Structure du Projet

```
Microblogging/
├── backBlog/                 # Backend Laravel
│   ├── app/
│   │   ├── Http/            # Controllers et Middleware
│   │   ├── Models/          # Modèles Eloquent
│   │   └── Services/        # Services métier
│   ├── database/
│   │   ├── migrations/      # Migrations de base de données
│   │   └── seeders/         # Données de test
│   └── routes/
│       └── api.php          # Routes API
│
└── frontBlog/               # Frontend Vue.js
    ├── src/
    │   ├── components/      # Composants Vue
    │   ├── views/          # Pages
    │   └── services/       # Services API
    └── public/             # Assets statiques
```

## 🔐 Authentification

L'API utilise Laravel Sanctum pour l'authentification. Les tokens sont stockés dans le local storage.

### Endpoints d'authentification
- `POST /api/register` - Inscription
- `POST /api/login` - Connexion
- `POST /api/logout` - Déconnexion

## 📝 API Endpoints

### Posts
- `GET /api/posts` - Liste des posts
- `POST /api/posts` - Créer un post
- `GET /api/posts/{id}` - Détails d'un post
- `PUT /api/posts/{id}` - Mettre à jour un post
- `DELETE /api/posts/{id}` - Supprimer un post

### Utilisateurs
- `GET /api/users` - Liste des utilisateurs
- `GET /api/users/{id}` - Profil utilisateur
- `PUT /api/user` - Mettre à jour son profil

### Interactions
- `POST /api/likes` - Ajouter un like
- `DELETE /api/likes/{id}` - Retirer un like
- `POST /api/comments` - Ajouter un commentaire
- `DELETE /api/comments/{id}` - Supprimer un commentaire
- `POST /api/follows` - Suivre un utilisateur
- `DELETE /api/follows/{id}` - Ne plus suivre un utilisateur

## 🧪 Tests

### Backend
```bash
php artisan test
```

### Frontend
```bash
npm run test
```

## 📦 Déploiement

### Backend
1. Configurer le serveur web (Apache/Nginx)
2. Configurer les variables d'environnement
3. Exécuter les migrations
4. Optimiser l'application :
```bash
php artisan optimize
```

### Frontend
1. Construire l'application :
```bash
npm run build
```
2. Déployer le contenu du dossier `dist` sur votre serveur web

## 🤝 Contribution

1. Fork le projet
2. Créer une branche pour votre fonctionnalité (`git checkout -b feature/AmazingFeature`)
3. Commiter vos changements (`git commit -m 'Add some AmazingFeature'`)
4. Pousser vers la branche (`git push origin feature/AmazingFeature`)
5. Ouvrir une Pull Request

## 📄 Licence

Ce projet est sous licence MIT. Voir le fichier `LICENSE` pour plus de détails.

## 👥 Auteurs

- Théo  
- Alex 
- Tanguy 
- Neelab 

## 🙏 Remerciements

- Laravel
- Vue.js
- La communauté open source 
