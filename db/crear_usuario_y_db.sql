CREATE USER 'chef'@'localhost'
  IDENTIFIED BY 'Hola1234!';

GRANT ALL PRIVILEGES ON *.* TO 'chef'@'192.168.1.%'
  IDENTIFIED BY 'Hola1234!' WITH GRANT OPTION;

create database recipes;

grant all privileges on recipes.* TO 'chef'@'localhost'
  identified by 'Hola1234!';

grant all privileges on recipes.* TO 'chef'@'%'
  identified by 'Hola1234!';

flush privileges;
