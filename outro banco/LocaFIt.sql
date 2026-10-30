create database LocaFit;

use LocaFit;

CREATE TABLE locador(
id int primary key auto_increment,
nome varchar(100),
senha varchar(100),
imagem varchar(100),
data_criacao TIMESTAMP DEFAULT current_timestamp,
email varchar(100) UNIQUE,
tipo_usuario ENUM('locador','locatario') NOT NULL
);

	CREATE TABLE produtos(
    idprod int primary key auto_increment,
    iduser int,
    nome varchar(100),
    descricao TEXT,
    preco decimal(10,2),
    imagem varchar(100),
    categoria varchar(100),
    alugado BOOLEAN DEFAULT FALSE,
    media_avaliacao decimal(3,2) DEFAULT 0.00,
    FOREIGN KEY (iduser) references locador(id)
    );
    
CREATE TABLE comentarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    iduser INT,
    idprod INT,
    comentario TEXT,
    avaliacao INT CHECK (avaliacao BETWEEN 1 AND 5),
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    foreign key (idprod) references produtos(idprod),
    FOREIGN KEY (iduser) REFERENCES locador(id)
);

CREATE TABLE solicitacoes(
id INT PRIMARY KEY AUTO_INCREMENT,
idprod int,
id_locatario INT,
data_inicio DATE,
data_fim DATE,
status ENUM ('pendente', 'aceito', 'recusado') DEFAULT 'pendente',
FOREIGN KEY (idprod) REFERENCES produtos(idprod),
FOREIGN KEY (id_locatario) REFERENCES locador(id)
);

CREATE TABLE notificacoes(
id INT AUTO_INCREMENT PRIMARY KEY,
idprod INT,
idsolicitante INT,
data_inicio DATE,
data_fim date,
status ENUM('pendente','aprovado', 'rejeitado') DEFAULT 'pendente',
FOREIGN KEY (idprod) REFERENCES locador(id),
FOREIGN KEY (idsolicitante) REFERENCES locador(id)
);