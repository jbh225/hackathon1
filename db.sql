# creation de la database alimentation
# note : il faut se connecter en root pour lancer ce script

# on fait d'abord le menage
DROP DATABASE IF EXISTS alimentation;
# puis on créé la database (avec utf-8)
CREATE DATABASE alimentation DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci;

# on cree ensuite le user pour la gerer
GRANT all ON alimentation.* TO 'patoche' IDENTIFIED BY 'fooD';

# on selectionne la database
USE alimentation;

# on cree la table sports
DROP TABLE IF EXISTS sports;
CREATE TABLE sports (
  idsport INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  sport VARCHAR(100),
  calories INT DEFAULT 0
) DEFAULT CHARACTER SET=utf8;

# controle
DESCRIBE sports;

# on cree la table intensite
DROP TABLE IF EXISTS intensite;
CREATE TABLE intensite (
  idintensite INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  libelle VARCHAR(100),
  idsport INT,
  calories INT
) DEFAULT CHARACTER SET=utf8;


# controle
DESCRIBE intensite;

