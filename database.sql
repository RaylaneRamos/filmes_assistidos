CREATE DATABASE `filmes_assistidos`;

USE `filmes_assistidos`;

CREATE TABLE `filmes` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `titulo` VARCHAR(255) NOT NULL,
    `ano` INT,
    `assistido` BOOLEAN DEFAULT FALSE
);
