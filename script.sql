CREATE DATABASE camhist DEFAULT CHARACTER SET utf8;
USE camhist;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE cameras (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    cliente_nome VARCHAR(255) NOT NULL,
    endereco VARCHAR(255),
    ip VARCHAR(15),
    descricao TEXT,
    status INT NOT NULL
);

CREATE TABLE registros (
    id INT AUTO_INCREMENT PRIMARY KEY,
    evento TEXT NOT NULL,
    camera_id INT,
    data_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    it2m INT,
    data_abertura DATE,
    data_fechamento DATE,
    responsavel TEXT,
    descricao TEXT,
    FOREIGN KEY (camera_id) REFERENCES cameras(id) ON DELETE CASCADE
);
