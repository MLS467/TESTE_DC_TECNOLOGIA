# 📋 Sistema de Vendas - Laravel

Sistema de vendas com gestão de clientes, produtos, vendas e parcelas desenvolvido em Laravel 12.

## 🔧 Pré-requisitos

-   **PHP 8.2** ou superior
-   **Composer** (gerenciador de dependências PHP)
-   **Node.js** e **npm** (para assets front-end)
-   **SQLite** (banco de dados - já configurado)

## 🚀 Como executar o projeto

### 1. Clone e acesse o projeto

```bash
git clone <url-repositório>
```

### 2. Instale as dependências PHP

```bash
composer install
```

### 3. Instale as dependências JavaScript

```bash
npm install
```

### 4. Configure o ambiente

```bash
# Copie o arquivo de exemplo (se não existir)
copy .env.example .env

# Gere a chave da aplicação
php artisan key:generate
```

### 5. Configure o banco de dados

```bash
# Execute as migrações e seeders (popula dados de teste)
php artisan migrate:refresh --seed
```

### 6. Inicie o servidor de desenvolvimento

```bash
# Terminal 1 - Servidor Laravel
php artisan serve

# Terminal 2 - Build dos assets (opcional, para desenvolvimento)
npm run dev
```

## 🌐 Acesso ao sistema

-   **URL:** http://localhost:8000
-   **Email de teste:** `teste@example.com`
-   **Senha de teste:** `password`

## 📁 Estrutura do sistema

O sistema possui os seguintes módulos:

### 🔐 **Autenticação**

-   Login/logout de vendedores
-   Proteção de rotas por middleware

### 👥 **Gestão de Clientes**

-   CRUD completo de clientes
-   Validação de CPF

### 📦 **Gestão de Produtos**

-   CRUD completo de produtos
-   Controle de preços

### 💰 **Sistema de Vendas**

-   Registro de vendas com múltiplos produtos
-   Sistema de parcelas com diferentes tipos de pagamento
-   Relatórios de vendas
-   Impressão de vendas

## 🗄️ Banco de Dados

O projeto utiliza **SQLite** como banco de dados padrão, localizado em:

```
database/database.sqlite
```

### Tabelas principais:

-   `sellers` - Vendedores do sistema
-   `clients` - Clientes
-   `products` - Produtos
-   `sales` - Vendas realizadas
-   `sales_items` - Itens de cada venda
-   `installments` - Parcelas das vendas

## 📊 Dados de Teste

Após executar `php artisan migrate:refresh --seed`, o sistema será populado com:

-   1 vendedor de teste (login: teste@example.com / password)
-   Clientes de exemplo
-   Produtos de exemplo

## 🔄 Comandos úteis

```bash
# Resetar banco e recriar dados de teste
php artisan migrate:refresh --seed

# Limpar cache da aplicação
php artisan cache:clear

# Ver rotas disponíveis
php artisan route:list

# Executar testes (se houver)
php artisan test
```

## 🛠️ Tecnologias utilizadas

-   **Backend:** Laravel 12, PHP 8.2
-   **Frontend:** Blade Templates, Bootstrap, JavaScript
-   **Banco:** MySQL
-   **Outros:** Carbon (datas), Faker (dados fictícios)

#

# OBRIGADO !!!
