#!/bin/bash
set -e

# Verifica se as variáveis de ambiente necessárias estão definidas
: "${MYSQL_ROOT_PASSWORD:?Precisa definir MYSQL_ROOT_PASSWORD}"
: "${MYSQL_DATABASE:?Precisa definir MYSQL_DATABASE}"
: "${DB_USER:?Precisa definir DB_USER}"
: "${DB_PASSWORD:?Precisa definir DB_PASSWORD}"

echo "[Entrypoint] criando usuário de app..."

mysql -u root -p"$MYSQL_ROOT_PASSWORD" <<-EOSQL
  CREATE DATABASE IF NOT EXISTS \\`$MYSQL_DATABASE\\`;
  CREATE USER IF NOT EXISTS '$DB_USER'@'%' IDENTIFIED BY '$DB_PASSWORD';
  GRANT ALL PRIVILEGES ON \\`$MYSQL_DATABASE\\`.* TO '$DB_USER'@'%';
  FLUSH PRIVILEGES;
EOSQL
