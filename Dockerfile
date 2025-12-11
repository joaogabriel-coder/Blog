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

# Copia TODO o código da aplicação 
COPY . /var/www/html

# Roda o comando de instalação do Composer
RUN composer install --no-dev --optimize-autoloader

# Limpa e refaz o cache de configuração do Laravel
RUN php artisan config:clear && php artisan config:cache

# Garante as permissões corretas
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage

# Copia a sua configuração do Nginx
COPY nginx.conf /etc/nginx/conf.d/default.conf 

# Expõe a porta que o Nginx usará
EXPOSE 8080

# === ALTERAÇÃO CRÍTICA: NOVO COMANDO DE STARTUP ===
# Copia o script para dentro do container
COPY startup.sh /usr/local/bin/

# Garante que o script tenha permissão de execução
RUN chmod +x /usr/local/bin/startup.sh

# Altera o comando principal para executar o script de startup
CMD ["/usr/local/bin/startup.sh"]