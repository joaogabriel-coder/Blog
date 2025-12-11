# Usa uma imagem oficial do PHP FPM (FastCGI Process Manager)
FROM php:8.2-fpm

# Instala dependências do sistema e Nginx
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    nginx \
    libpq-dev \
    # Limpa o cache após a instalação
    --no-install-recommends \
    && rm -rf /var/lib/apt/lists/*

# Instala extensões PHP essenciais (inclua 'pdo_mysql' se estiver usando MySQL)
RUN docker-php-ext-install pdo pdo_mysql opcache

# Define o diretório de trabalho do container como a raiz do seu projeto
WORKDIR /var/www/html

# Instala o Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copia o composer.json e instala as dependências
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader

# Copia o restante do código da aplicação
COPY . .

# Garante as permissões corretas para o Laravel
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage

# Copia a configuração do Nginx para a pasta correta do container
COPY nginx.conf /etc/nginx/sites-available/default

# Remove a configuração padrão do Nginx
RUN rm /etc/nginx/conf.d/default.conf

# Expõe a porta que o Nginx usará para comunicação externa
EXPOSE 8080