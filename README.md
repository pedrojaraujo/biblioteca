# Aplicativo de Gerenciamento - Estudo de PHP e Desenvolvimento de API

Este projeto foi desenvolvido como parte do estudo de PHP e criação de APIs RESTful. O objetivo principal é aprofundar o conhecimento em desenvolvimento de APIs usando PHP, manipulação de dados e integração com banco de dados.

## Propósito do Projeto

O aplicativo visa fornecer funcionalidades básicas de gerenciamento de dados, como:

- Cadastro e autenticação de usuários.
- CRUD (Create, Read, Update, Delete) para registros.
- Geração e validação de tokens JWT (JSON Web Tokens) para autenticação.
- Conexão com banco de dados utilizando PHP.
- Estrutura para criação de uma API RESTful.

Este projeto não tem como objetivo ser uma solução de produção, mas sim um exercício de aprendizagem para aprimorar habilidades em PHP e desenvolvimento de APIs.

## Tecnologias Utilizadas

- **PHP 8.3**: Linguagem de programação principal para o desenvolvimento da aplicação.
- **MySQL**: Banco de dados utilizado para armazenar os dados do sistema.
- **JWT (JSON Web Tokens)**: Para autenticação e geração de tokens de acesso seguro.
- **Dotenv**: Para carregar variáveis de ambiente de forma segura.
- **Composer**: Gerenciador de dependências para PHP.
- **.htaccess**: Para configurações e segurança no ambiente de desenvolvimento.

## Funcionalidades

- **Autenticação**: Sistema de login e geração de tokens JWT.
- **CRUD**: Operações de criar, ler, atualizar e deletar registros no banco de dados.
- **Validação de JWT**: Protege rotas da API com a verificação do token JWT.
- **Gerenciamento de Configurações**: Variáveis de configuração carregadas de arquivos `.env` e `config.php`.

## Testes

Todos os testes foram realizados utilizando o [Postman](https://www.postman.com/). O Postman foi usado para testar as rotas da API, realizar requisições HTTP e validar o funcionamento da autenticação com JWT, além das operações CRUD no banco de dados.

## Como Rodar o Projeto

1. **Clone o repositório**:

   ```bash
   git clone https://github.com/pedrojaraujo/biblioteca.git

2. **Navegue até o diretório do projeto**:

   ```bash
   cd biblioteca

3. **Instale as dependências do Composer**:

   ```bash
   composer install

4. **Inicie o servidor**:

   ```bash
   php -S localhost:8000 -t public
