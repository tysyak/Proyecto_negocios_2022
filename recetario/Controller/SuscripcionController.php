<?php

namespace Controller;

use Model\Suscripcion;

class SuscripcionController
{
    public static function get_all()
    {
        $sub = new Suscripcion();

        return $sub->get_suscripcion_all();
    }
}