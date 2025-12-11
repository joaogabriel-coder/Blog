FROM php:8.2-fpm

# Instala dependências do sistema e Nginx
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    nginx \
    libpq-dev \
    --no-install-recommends \
    && rm -rf /var/lib/apt/lists/*

# Instala extensões PHP essenciais
RUN docker-php-ext-install pdo pdo_mysql opcache

WORKDIR /var/www/html

# Instala o Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copia TODO o código da aplicação (incluindo o novo config/cors.php)
COPY . /var/www/html

# Roda o comando de instalação do Composer
RUN composer install --no-dev --optimize-autoloader

# === CORREÇÃO DE CACHE FINAL ===
# Limpa e refaz o cache de configuração do Laravel para garantir que o cors.php seja lido
RUN php artisan config:clear && php artisan config:cache

# Garante as permissões corretas
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage

# Copia a sua configuração do Nginx (correção anterior)
COPY nginx.conf /etc/nginx/conf.d/default.conf 

# Expõe a porta que o Nginx usará
EXPOSE 8080

# Comando de Start
CMD /usr/sbin/nginx -g "daemon off;" && php-fpm -F