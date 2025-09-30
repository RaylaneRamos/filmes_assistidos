
Meus Filmes Assistidos
Um sistema web simples para gerenciar filmes assistidos, permitindo ao usuário adicionar, visualizar, editar e excluir filmes, além de marcar favoritos. Feito com PHP, MySQL, HTML, CSS e JavaScript.
💡 Funcionalidades
Cadastro e login de usuários.


Adicionar filmes com informações detalhadas (título, ano, gênero, duração, sinopse, nota, assistido, favorito).


Listar filmes cadastrados.


Marcar filmes como assistidos ou favoritos.


Remover filmes da lista.


Interface responsiva e interativa com CSS e JavaScript.
🛠 Tecnologias
Frontend: HTML, CSS, JavaScript


Backend: PHP


Banco de dados: MySQL


📂 Estrutura de Arquivos
filmes_assistidos/
│
├─ index.php           # Página principal, lista filmes e adiciona novos
├─ cadastro.php        # Cadastro de novos usuários
├─ login.php           # Login de usuários
├─ logout.php          # Logout
├─ delete_filme.php    # Exclui filmes
├─ update_status.php   # Atualiza status de assistido
├─ style.css           # Estilos da aplicação
└─ script.js           # Interações (remover filmes)

💾 Banco de Dados
1️⃣ Criar banco
CREATE DATABASE filmes_assistidos;
USE filmes_assistidos;

2️⃣ Tabela de usuários
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL
);

3️⃣ Tabela de filmes
CREATE TABLE filmes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    ano INT,
    genero VARCHAR(50),
    duracao INT,
    sinopse TEXT,
    nota INT,
    assistido TINYINT(1) DEFAULT 0,
    favorito TINYINT(1) DEFAULT 0
);


⚙️ Como rodar o projeto
Clone o repositório:


git clone https://github.com/RaylaneRamos/filmes_assistidos.git

Copie para a pasta do XAMPP/htdocs (ou similar) para rodar localmente.


Crie o banco de dados no MySQL usando os comandos acima.


Abra no navegador:


http://localhost/filmes_assistidos/

Cadastre um usuário, faça login e comece a adicionar filmes.


📝 Observações
Certifique-se que o MySQL e o Apache estão rodando no XAMPP.


Senhas dos usuários são armazenadas de forma criptografada.


A interface é responsiva e funciona em desktop e mobile.




