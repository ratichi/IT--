copy .env.example .env
composer install --no-dev --optimize-autoloader
php artisan key:generate
