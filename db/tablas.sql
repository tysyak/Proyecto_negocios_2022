create or replace table usuario (
  id serial primary key,
  username varchar(32) unique,
  creation_time timestamp default CURRENT_TIMESTAMP(),
  modification_time timestamp default CURRENT_TIMESTAMP()
    ON UPDATE current_timestamp(),
);


create or replace table datos_usuario (
  username varchar(32) primary key references usuario(username),
  nombre varchar(32) not null,
  apellido_paterno varchar(32) not null,
  apellido_materno varchar(32) null,
  fecha_nacimienro date not null,
  estatura int default 0, -- centimetros enteros
  peso number(5,2) default 0.0,
  modification_time timestamp default CURRENT_TIMESTAMP()
    ON UPDATE current_timestamp(),
);
