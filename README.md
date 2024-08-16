# Projeto de Rede Social

Este é um projeto de uma rede social simples desenvolvido em PHP, com foco em práticas de desenvolvimento modernas, incluindo o uso de padrões de projeto e princípios de Clean Code. O projeto utiliza o padrão MVC (Model-View-Controller) para organizar o código e oferece funcionalidades como autenticação de usuários, criação de postagens, comentários, gerenciamento de amizades e permissões de usuário.

## Tecnologias Utilizadas

- **PHP**: Linguagem de programação principal.
- **PDO (PHP Data Objects)**: Para manipulação de banco de dados.
- **MySQL**: Banco de dados utilizado.
- **Composer**: Gerenciador de dependências do PHP.
- **Twig**: Motor de templates para renderizar as views.
- **Gulp**: Para gerenciamento de tarefas como minificação de CSS.

## Funcionalidades

- **Autenticação de Usuários**: Registro, login e logout.
- **Gerenciamento de Postagens**: Criação, listagem e visualização de postagens.
- **Comentários**: Possibilidade de adicionar comentários às postagens.
- **Amizades**: Adição e remoção de amigos, listagem de amigos de um usuário.
- **Permissões e Papéis de Usuário**: Definição de papéis (admin, usuário) e controle de acesso baseado em permissões.
- **Proteção de Rotas**: Acesso a certas rotas restrito a usuários autenticados.

## Estrutura do Projeto

- **app/**
  - **Controllers/**: Contém os controladores que lidam com a lógica de negócios.
  - **Core/**: Contém classes essenciais como o Router e a conexão com o banco de dados.
  - **Models/**: Contém os modelos que interagem com o banco de dados.
  - **Views/**: Contém os arquivos de template renderizados pelo Twig.
- **config/**
  - **config.php**: Arquivo de configuração para banco de dados e outras configurações gerais.
- **public/**
  - **index.php**: Ponto de entrada para todas as requisições.

## Instalação

1. **Clone o repositório:**

   ```bash
   git clone https://github.com/TaviloBreno/redesocial
   cd seu-repositorio
