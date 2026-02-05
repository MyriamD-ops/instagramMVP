# Instagram MVP - Documentation Backend

## 📋 Vue d'ensemble

Structure complète du backend pour un clone Instagram MVP avec Laravel.

## 🗄️ Base de données

### Tables créées

1. **users** - Utilisateurs
   - id, name, username (unique), email (unique)
   - bio, profile_picture, website
   - is_private (compte privé)
   - followers_count, following_count, posts_count
   
2. **posts** - Publications
   - id, user_id, caption, image_path
   - likes_count, comments_count
   
3. **follows** - Relations de suivi
   - id, follower_id, following_id
   - Contrainte unique sur (follower_id, following_id)
   
4. **likes** - Likes sur les posts
   - id, user_id, post_id
   - Contrainte unique sur (user_id, post_id)
   
5. **comments** - Commentaires
   - id, user_id, post_id, content
   
6. **conversations** - Conversations
   - id, timestamps
   
7. **conversation_user** - Participants aux conversations
   - id, conversation_id, user_id, last_read_at
   
8. **messages** - Messages
   - id, conversation_id, user_id, content, is_read


## 🎯 Modèles et Relations

### User
**Relations:**
- `posts()` - hasMany Post
- `comments()` - hasMany Comment
- `likes()` - hasMany Like
- `following()` - belongsToMany User (ceux que je suis)
- `followers()` - belongsToMany User (ceux qui me suivent)
- `conversations()` - belongsToMany Conversation
- `messages()` - hasMany Message

**Méthodes utiles:**
- `isFollowing(User $user)` - Vérifie si je suis cet utilisateur
- `isFollowedBy(User $user)` - Vérifie si cet utilisateur me suit
- `follow(User $user)` - Suivre un utilisateur
- `unfollow(User $user)` - Ne plus suivre
- `hasLiked(Post $post)` - Vérifie si j'ai liké ce post
- `feed()` - Obtenir le feed (posts des personnes suivies)

### Post
**Relations:**
- `user()` - belongsTo User
- `likes()` - hasMany Like
- `comments()` - hasMany Comment

**Méthodes utiles:**
- `isLikedBy(User $user)` - Vérifie si un utilisateur a liké
- `incrementLikesCount()` / `decrementLikesCount()`
- `incrementCommentsCount()` / `decrementCommentsCount()`

### Like
**Relations:**
- `user()` - belongsTo User
- `post()` - belongsTo Post

### Comment
**Relations:**
- `user()` - belongsTo User
- `post()` - belongsTo Post

### Follow
**Relations:**
- `follower()` - belongsTo User
- `following()` - belongsTo User

