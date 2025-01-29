# Use a imagem oficial do PHP com Apache
FROM php:8.4-apache

# Instale as dependências necessárias
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    git \
    libicu-dev \
    default-mysql-client \
    && rm -rf /var/lib/apt/lists/*

# Instalar e habilitar extensões PHP
RUN docker-php-ext-configure intl \
    && docker-php-ext-install -j$(nproc) \
        pdo \
        pdo_mysql \
        zip \
        intl

# Instale o Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Criar estrutura base de diretórios
RUN mkdir -p /var/www/html

# Definir permissões iniciais
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Copie o .env.example para .env
COPY .env /var/www/html/.env

# Copie apenas os arquivos do Composer primeiro
COPY composer.json composer.lock /var/www/html/

# Defina o diretório de trabalho
WORKDIR /var/www/html

# Instale as dependências do Composer
RUN composer install --no-interaction --no-scripts --no-progress --prefer-dist

# Copie o restante dos arquivos do projeto
COPY . .

# Configurar permissões iniciais
RUN chown -R www-data:www-data /var/www/html

# Verificar se os templates foram copiados corretamente
RUN ls -la /var/www/html/src/views/templates/livros/ && \
    echo "Conteúdo do template lista.tpl:" && \
    cat /var/www/html/src/views/templates/livros/lista.tpl

# Configuração do Apache
COPY .docker/apache2.conf /etc/apache2/conf-available/custom.conf
RUN a2enconf custom \
    && a2dissite 000-default \
    && a2enmod rewrite headers expires

# Copie o arquivo de configuração do Apache
COPY .docker/vhost.conf /etc/apache2/sites-available/000-default.conf
RUN a2ensite 000-default

# Adicione um script de inicialização
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Configurar diretório de logs do Apache
RUN mkdir -p /var/log/apache2 \
    && chown -R www-data:www-data /var/log/apache2 \
    && chmod -R 755 /var/log/apache2

# Define variáveis de ambiente do Apache
ENV APACHE_RUN_USER www-data
ENV APACHE_RUN_GROUP www-data
ENV APACHE_LOG_DIR /var/log/apache2
ENV APACHE_PID_FILE /var/run/apache2/apache2.pid
ENV APACHE_RUN_DIR /var/run/apache2
ENV APACHE_LOCK_DIR /var/lock/apache2

# Criar diretórios necessários para o Apache
RUN mkdir -p /var/run/apache2 /var/lock/apache2 \
    && chown -R www-data:www-data /var/run/apache2 /var/lock/apache2

# Configurar PHP para mostrar erros em desenvolvimento
RUN { \
    echo 'error_reporting = E_ALL'; \
    echo 'display_errors = On'; \
    echo 'log_errors = On'; \
    echo 'error_log = /dev/stderr'; \
    echo 'display_startup_errors = On'; \
} > /usr/local/etc/php/conf.d/error-reporting.ini

# Exponha a porta 80
EXPOSE 80

# Comando para iniciar o servidor Apache
CMD ["docker-entrypoint.sh"]
