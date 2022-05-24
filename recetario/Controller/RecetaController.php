<?php

namespace Controller;

use Model\Receta;


class RecetaController
{
    static function get_receta(int $id = null, int $limit = null, int $offset = null)
    {
        $recipe = new Receta();

        if (is_null($id)) {
            return $recipe->get_all($limit, $offset);
        } else {
            return $recipe->get_receta($id);
        }
    }

    static function get_receta_json(int $id = null, int $limit = null, int $offset = null): void
    {
        header('Content-Type: application/json');

        $recipe = new Receta();

        if (is_null($id)) {
            $recipe->get_all();
            echo json_encode($recipe->manny);
        } else {
            $recipe->get_receta($id);
            echo json_encode($recipe);
        }
    }

    static function get_id_receta_by_title(string $title): void
    {
        $id = array(
            'id' => (new Receta)->search_id_receta_by_title($title),
            'status' => 200
        );
        echo json_encode($id);
    }

    static function new_receta(
        string $title,
        array $pasos,
        array $materiales,
        array $image=null
    ) : void
    {
        $recipe = new Receta();

        $id_receta = $recipe->new_receta_titulo($title);

        for ($i=0 ; $i < sizeof($pasos); $i++) {
            $recipe->set_paso($id_receta, $i, $pasos[$i]);
        }
        for ($i=0 ; $i < sizeof($materiales); $i++) {
            $recipe->set_material($id_receta, $i, $materiales[$i]);
        }
        if ($image['size']!=0) {
            $file = fopen($image['tmp_name'], 'rb');
            $recipe->set_imagen($id_receta,$file);
        }
        echo json_encode(['status' => 200, 'titulo' => $title]);
    }

    static function update_receta(
        int $id_receta,
        string $title,
        array $pasos,
        array $materiales,
        array $image=null,
        bool $borrar_imagen=false
    ) : void
    {
        $recipe = new Receta();
        if (isset($image['size'])) {
            if ($image['size'] != 0) {
                $file = fopen($image['tmp_name'], 'rb');
                $recipe->set_imagen($id_receta, $file);
            }
        }
        if ($borrar_imagen) {
            $recipe->set_imagen($id_receta,null);
        }

        $recipe->delete_pasos_receta($id_receta);
        for ($i=0 ; $i < sizeof($pasos); $i++) {
            $recipe->set_paso($id_receta, $i, $pasos[$i]);
        }
        $recipe->delete_materiales_receta($id_receta);
        for ($i=0 ; $i < sizeof($materiales); $i++) {
            $recipe->set_material($id_receta, $i, $materiales[$i]);
        }
        $recipe->set_titulo($id_receta, $title);
        self::get_receta("$id_receta");

        echo json_encode(['status' => 200, 'titulo' => $title]);

    }
}
