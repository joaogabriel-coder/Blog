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

# Copia TODO o código da aplicação ANTES de instalar o Composer
COPY . /var/www/html

# Roda o comando de instalação do Composer
RUN composer install --no-dev --optimize-autoloader

# Garante as permissões corretas
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage

# Copia a configuração do Nginx
COPY nginx.conf /etc/nginx/sites-available/default

# Cria link simbólico para ativar sua configuração (desativa o padrão)
RUN ln -s /etc/nginx/sites-available/default /etc/nginx/sites-enabled/default

# Expõe a porta que o Nginx usará
EXPOSE 8080

# === COMANDO DE START ===
# Inicia o Nginx em foreground e o PHP-FPM em foreground.
CMD /usr/sbin/nginx -g "daemon off;" && php-fpm -F