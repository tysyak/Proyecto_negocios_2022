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
}
