#!/bin/bash

# Inicia o PHP-FPM (processador PHP) em modo non-daemon
php-fpm -F &

# Inicia o Nginx (servidor web) em modo non-daemon. 
# O '&' acima garante que o Nginx não esperará o PHP-FPM terminar, e vice-versa.
/usr/sbin/nginx -g "daemon off;"