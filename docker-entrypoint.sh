#!/bin/bash
set -e

# Função para criar diretórios necessários
create_directories() {
    echo "Criando diretórios necessários..."
    mkdir -p /var/www/html/storage/logs \
            /var/www/html/storage/cache \
            /var/www/html/storage/uploads \
            /var/www/html/src/views/templates \
            /var/www/html/src/views/templates_c \
            /var/www/html/src/views/cache \
            /var/www/html/src/views/configs \
            /var/www/html/logs

    # Garantir que os diretórios do Smarty existam
    mkdir -p /var/www/html/src/views/templates/livros \
            /var/www/html/src/views/templates/auth \
            /var/www/html/src/views/templates/errors

    # Criar arquivo de log com permissões corretas
    touch /var/www/html/logs/auth.log
}

# Função para verificar e corrigir permissões
fix_permissions() {
    echo "Verificando e corrigindo permissões..."
    chown -R www-data:www-data /var/www/html
    find /var/www/html -type d -exec chmod 755 {} \;
    find /var/www/html -type f -exec chmod 644 {} \;
    
    # Permissões especiais para diretórios que precisam de escrita
    chmod -R 775 /var/www/html/storage
    chmod -R 775 /var/www/html/logs
    chmod 666 /var/www/html/logs/auth.log
    chmod -R 775 /var/www/html/src/views/templates_c
    chmod -R 775 /var/www/html/src/views/cache
    chmod -R 775 /var/www/html/src/views/configs
    chmod -R 775 /var/www/html/src/views/templates
}

echo "Iniciando script de entrada..."

# Criar diretórios e configurar permissões
create_directories
fix_permissions

# Aguarda o MySQL estar pronto
echo "Aguardando MySQL..."
max_tries=30
count=0
while [ $count -lt $max_tries ]; do
    if mysqladmin ping -h"$DB_HOST" -u"$DB_USER" -p"$MYSQL_ROOT_PASSWORD" --silent; then
        break
    fi
    echo "Tentando conectar ao MySQL... ($((count + 1))/$max_tries)"
    count=$((count + 1))
    sleep 2
done

if [ $count -eq $max_tries ]; then
    echo "Não foi possível conectar ao MySQL após $max_tries tentativas"
    exit 1
fi

# Executa as migrations e seeds
echo "Executando migrations e seeds..."
php /var/www/html/src/Database/init.php

# Limpar arquivos de pid antigos se existirem
rm -f /var/run/apache2/apache2.pid

# Inicia o Apache em primeiro plano
echo "Iniciando Apache..."
exec apache2-foreground 