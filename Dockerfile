# Use a imagem oficial do PHP com Apache
FROM php:8.4-apache

# Instale as extensões necessárias
RUN apt-get update && apt-get install -y \
    libzip-dev unzip git && \
    docker-php-ext-install pdo_mysql zip

# Instale o Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copie apenas os arquivos do Composer primeiro (melhora cache)
COPY composer.json composer.lock /var/www/html/

# Defina o diretório de trabalho
WORKDIR /var/www/html

# Instale as dependências do Composer (somente de produção)
RUN composer install --no-dev --optimize-autoloader

# Copie o restante dos arquivos do projeto
COPY . /var/www/html

# Configurar permissões corretas
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Habilite o módulo de reescrita do Apache
RUN a2enmod rewrite

# Copie o arquivo de configuração do Apache (garanta que ele existe)
COPY .docker/vhost.conf /etc/apache2/sites-available/000-default.conf

# Exponha a porta 80
EXPOSE 80

# Comando para iniciar o servidor Apache
CMD ["apache2-foreground"]
