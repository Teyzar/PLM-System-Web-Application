web: vendor/bin/heroku-php-nginx -C nginx.conf public/
web: vendor/bin/heroku-php-apache2 public/
worker: php artisan queue:work
release: php artisan migrate --force && php artisan cache:clear && php artisan config:cache
