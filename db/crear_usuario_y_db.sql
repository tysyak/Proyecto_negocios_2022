CREATE USER 'chef'@'localhost'
  IDENTIFIED BY 'Hola1234!';

GRANT ALL PRIVILEGES ON *.* TO 'chef'@'192.168.1.%';

GRANT ALL PRIVILEGES ON *.* TO 'chef'@'localhost';

create database recipes;

grant all privileges on recipes.* TO 'chef'@'localhost';

grant all privileges on recipes.* TO 'chef'@'%';

flush privileges;