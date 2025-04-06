# DC-tecnologia
Desafio da DC tecnologia

# Sistema de Vendas — Teste Técnico

Este é um projeto desenvolvido em Laravel para o teste técnico da vaga de Desenvolvedor Jr na DC Tecnologia.

## ✅ Funcionalidades Implementadas

- Cadastro de clientes
- Registro de vendas com múltiplos produtos
- Registro de parcelas com data de vencimento e valor
- Cálculo automático do valor total da venda
- Login com Laravel Breeze (usuário autenticado é o vendedor)
- Listagem de vendas com filtro por cliente
- Edição e exclusão de vendas
- Geração de PDF do resumo da venda
- Front-end com Bootstrap + jQuery

## 🛠️ Tecnologias

- Laravel 10
- Bootstrap 5
- jQuery
- DomPDF
- MySQL

## 📥 Instalação

```bash
# Clone o repositório
https://github.com/seu-usuario/nome-do-repositorio.git

# Acesse a pasta
cd nome-do-repositorio

# Instale as dependências
composer install
npm install && npm run dev

# Configure o .env
cp .env.example .env

# Gere a chave da aplicação
php artisan key:generate

# Configure seu banco de dados no .env

# Rode as migrations
php artisan migrate

# Popule o usuário de teste
php artisan db:seed --class=UsuarioTesteSeeder
```

## 👤 Acesso de Teste

```
Email: teste@teste.com
Senha: 12345678
```

## 🧪 Teste Rápido

- Faça login com o usuário acima
- Cadastre um cliente
- Registre uma venda com produtos e parcelas
- Edite ou exclua a venda
- Baixe o PDF gerado

