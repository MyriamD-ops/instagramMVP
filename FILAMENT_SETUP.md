# Installation et Configuration de Filament

## 🚀 Installation

### 1. Installer Filament via Composer
```bash
composer require filament/filament:"^3.0"
```

### 2. Publier les assets
```bash
php artisan filament:install --panels
```

### 3. Créer un utilisateur admin
```bash
php artisan make:filament-user
```

Ou via tinker:
```bash
php artisan tinker
>>> $user = User::find(1); // Ou créer un nouvel utilisateur
>>> $user->email = 'admin@example.com';
>>> $user->password = bcrypt('password');
>>> $user->save();
```

## 📋 Étapes de configuration

### 1. Ajouter Filament au composer.json

Ajouter dans la section `require`:
```json
"filament/filament": "^3.0"
```

Puis exécuter:
```bash
composer update
```

### 2. Créer les Resources Filament

Les resources Filament permettent de gérer les modèles via l'interface admin.

#### Resource User
```bash
php artisan make:filament-resource User --generate
```

#### Resource Post
```bash
php artisan make:filament-resource Post --generate
```

#### Resource Comment
```bash
php artisan make:filament-resource Comment --generate
```

#### Resource Conversation
```bash
php artisan make:filament-resource Conversation --generate
```

### 3. Structure des fichiers à créer

Voici les fichiers que nous devons créer manuellement :

```
app/
└── Filament/
    ├── Resources/
    │   ├── UserResource.php
    │   ├── UserResource/
    │   │   └── Pages/
    │   │       ├── CreateUser.php
    │   │       ├── EditUser.php
    │   │       └── ListUsers.php
    │   ├── PostResource.php
    │   ├── PostResource/
    │   │   └── Pages/
    │   │       ├── CreatePost.php
    │   │       ├── EditPost.php
    │   │       └── ListPosts.php
    │   ├── CommentResource.php
    │   ├── CommentResource/
    │   │   └── Pages/
    │   │       ├── CreateComment.php
    │   │       ├── EditComment.php
    │   │       └── ListComments.php
    │   └── ConversationResource.php
    └── Widgets/
        ├── StatsOverview.php
        └── LatestPosts.php
```

### 4. Configurer le Panel

Le fichier de configuration sera dans:
```
app/Providers/Filament/AdminPanelProvider.php
```

### 5. Accéder au panel admin

Une fois configuré, accédez à:
```
http://localhost:8000/admin
```

## 🎨 Fonctionnalités à implémenter

### Dashboard
- [ ] Statistiques générales (utilisateurs, posts, likes, commentaires)
- [ ] Graphiques de croissance
- [ ] Liste des derniers posts
- [ ] Activité récente

### Gestion des utilisateurs
- [ ] Liste de tous les utilisateurs
- [ ] Recherche et filtres
- [ ] Modification des profils
- [ ] Bannir/Activer des utilisateurs
- [ ] Voir les statistiques par utilisateur

### Gestion des posts
- [ ] Liste de tous les posts
- [ ] Prévisualisation des images
- [ ] Modération (approuver/rejeter)
- [ ] Suppression de posts inappropriés
- [ ] Voir les likes et commentaires

### Gestion des commentaires
- [ ] Modération des commentaires
- [ ] Suppression de commentaires inappropriés
- [ ] Filtrer par post ou utilisateur

### Rapports
- [ ] Posts signalés
- [ ] Utilisateurs signalés
- [ ] Statistiques détaillées

## 🔧 Configuration avancée

### Ajouter des rôles et permissions (Optionnel)
```bash
composer require spatie/laravel-permission
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
php artisan migrate
```

### Personnaliser les couleurs
Dans `AdminPanelProvider.php`, modifier les couleurs du thème.

### Ajouter un logo personnalisé
Placer le logo dans `public/images/logo.png` et le configurer dans le provider.

## 📊 Widgets personnalisés

Créer des widgets pour le dashboard:
```bash
php artisan make:filament-widget StatsOverview --resource=UserResource
php artisan make:filament-widget LatestPosts --resource=PostResource
```

## 🚀 Commandes utiles

```bash
# Créer un utilisateur admin
php artisan make:filament-user

# Publier les vues Filament
php artisan vendor:publish --tag=filament-views

# Publier les traductions
php artisan vendor:publish --tag=filament-translations

# Vider le cache Filament
php artisan filament:cache-components
```

## 🌐 Accès

- **URL Admin**: `http://localhost:8000/admin`
- **Compte par défaut**: À créer avec `php artisan make:filament-user`

## 📚 Documentation

Documentation officielle: https://filamentphp.com/docs
