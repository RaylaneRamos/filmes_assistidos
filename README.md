 🎬 filmes_assistidos

Projeto simples para controlar filmes assistidos: adicionar filmes, alterar status, deletar, manter favoritos etc.

 🧾 Sumário

- [Funcionalidades](#funcionalidades)  
- [Tecnologias usadas](#tecnologias-usadas)  
- [Banco de dados](#banco-de-dados)  
- [Instalação / Uso](#instalação--uso)  
- [Melhorias possíveis](#melhorias-possíveis)  
- [Licença](#licença)



 Funcionalidades

- Cadastro de usuário / login / logout  
- Listagem de filmes (exibindo título, ano, status, favorito)  
- Adicionar novo filme com detalhes (gênero, duração, sinopse, nota)  
- Marcar filme como assistido ou não  
- Marcar filme como favorito  
- Deletar filmes cadastrados  
- Atualizar status do filme  

---

 Tecnologias usadas

- PHP  
- MySQL  
- HTML / CSS  
- JavaScript

Banco de dados

Antes de rodar, é necessário criar o banco de dados e a tabela. Aqui está o script SQL sugerido:

```sql
CREATE DATABASE `filmes_assistidos`;

USE `filmes_assistidos`;

CREATE TABLE `filmes` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    ano INT,
    genero VARCHAR(100),
    duracao INT,
    sinopse VARCHAR(255),
    nota INT,
    assistido BOOLEAN DEFAULT FALSE,
    favorito BOOLEAN DEFAULT FALSE
);

Instalação / Uso
Clone o repositório:

 git clone https://github.com/RaylaneRamos/filmes_assistidos.git


Coloque os arquivos em um servidor compatível com PHP (seja local, como XAMPP / MAMP / LAMP, ou remoto).


Crie o banco de dados MySQL usando o script acima (via phpMyAdmin, MySQL Workbench ou linha de comando).


Ajuste as credenciais de conexão no(s) arquivo(s) PHP que fazem conexão com o banco (host, usuário, senha, nome do banco).


Acesse pelo navegador, por exemplo:

 http://localhost/filmes_assistidos/index.php


Faça login, cadastre filmes, marque como assistido, adicione favoritos etc.


Melhorias possíveis
Fazer validação de formulários no frontend e backend
Hashear senhas de usuários (se houver cadastro de usuário) para segurança
Proteger rotas que demandam autenticação
Paginar a lista de filmes, filtrar por gênero / favorito / status
Layout responsivo para dispositivos móveis
Upload de imagem de capa do filme


API REST para uso externo ou apps móveis

