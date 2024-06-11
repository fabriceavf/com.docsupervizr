#!/usr/bin/env bash
set -e
role=${CONTAINER_ROLE:-app}
queue=${QUEUE_NAME:-default}
env=${APP_ENV:-production}
domaine=${APP_ENV:-domaine}
email=${APP_ENV:-email}
#si on est en production
if [ "$env" == "production" ]; then
    echo "Caching configuration..."
    (cd /var/www/html && sudo composer install && php artisan config:cache && php artisan route:cache && php artisan view:cache)
fi



if [ "$role" = "node" ]; then
  #si cest un contenaire de type node
    echo "Installing Node dependencies ..."
    (cd /var/www/html && sudo  npm install --f && sudo  npm run serve)
elif  [ "$role" = "app-prod" ]; then
  #si cest un contenaire de type app de production
    (cd /var/www/html && sudo composer install)
    exec apache2-foreground
elif [ "$role" = "app-swole" ]; then
    #si cest un contenaire de type swole
    echo "Caching configuration for swolle"
    echo "Jinstalle cles dependance grace a composer"
    (cd /var/www/html && sudo composer install)
    echo "Je met en cache les fichier et je lance octane"
    (cd /var/www/html && php artisan optimize:clear && sudo php artisan octane:start --host 0.0.0.0 --port 80 --workers=4 )
elif [ "$role" = "queue-default" ]; then
    #si cest un contenaire de type queue
    echo "Running the queue..."
    echo "$queue"
    (cd /var/www/html && php artisan optimize:clear && php artisan queue:listen database  --verbose --tries=3 --timeout=600 )

elif [ "$role" = "queue" ]; then
    #si cest un contenaire de type queue
    echo "Running the queue..."
    echo "$queue"
    (cd /var/www/html && php artisan optimize:clear && php artisan queue:listen database --queue=$queue --verbose --tries=3 --timeout=600 )
elif [ "$role" = "certbot" ]; then
    #si cest un contenaire de type certbot
    echo "Running the certbot..."
    certbot certonly --webroot --webroot-path=/var/letsencript -d undomaine.com -d $(domaine) --email $(email) --agree-tos
    certbot certonly --webroot-path=/var/www/html/public  -d sgs.supervizr.net --email jeanneavf@gmail.com --agree-tos
#    pour generer pour tous le domaine
     certbot certonly --webroot-path=/ var/www/html/public --manual --preferred-challenges=dns --email jeanneavf@gmail.com --server https://acme-v02.api.letsencrypt.org/directory --agree-tos  -d *.supervizr.net
     certbot certonly --manual --preferred-challenges=dns --email jeanneavf@gmail.com --server https://acme-v02.api.letsencrypt.org/directory --agree-tos --manual-public-ip-logging-ok -d *.supervizr.net
elif [ "$role" = "scheduler" ]; then
    #si cest un contenaire de type schedule
    while [ true ]
    do
      php /var/www/html/artisan schedule:run --verbose --no-interaction &
      sleep 60
    done
elif [ "$role" = "echo-server" ]; then

    #si cest un contenaire de type echo server
    echo "Running the echo server..."
    (cd /var/www/html && php artisan optimize:clear  && laravel-echo-server start
 )
else
    echo "Could not match the container role \"$role\""
    exit 1
fi


certbot certonly --webroot-path=/var/www/html/public  -d backend.cleanafrica.supervizr.net   --email jeanneavf@gmail.com --agree-tos