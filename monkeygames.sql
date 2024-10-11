CREATE DATABASE monkeygames;

USE monkeygames;

CREATE TABLE jogador(id_jogador INT AUTO_INCREMENT PRIMARY KEY,
nome_jogador VARCHAR(895) NOT NULL,
email_jogador VARCHAR(345) NOT NULL UNIQUE,
telefone_jogador INT NOT NULL UNIQUE,
cpf_jogador INT NOT NULL UNIQUE,
senha_jogador VARCHAR(30) NOT NULL
);

CREATE TABLE organizador(id_organizador INT AUTO_INCREMENT PRIMARY KEY,
nome_org VARCHAR(895) NOT NULL,
email_org VARCHAR(345) NOT NULL UNIQUE,
telefone_org INT NOT NULL UNIQUE,
cpf_org INT NOT NULL UNIQUE,
senha_org VARCHAR(30) NOT NULL
);

CREATE TABLE adm(id_adm INT AUTO_INCREMENT PRIMARY KEY,
nome_adm VARCHAR(895) NOT NULL,
senha_adm VARCHAR(30) DEFAULT 'sysadmin2024'
);

CREATE TABLE genero(id_genero INT AUTO_INCREMENT PRIMARY KEY,
nome_genero VARCHAR(50) NOT NULL
);

CREATE TABLE endereco(id_endereco INT AUTO_INCREMENT PRIMARY KEY,
rua VARCHAR(255) DEFAULT '',
numero VARCHAR(255) DEFAULT '',
setor VARCHAR(255) DEFAULT '',
cidade VARCHAR(255) DEFAULT '',
estado VARCHAR(255) DEFAULT '',
pais VARCHAR(255) NOT NULL
);

CREATE TABLE jogo(id_jogo INT AUTO_INCREMENT PRIMARY KEY,
nome_jogo VARCHAR(400) NOT NULL,
ano_lancamento YEAR NOT NULL,
genero_id INT NOT NULL,
FOREIGN KEY (genero_id) REFERENCES genero(id_genero)
);

CREATE TABLE evento(id_evento INT AUTO_INCREMENT PRIMARY KEY,
nome_evento VARCHAR(255) NOT NULL,
data_evento DATETIME NOT NULL,
qtd_participante INT,
regras VARCHAR(2000) NOT NULL,
jogo_id INT NOT NULL,
FOREIGN KEY (jogo_id) REFERENCES jogo(id_jogo),
organizador_id INT NOT NULL,
FOREIGN KEY (organizador_id) REFERENCES organizador(id_organizador),
endereco_id INT NOT NULL,
FOREIGN KEY (endereco_id) REFERENCES endereco(id_endereco)
);

CREATE TABLE inscricao(id_inscricao INT AUTO_INCREMENT PRIMARY KEY,
jogador_id INT NOT NULL,
FOREIGN KEY (jogador_id) REFERENCES jogador(id_jogador)
);