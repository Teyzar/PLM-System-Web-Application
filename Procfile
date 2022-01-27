web: vendor/bin/heroku-php-nginx -C nginx.conf public/
worker: php artisan queue:work
worker2: php artisan websockets:serve
release: php artisan migrate --force && php artisan cache:clear && php artisan config:cache
