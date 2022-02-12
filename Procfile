web: vendor/bin/heroku-php-nginx -C nginx.conf public/
worker1: php artisan queue:work
worker2: node ./dist/index.js
release: php artisan migrate --force && php artisan cache:clear && php artisan config:cache
