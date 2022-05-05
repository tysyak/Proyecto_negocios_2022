
INSERT into receta(titulo) values ('Chilli prawn linguine');

insert into receta_materiales(id_receta,id_paso,descripcion)
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
