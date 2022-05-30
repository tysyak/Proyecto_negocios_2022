-- Datos de Prueba, 5 usuario, una receta y tres subscripciones

-- Datos Para Recetas

INSERT into receta(titulo) values ('Chilli prawn linguine');

insert into receta_materiales(id_receta,id_material,descripcion)
values (1,1,'Linguine Pasta ( 280g )'),
(1,2,'Sugar Snap Peas ( 200g )'),
(1,3,'Olive Oil ( 2 tblsp )'),
(1,4,'Garlic Clove ( 2 cloves chopped )'),
(1,5,'Red Chilli ( 1 large )'),
(1,6,'King Prawns ( 24 Skinned )'),
(1,7,'Cherry Tomatoes ( 12 )'),
(1,8,'Basil Leaves ( Handful )'),
(1,9,'Lettuce ( Leaves )'),
(1,10,'Bread ( to serve )'),
(1,11,'Fromage Frais ( 2 tbsp )'),
(1,12,'Lime ( Grated Zest of 2 )'),
(1,13,'Caster Sugar ( 2 tsp )');

INSERT INTO receta_pasos(id_receta, id_paso, descripcion, tipo)
VALUES(1, 1,
'Mix the dressing ingredients in a small bowl and season with salt and pepper. Set aside. Cook the pasta according to the packet instructions. Add the sugar snap peas for the last minute or so of cooking time. Meanwhile, heat the oil in a wok or large frying pan, toss in the garlic and chilli and cook over a fairly gentle heat for about 30 seconds without letting the garlic brown. Tip in the prawns and cook over a high heat, stirring frequently, for about 3 minutes until they turn pink. Add the tomatoes and cook, stirring occasionally, for 3 minutes until they just start to soften. Drain the pasta and sugar snaps well, then toss into the prawn mixture. Tear in the basil leaves, stir, and season with salt and pepper. Serve with salad leaves drizzled with the lime dressing, and warm crusty bread.'
, 'P');


-- Datos para usuarios, las contraseñas par ambas son system

INSERT INTO usuario (username, creation_time, modification_time) VALUES('cumman', '2022-04-27 17:28:32.000', '2022-04-27 17:28:32.000');
INSERT INTO usuario (username, creation_time, modification_time) VALUES('tysyak', '2022-04-28 13:36:39.000', '2022-04-28 13:36:39.000');
INSERT INTO usuario (username, creation_time, modification_time) VALUES('mascrit', '2022-04-28 13:40:26.000', '2022-04-28 13:40:26.000');
INSERT INTO usuario (username, creation_time, modification_time) VALUES('haya', '2022-04-28 13:40:26.000', '2022-04-28 13:40:26.000');
INSERT INTO usuario (username, creation_time, modification_time) VALUES('busha', '2022-04-28 13:40:26.000', '2022-04-28 13:40:26.000');


INSERT INTO usuario_password (usuario, password) VALUES('tysyak', '59a94a0ac0f75200d1477d0f158a23d7feb08a2db16d21233b36fc8fda1a958c1be52b439f7957733bd65950cdfa7918b2f76a480ed01bb6e4edf4614eb8a708');
INSERT INTO usuario_password (usuario, password) VALUES('cumman', '59a94a0ac0f75200d1477d0f158a23d7feb08a2db16d21233b36fc8fda1a958c1be52b439f7957733bd65950cdfa7918b2f76a480ed01bb6e4edf4614eb8a708');
INSERT INTO usuario_password (usuario, password) VALUES('mascrit', '59a94a0ac0f75200d1477d0f158a23d7feb08a2db16d21233b36fc8fda1a958c1be52b439f7957733bd65950cdfa7918b2f76a480ed01bb6e4edf4614eb8a708');
INSERT INTO usuario_password (usuario, password) VALUES('haya', '59a94a0ac0f75200d1477d0f158a23d7feb08a2db16d21233b36fc8fda1a958c1be52b439f7957733bd65950cdfa7918b2f76a480ed01bb6e4edf4614eb8a708');
INSERT INTO usuario_password (usuario, password) VALUES('busha', '59a94a0ac0f75200d1477d0f158a23d7feb08a2db16d21233b36fc8fda1a958c1be52b439f7957733bd65950cdfa7918b2f76a480ed01bb6e4edf4614eb8a708');

INSERT INTO datos_usuario (username, nombre, apellido_paterno, apellido_materno, fecha_nacimiento, estatura, peso, modification_time) VALUES('TYSYAK', 'Cristian', 'Romero', 'Andrade', '1997-07-15', 119, 60.00, '2022-05-29 17:58:18.000');

-- Datos para vender subs

INSERT INTO subscripciones (titulo, descripcion, precio, duracion, creation_time, activo) VALUES('Basico Mensual', 'Lista de favoritos hasta 100 recetas', 49.90, 1, '2022-05-26 15:37:38.000', 1);
INSERT INTO subscripciones (titulo, descripcion, precio, duracion, creation_time, activo) VALUES('Basico Trimestral', 'Lista de favoritos hasta 100 recetas

Ahorras 30 pesos a comparación a plan Basico Mensual', 119.70, 3, '2022-05-26 15:39:57.000', 1);
INSERT INTO subscripciones (titulo, descripcion, precio, duracion, creation_time, activo) VALUES('Basico Anual', 'Lista de favoritos hasta 100 recetas

Ahorras 120 pesos a comparación al plan Basico Mensual', 358.80, 12, '2022-05-26 15:41:07.000', 1);
