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


## ⚙️ Instalação e Execução

```bash
# 1. Clone o repositório
git clone https://github.com/seu-usuario/nome-do-repositorio.git

# 2. Acesse o diretório
cd nome-do-repositorio

# 3. Instale as dependências
composer install
npm install && npm run dev

# 4. Copie e configure o arquivo .env
cp .env.example .env

# 5. Gere a chave da aplicação
php artisan key:generate

# 6. Configure o banco de dados no .env

# 7. Rode as migrations
php artisan migrate

# 8. (Opcional) Popule o usuário de teste
php artisan db:seed --class=UsuarioTesteSeeder
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

