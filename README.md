# 🎈 DC Balões - Sistema de Gestão & Vitrine Digital
O **DC Balões** é um sistema web robusto desenvolvido para gerenciamento e vitrine de uma loja de decorações com balões (como arcos, arranjos, bubble balloons e kits de festa). A plataforma oferece uma área pública para exibição e detalhes dos produtos e um completo **Painel Administrativo** para controle do negócio, geração de orçamentos parametrizados e envio de cotações integradas com a API do WhatsApp.
O projeto foi estruturado utilizando o padrão de arquitetura **MVC (Model-View-Controller)** com **PSR-4 Autoloading** e gerenciador de dependências **Composer**.

---
## 🎯 Principais Funcionalidades
### 🌐 Área Pública (Vitrine)
- **Vitrine Virtual:** Exposição de produtos divididos por categorias (personalizados, arranjos, kits, etc.).
- **Visualização de Detalhes:** Páginas individuais de produtos com galerias de fotos (suporte a até 3 imagens por item).
### 🔐 Segurança & Autenticação
- **Níveis de Acesso:** Separação hierárquica entre administradores padrão (`admin`) e superadministradores (`super_admin`).
- **Middleware de Sessão:** Proteção de rotas administrativas sensíveis contra acessos não autorizados.
- **Recuperação de Senha Segura:** Módulo integrado para envio de e-mails contendo códigos de redefinição de uso único (Tokens) válidos por 24 horas, usando SMTP com a biblioteca **PHPMailer**.
### 💼 Painel Administrativo
- **Gestão de Produtos (CRUD):** Cadastro de produtos informando nome, descrição, categoria, preço base e imagens com upload direto no servidor.
- **Gestão de Serviços:** Cadastro e edição de serviços de decoração com valores mínimos definidos.
- **Configurações Globais:** Definição padrão de taxas de mão de obra por hora, margem de lucro padrão (*markup*) e número de WhatsApp da empresa.
- **Calculadora de Orçamentos Dinâmica:**
  - Calcula o preço final do projeto baseado em: Custo de Materiais + (Horas de Trabalho × Taxa Horária) + Taxa de Entrega + Margem de Markup.
  - Exportação direta e formatação automática das cotações em texto para envio imediato ao WhatsApp do cliente.
---
## 📂 Arquitetura MVC & Estrutura de Pastas
```bash
dc-baloes-web-php/
├── app/
│   ├── Controllers/       # Controladores responsáveis pela lógica e roteamento
│   │   ├── AdminController.php
│   │   ├── AuthController.php
│   │   ├── CalculationController.php
│   │   ├── HomeController.php
│   │   ├── ProductController.php
│   │   └── UserController.php
│   ├── Core/              # Componentes estruturais internos da aplicação
│   │   ├── Controller.php # Controlador base
│   │   ├── Database.php   # Inicializador da conexão PDO (Singleton Pattern)
│   │   └── Email.php      # Driver de envio de e-mails via PHPMailer
│   ├── Models/            # Modelagem de negócios e interações com tabelas MySQL
│   └── banco/
│       └── DCBALOES.sql   # Dump de estrutura e cargas iniciais do banco de dados
├── config/                # Arquivos de configurações auxiliares
├── public/                # Diretório raiz público (Entrypoint seguro)
│   ├── css/               # Folhas de estilo da vitrine e painel admin
│   ├── uploads/           # Diretório de armazenamento de imagens dos produtos
│   └── index.php          # Front Controller (Roteador Central da aplicação)
├── views/                 # Arquivos visuais PHP (Interface de Usuário)
│   ├── admin/             # Páginas restritas de controle administrativo
│   ├── partials/          # Cabeçalho, rodapé e logo globais reutilizáveis
│   └── public/            # Páginas de login, recuperação de senha e vitrine
├── .env                   # Variáveis de ambiente seguras (Banco, SMTP)
├── composer.json          # Registro de dependências e regras de Autoloading App\
├── index.php              # Redirecionador inicial seguro para /public
└── README.md              # Documentação do projeto
```
---
## 🛠️ Tecnologias Utilizadas
- **PHP 7.4+ / 8.0+** (Lógica do sistema em arquitetura MVC)
- **Composer:** Gerenciador de pacotes e gerador de autoload.
- **PHPMailer (v7.0):** Biblioteca de integração SMTP para envio de emails.
- **phpdotenv (v5.6):** Gerenciador de variáveis de ambiente para esconder senhas de banco e credenciais SMTP.
- **MariaDB / MySQL:** Banco de dados relacional.
- **Bootstrap 5:** Componentização visual e responsividade das páginas.
---
## 🗄️ Estrutura do Banco de Dados
O banco de dados relacional (gerado no dump [DCBALOES.sql](file:///C:/Users/TALITA%20CASTRO/.gemini/antigravity/scratch/dc-baloes-web-php/app/banco/DCBALOES.sql)) é composto pelas seguintes tabelas:
1. **`users`:** Armazena dados cadastrais dos administradores, hashes de senhas (`bcrypt`), níveis de acesso e tokens de redefinição de senha.
2. **`settings`:** Registra as configurações globais de cálculo de custos e telefone de suporte.
3. **`services`:** Tabela de tipos de serviços e taxas mínimas.
4. **`balloonproduct`:** Cadastro das decorações e balões com links de imagens.
5. **`pricecalculation`:** Log de todos os cálculos de orçamentos gerados na calculadora.
---
## ⚙️ Como Instalar e Rodar Localmente
### Requisitos:
- Servidor web local (Laragon, XAMPP ou WampServer) contendo **PHP 7.4+** e **MySQL**.
- [Composer](https://getcomposer.org/) instalado globalmente.
### Passo a Passo:
1. **Clone o repositório:**
   ```bash
   git clone https://github.com/talitacastrofreitas/dc-baloes-web-php.git
   ```
2. **Instale as dependências via Composer:**
   Abra o terminal na pasta do projeto e execute:
   ```bash
   composer install
   ```
3. **Configure as Variáveis de Ambiente:**
   Abra o arquivo `.env` e configure os dados de conexão do seu banco de dados MySQL local e as chaves SMTP para envio de emails (exemplo Gmail):
   ```env
   # Configurações do Banco
   DB_HOST=127.0.0.1
   DB_DATABASE=DCBaloes
   DB_USERNAME=root
   DB_PASS=
   # Configurações de SMTP
   MAIL_HOST=smtp.gmail.com
   MAIL_PORT=587
   MAIL_USER=seu_email@gmail.com
   MAIL_PASS=sua_senha_de_aplicativo_smtp
   MAIL_FROM_NAME="DC Balões - Suporte"
   ```
4. **Crie e Popule o Banco de Dados:**
   Crie um banco de dados chamado `DCBaloes` no seu servidor local e execute as instruções do script contido em [app/banco/DCBALOES.sql](file:///C:/Users/TALITA%20CASTRO/.gemini/antigravity/scratch/dc-baloes-web-php/app/banco/DCBALOES.sql).
5. **Inicialize a Aplicação:**
   Você pode colocar a pasta dentro da raiz do seu servidor local (ex: `www/` ou `htdocs/`) ou rodar o servidor embutido do PHP na pasta do projeto:
   ```bash
   php -S localhost:8000
   ```
6. **Acesse no Navegador:**
   Abra o navegador no endereço: [http://localhost:8000](http://localhost:8000). O script redirecionará automaticamente para a pasta `public/` central da aplicação.
