create table usuario (
  id serial primary key,
  username varchar(32) unique,
  creation_time timestamp default CURRENT_TIMESTAMP(),
  modification_time timestamp default CURRENT_TIMESTAMP()
    ON UPDATE current_timestamp()
);


create table datos_usuario (
  username varchar(32) primary key references usuario(username),
  nombre varchar(32) not null,
  apellido_paterno varchar(32) not null,
  apellido_materno varchar(32) null,
  fecha_nacimiento date null,
  estatura int default 0, -- centimetros enteros
  peso decimal(5,2) default 0.0,
  modification_time timestamp default CURRENT_TIMESTAMP()
    ON UPDATE current_timestamp()
);

create table usuario_password(
    usuario varchar(32) primary key  references usuario(username) ,
    password varchar(255) not null
);

create table receta (
  id serial primary key,
  imagen longblob null,
  titulo varchar(32) not null unique,
  usuario_creador bigint(20) unsigned
);

create table receta_pasos_tipo_catalogo(
  tipo char(1) primary key,
  descripcion varchar(50) not null
);

INSERT into receta_pasos_tipo_catalogo(tipo, descripcion)
values('P', 'Pasos de la Receta');
INSERT into receta_pasos_tipo_catalogo(tipo, descripcion)
values('M', 'Materiales e ingredientes de la receta');

create table receta_pasos (
  id_receta bigint(20) unsigned references receta(id),
  id_paso int unsigned not null,
  descripcion text not null,
  tipo char(1) default 'P' references receta_pasos_tipo_catalogo(tipo),
 primary key(id_receta, id_paso)
);

create table receta_materiales (
  id_receta bigint(20) unsigned references receta(id),
  id_material int unsigned not null,
  descripcion text not null,
  primary key(id_receta, id_material)
);


create table usuario_receta(
    id_usuario bigint(20) unsigned references usuario(id),
    id_receta bigint(20) unsigned references receta(id),
    primary key (id_usuario, id_receta)
);

create table subscripciones(
    id serial primary key,
    titulo varchar(50) not null ,
    descripcion text not null ,
    precio decimal(5,2) not null ,
    duracion int unsigned not null , -- en meses
    creation_time timestamp default CURRENT_TIMESTAMP(),
    activo bool default true
);

create table usuario_subscripcion(
    id serial primary key,
    id_subscripcion bigint(20) unsigned not null references subscripciones(id)  ,
    id_usuario bigint(20) unsigned not null references usuario(id)  ,
    inicio timestamp default CURRENT_TIMESTAMP(),
    fin timestamp not null -- this.incio + interval duracion MONTH
);

CREATE view historico_subscripciones as
select
    u.id as id_usuario ,
    u.username as usuario,
    s.id as id_subscripcion,
    s.titulo as titulo_subscripcion,
    us.inicio as inicio_subscripcion,
    us.fin as fin_subscripcion,
    CURRENT_DATE() <= us.fin as subscripcion_activa,
    s.precio as precio
from usuario_subscripcion us
         inner join subscripciones s ON s.id = us.id_subscripcion
         INNER join usuario u on u.id = us.id_usuario ;
