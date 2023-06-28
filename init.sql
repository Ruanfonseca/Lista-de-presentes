create database  casamentodb;

CREATE TABLE Disponiveis(
codigo int PRIMARY KEY AUTO_INCREMENT,
presentedisponivel varchar(30) NOT NULL
);
-- Insertar datos para "geladeira"
INSERT INTO Disponiveis (presentedisponivel) VALUES ('geladeira');

-- Insertar datos para "fogao"
INSERT INTO Disponiveis (presentedisponivel) VALUES ('fogao');

-- Insertar datos para "sofa"
INSERT INTO Disponiveis (presentedisponivel) VALUES ('sofa');

-- Insertar datos para "cama"
INSERT INTO Disponiveis (presentedisponivel) VALUES ('cama');

-- Insertar datos para "televisão"
INSERT INTO Disponiveis (presentedisponivel) VALUES ('televisão');

-- Insertar datos para "mesa"
INSERT INTO Disponiveis (presentedisponivel) VALUES ('mesa');

-- Insertar datos para "pia"
INSERT INTO Disponiveis (presentedisponivel) VALUES ('pia');

-- Insertar datos para "vaso sanitário"
INSERT INTO Disponiveis (presentedisponivel) VALUES ('vaso sanitário');

CREATE TABLE escolhidos(
codigo int PRIMARY KEY AUTO_INCREMENT,
presente varchar(30) NOT NULL,
nome varchar(20) NOT NULL,
telefone varchar(30) NOT NULL
);

