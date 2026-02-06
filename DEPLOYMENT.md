# Guide de Déploiement - Instagram MVP

## 📦 Checklist avant déploiement

### 1. Configuration de l'environnement
- [ ] Copier `.env.example` vers `.env` en production
- [ ] Générer une nouvelle APP_KEY: `php artisan key:generate`
- [ ] Configurer la base de données de production
- [ ] Définir `APP_ENV=production`
- [ ] Définir `APP_DEBUG=false`
- [ ] Configurer `APP_URL` avec l'URL de production

### 2. Base de données
```bash
# Migrer la base de données
php artisan migrate --force

# (Optionnel) Peupler avec des données de test
php artisan db:seed
```

### 3. Storage
```bash
# Créer le lien symbolique
php artisan storage:link

# S'assurer des permissions correctes
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### 4. Optimisations
```bash
# Cache de configuration
php artisan config:cache

# Cache des routes
php artisan route:cache

# Cache des vues
php artisan view:cache

# Optimiser l'autoloader
composer install --optimize-autoloader --no-dev
```

### 5. Assets
```bash
# Compiler les assets pour la production
npm run build
```

## 🔐 Sécurité

### Variables d'environnement importantes
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://votre-domaine.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=votre_base
DB_USERNAME=votre_user
DB_PASSWORD=mot_de_passe_securise

SANCTUM_STATEFUL_DOMAINS=votre-domaine.com
SESSION_DOMAIN=.votre-domaine.com
```

### CORS Configuration
Dans `config/cors.php`, vérifier:
```php
'allowed_origins' => ['https://votre-frontend.com'],
```

## 🚀 Déploiement sur serveur

### Option 1: VPS (Ubuntu/Debian)

#### Installer les dépendances
```bash
sudo apt update
sudo apt install php8.2 php8.2-fpm php8.2-mysql php8.2-xml php8.2-mbstring php8.2-curl php8.2-zip php8.2-gd
sudo apt install nginx mysql-server composer
```

#### Configuration Nginx
```nginx
server {
    listen 80;
    server_name votre-domaine.com;
    root /var/www/instagramMVP/public;

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
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

#### SSL avec Let's Encrypt
```bash
sudo apt install certbot python3-certbot-nginx
sudo certbot --nginx -d votre-domaine.com
```

### Option 2: Hébergement partagé (cPanel)

1. Uploader les fichiers via FTP
2. Pointer le domaine vers le dossier `public`
3. Créer la base de données MySQL via cPanel
4. Configurer le `.env`
5. Exécuter les migrations via SSH ou Terminal

### Option 3: Docker

#### Dockerfile
```dockerfile
FROM php:8.2-fpm

# Installer les extensions
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

RUN composer install --optimize-autoloader --no-dev

RUN php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache

RUN chmod -R 775 storage bootstrap/cache

EXPOSE 9000
CMD ["php-fpm"]
```

#### docker-compose.yml
```yaml
version: '3.8'

services:
  app:
    build: .
    volumes:
      - .:/var/www
    depends_on:
      - mysql

  nginx:
    image: nginx:alpine
    ports:
      - "80:80"
    volumes:
      - ./nginx.conf:/etc/nginx/conf.d/default.conf
      - .:/var/www

  mysql:
    image: mysql:8.0
    environment:
      MYSQL_DATABASE: instagram_mvp
      MYSQL_ROOT_PASSWORD: root_password
      MYSQL_USER: user
      MYSQL_PASSWORD: password
    volumes:
      - mysql_data:/var/lib/mysql

volumes:
  mysql_data:
```

## 🔄 Mise à jour en production

```bash
# Activer le mode maintenance
php artisan down

# Récupérer les derniers changements
git pull origin main

# Installer les dépendances
composer install --no-dev --optimize-autoloader

# Migrer la base de données
php artisan migrate --force

# Vider et reconstruire les caches
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Désactiver le mode maintenance
php artisan up
```

## 📊 Monitoring

### Logs
```bash
# Voir les logs en temps réel
tail -f storage/logs/laravel.log

# Logs Nginx
tail -f /var/log/nginx/error.log
```

### Sauvegardes
```bash
# Backup de la base de données
mysqldump -u user -p database_name > backup_$(date +%Y%m%d).sql

# Backup des fichiers uploadés
tar -czf storage_backup_$(date +%Y%m%d).tar.gz storage/app/public
```

## ⚡ Performance

### Redis (optionnel)
```bash
# Installer Redis
sudo apt install redis-server

# Configuration Laravel
CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis
```

### Queue Workers
```bash
# Lancer un worker
php artisan queue:work --daemon

# Avec Supervisor
[program:instagram-worker]
command=php /var/www/instagramMVP/artisan queue:work --sleep=3 --tries=3
directory=/var/www/instagramMVP
autostart=true
autorestart=true
user=www-data
```

## 🆘 Dépannage

### Permissions
```bash
sudo chown -R www-data:www-data /var/www/instagramMVP
sudo chmod -R 755 /var/www/instagramMVP
sudo chmod -R 775 storage bootstrap/cache
```

### Cache
```bash
# Vider tous les caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Erreur 500
1. Vérifier `storage/logs/laravel.log`
2. Vérifier `.env` configuration
3. Vérifier permissions
4. Vérifier extensions PHP installées

## 📞 Support

Pour toute question, ouvrir une issue sur GitHub.
