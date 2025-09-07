#!/bin/bash
set -e

# Verifica se as variáveis de ambiente necessárias estão definidas
: "${MYSQL_ROOT_PASSWORD:?Precisa definir MYSQL_ROOT_PASSWORD}"
: "${MYSQL_DATABASE:?Precisa definir MYSQL_DATABASE}"
: "${MYSQL_USER:?Precisa definir MYSQL_USER}"
: "${MYSQL_PASSWORD:?Precisa definir MYSQL_PASSWORD}"

echo "[Entrypoint] criando usuário de app..."

mysql -u root -p"$MYSQL_ROOT_PASSWORD" <<-EOSQL
  CREATE DATABASE IF NOT EXISTS \\`$MYSQL_DATABASE\\`;
  CREATE USER IF NOT EXISTS '$MYSQL_USER'@'%' IDENTIFIED BY '$MYSQL_PASSWORD';
  GRANT ALL PRIVILEGES ON \\`$MYSQL_DATABASE\\`.* TO '$MYSQL_USER'@'%';
  FLUSH PRIVILEGES;
EOSQL
