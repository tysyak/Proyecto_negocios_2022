<?php

namespace Controller;

use Model\Receta;

header('Content-Type: application/json');

class RecetaController
{
    public const JSON_MODE = true;

    static function get_receta(string $id = null, bool $mode=false)
    {
        $recipe = new Receta();

        if (is_null($id)) {
            if (!$mode) {
                return $recipe->get_all();
            }
            echo json_encode($recipe->get_all());
        } else {
            if (!$mode) {
                return $recipe->get_receta((int)$id);
            }
            $recipe->get_receta((int)$id);
            echo json_encode($recipe);
        }
    }

    static function get_id_receta_by_title(string $title, $mode=false): void
    {
        $id = array(
            'id' => (new Receta)->search_id_receta_by_title($title)
        );
        echo json_encode($id);
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
        if ($image['size']!=0) {
            $file = fopen($image['tmp_name'], 'rb');
            $recipe->set_imagen($id_receta,$file);
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
        self::get_receta("$id_receta", self::JSON_MODE);
    }
}
