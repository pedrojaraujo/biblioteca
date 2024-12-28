# Aplicativo de Gerenciamento - Estudo de PHP e Desenvolvimento de API

Este projeto foi desenvolvido como parte do estudo de **PHP** e criação de APIs RESTful. O objetivo principal é aprofundar o conhecimento em desenvolvimento de APIs utilizando PHP, manipulação de dados e integração com banco de dados.

## **Propósito do Projeto**

O aplicativo visa fornecer funcionalidades básicas de gerenciamento de dados, como:

- **Cadastro e autenticação de usuários.**
- **Operações CRUD (Create, Read, Update, Delete):** Permite a criação, leitura, atualização e exclusão de registros.
- **Geração e validação de tokens JWT (JSON Web Tokens):** Para autenticação e autorização de acesso.
- **Conexão com banco de dados MySQL:** Para armazenamento e gerenciamento dos dados.
- **Estrutura de API RESTful:** Seguindo padrões de design para construção de APIs.

> **Nota:** Este projeto é um exercício de aprendizado e não uma solução pronta para produção.

## **Tecnologias Utilizadas**

- **PHP 8.3:** Linguagem de programação principal para o desenvolvimento da aplicação.
- **MySQL:** Banco de dados utilizado para armazenar os dados do sistema.
- **JWT (JSON Web Tokens):** Utilizado para autenticação segura.
- **Dotenv:** Para carregar variáveis de ambiente de forma segura.
- **Composer:** Gerenciador de dependências para PHP.
- **.htaccess:** Configurações e segurança no ambiente de desenvolvimento.

## **Funcionalidades**

- **Autenticação:**
  - Sistema de login com validação de credenciais e geração de tokens JWT.
  - Proteção de rotas da API com autenticação baseada em JWT.

- **Operações CRUD:**
  - Gerenciamento completo de registros no banco de dados.
  - Estrutura para criar, ler, atualizar e excluir dados via API RESTful.

- **Gerenciamento de Configurações:**
  - Variáveis de configuração carregadas de arquivos `.env` e `config.php`.

## **Testes**

Os testes foram realizados utilizando o **Postman**, onde foram validadas:

- Rotas da API.
- Requisições HTTP (GET, POST, PUT, DELETE).
- Funcionamento da autenticação JWT.
- Operações CRUD no banco de dados.

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

4. **Configure o arquivo .env**:

   ```bash
    DB_HOST=localhost
    DB_NAME=seu_banco
    DB_USER=seu_user
    DB_PASSWORD=sua_senha
    SECRET_KEY=sua_chave_secreta

5. **Inicie o servidor**:

   ```bash
   php -S localhost:8000 -t public



## **Licença**

Este projeto é licenciado sob os termos da licença MIT. Consulte o arquivo [LICENSE](./LICENSE) para obter mais detalhes.
