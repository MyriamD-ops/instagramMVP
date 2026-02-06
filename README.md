# Instagram MVP - API Documentation

Clone Instagram développé avec Laravel 11 pour un MVP fonctionnel.

## 🚀 Fonctionnalités

### ✅ Authentification
- Inscription
- Connexion
- Déconnexion
- Authentification via Sanctum (tokens API)

### ✅ Posts
- Créer un post avec image
- Afficher le feed (posts des utilisateurs suivis)
- Afficher les posts d'un utilisateur
- Supprimer un post
- Liker/Unliker un post

### ✅ Commentaires
- Ajouter un commentaire sur un post
- Afficher les commentaires d'un post
- Supprimer un commentaire

### ✅ Follows
- Suivre/Ne plus suivre un utilisateur
- Liste des followers
- Liste des utilisateurs suivis

### ✅ Profil utilisateur
- Afficher un profil
- Modifier son profil
- Photo de profil
- Biographie
- Compte privé

### ✅ Messagerie
- Conversations privées
- Envoyer des messages
- Liste des conversations
- Messages non lus

## 📋 Prérequis

- PHP >= 8.2
- Composer
- MySQL ou SQLite
- Node.js & NPM (pour le frontend)

## 🛠️ Installation

### 1. Cloner le projet
```bash
git clone <url-du-repo>
cd instagramMVP
```

### 2. Installer les dépendances
```bash
composer install
npm install
```

### 3. Configuration
```bash
cp .env.example .env
php artisan key:generate
```

Modifier le fichier `.env` avec vos informations de base de données.

### 4. Créer le lien symbolique pour le storage
```bash
php artisan storage:link
```

### 5. Migrations et seed
```bash
php artisan migrate:fresh --seed
```

### 6. Lancer le serveur
```bash
php artisan serve
```

L'API sera accessible sur `http://localhost:8000/api`

## 📚 Endpoints API

### Authentification

#### Inscription
```http
POST /api/register
Content-Type: application/json

{
  "name": "John Doe",
  "username": "johndoe",
  "email": "john@example.com",
  "password": "password123",
  "password_confirmation": "password123"
}
```

#### Connexion
```http
POST /api/login
Content-Type: application/json

{
  "email": "john@example.com",
  "password": "password123"
}
```

**Réponse:**
```json
{
  "token": "1|abc123...",
  "user": { ... }
}
```

#### Déconnexion
```http
POST /api/logout
Authorization: Bearer {token}
```

#### Utilisateur authentifié
```http
GET /api/user
Authorization: Bearer {token}
```

### Posts

#### Feed (posts des utilisateurs suivis)
```http
GET /api/feed
Authorization: Bearer {token}
```

#### Posts d'un utilisateur
```http
GET /api/users/{userId}/posts
Authorization: Bearer {token}
```

#### Créer un post
```http
POST /api/posts
Authorization: Bearer {token}
Content-Type: multipart/form-data

{
  "image": <file>,
  "caption": "Ma belle photo !"
}
```

#### Afficher un post
```http
GET /api/posts/{postId}
Authorization: Bearer {token}
```

#### Supprimer un post
```http
DELETE /api/posts/{postId}
Authorization: Bearer {token}
```

### Likes

#### Liker/Unliker un post
```http
POST /api/posts/{postId}/like
Authorization: Bearer {token}
```

**Réponse:**
```json
{
  "liked": true,
  "likes_count": 42
}
```

### Commentaires

#### Liste des commentaires
```http
GET /api/posts/{postId}/comments
Authorization: Bearer {token}
```

#### Ajouter un commentaire
```http
POST /api/posts/{postId}/comments
Authorization: Bearer {token}
Content-Type: application/json

{
  "content": "Super photo !"
}
```

#### Supprimer un commentaire
```http
DELETE /api/posts/{postId}/comments/{commentId}
Authorization: Bearer {token}
```

### Follows

#### Suivre/Ne plus suivre
```http
POST /api/users/{userId}/follow
Authorization: Bearer {token}
```

**Réponse:**
```json
{
  "is_following": true,
  "followers_count": 156
}
```

#### Liste des followers
```http
GET /api/users/{userId}/followers
Authorization: Bearer {token}
```

#### Liste des utilisateurs suivis
```http
GET /api/users/{userId}/following
Authorization: Bearer {token}
```

### Profil

#### Afficher un profil
```http
GET /api/users/{userId}
Authorization: Bearer {token}
```

#### Modifier son profil
```http
PATCH /api/users/profile
Authorization: Bearer {token}
Content-Type: multipart/form-data

{
  "username": "johndoe",
  "name": "John Doe",
  "bio": "Photographe passionné",
  "website": "https://johndoe.com",
  "profile_picture": <file>,
  "is_private": false
}
```

#### Rechercher des utilisateurs
```http
GET /api/search?q=john
Authorization: Bearer {token}
```

### Messagerie

#### Liste des conversations
```http
GET /api/conversations
Authorization: Bearer {token}
```

#### Afficher une conversation
```http
GET /api/conversations/{conversationId}
Authorization: Bearer {token}
```

#### Créer/Obtenir une conversation avec un utilisateur
```http
GET /api/conversations/with/{userId}
Authorization: Bearer {token}
```

#### Envoyer un message
```http
POST /api/conversations/{conversationId}/messages
Authorization: Bearer {token}
Content-Type: application/json

{
  "content": "Salut, comment vas-tu ?"
}
```

## 🔐 Authentification

Toutes les routes protégées nécessitent un token Bearer dans le header:
```
Authorization: Bearer {votre-token}
```

Le token est retourné lors de la connexion ou de l'inscription.

## 📊 Structure de la base de données

### Tables principales:
- `users` - Utilisateurs
- `posts` - Publications
- `comments` - Commentaires
- `likes` - Likes sur les posts
- `follows` - Relations de suivi entre utilisateurs
- `conversations` - Conversations privées
- `conversation_user` - Table pivot pour les participants
- `messages` - Messages dans les conversations

## 🧪 Tests

### Compte de test par défaut:
- **Email:** test@example.com
- **Password:** password
- **Username:** johndoe

Créé automatiquement avec `php artisan db:seed`

## 🎨 Frontend (À venir)

Le frontend Vue.js/React sera développé séparément et consommera cette API.

## 📝 Notes

- Les images sont stockées dans `storage/app/public/posts` et `storage/app/public/profile_pictures`
- Les compteurs (likes, comments, followers) sont dénormalisés pour les performances
- Soft deletes activé sur les posts
- Pagination à 15 éléments pour le feed, 12 pour les profils, 20 pour les listes

## 🤝 Contribution

Contributions bienvenues ! N'hésitez pas à ouvrir une issue ou une pull request.

## 📄 Licence

MIT License
