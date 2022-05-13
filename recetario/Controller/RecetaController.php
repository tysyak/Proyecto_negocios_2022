<?php

namespace Controller;

use Model\Receta;

class RecetaController
{

    static function get_receta(string $id = null): void
    {
        $recipe = new Receta();

        if (is_null($id)) {
            echo json_encode($recipe->get_all());
        } else {
            $recipe->get_receta((int)$id);
            echo json_encode($recipe);
        }
    }
}