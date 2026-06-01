CREATE DATABASE IF NOT EXISTS bd_biblioteca; 
USE db_biblioteca; 
 
CREATE TABLE libros ( 
  id          INT PRIMARY KEY AUTO_INCREMENT, 
  titulo      VARCHAR(200) NOT NULL, 
  autor       VARCHAR(150) NOT NULL, 
  isbn        VARCHAR(20) UNIQUE, 
  categoria   VARCHAR(80), 
  stock       INT DEFAULT 1 
); 
 
CREATE TABLE usuarios ( 
  id          INT PRIMARY KEY AUTO_INCREMENT, 
  nombre      VARCHAR(150) NOT NULL, 
  carnet      VARCHAR(20) UNIQUE NOT NULL, 
  telefono    VARCHAR(20), 
  correo      VARCHAR(100) 
); 