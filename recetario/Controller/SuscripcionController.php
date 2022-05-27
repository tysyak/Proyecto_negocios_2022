<?php

namespace Controller;

use Model\Suscripcion;

class SuscripcionController
{
    public static function get_all(): array
    {
        $sub = new Suscripcion();

        return $sub->get_suscripcion_all();
    }

    public static function nueva_sub(int $id_sub, int $id_usuario) : void
    {
        $sub = new Suscripcion();

        $sub->nueva_sub($id_sub, $id_usuario);

        echo '{ "status": 201, "msg": "Enhorabuena, Ahora eres Premium'.'<meta http-equiv=\'refresh\' content=\'1; url=/subscripcion/nuevo \'/>'.'" }';
    }

    public static function get_info_sub(int $id_usuario, bool $echo=false) : array
    {
        $sub = new Suscripcion();
        $info_sub = $sub->info_sub($id_usuario);
        $info_sub_desc = $sub->get_suscripcion($info_sub['id_subscripcion']);

        $info_sub['inicio'] = strtotime($info_sub['inicio']);
        $info_sub['fin'] = strtotime($info_sub['fin']);
        $fin = getdate($info_sub['fin']);
        $ret = [
            'activo' => getdate()[0] <= $info_sub['fin'],
            'fecha_termino' => [
                'day' => $fin['mday'],
                'month'=> $fin['mon'],
                'year' => $fin['year']
            ],
            'detalle' => [
                'titulo' => $info_sub_desc['titulo'],
                'precio' => $info_sub_desc['precio'],
                'desc' => $info_sub_desc['descripcion'],
                'id' => $info_sub_desc['id']
            ]
        ];
        if ($echo) {
            header('Content-Type: application/json');
            echo json_encode($ret);
        }
        return $ret;

    }

    public static function tiene_sub_activa(int $id_usuario)
    {
        $sub = new Suscripcion();
        $resp = $sub->sub_activa_usuario($id_usuario);
        $no_sub_msg = ["status" => 200, "msg" => "No tiene subscripcion activa", "resp" => false];
        $yes_sub_msg = ["status"=> 200, "msg" => "Si tiene subscripcion activa", "resp" => true];
        if (!$resp) {
            return $no_sub_msg;
        } else {
            if (getdate()[0] <= strtotime($resp['fin'])){
                return $yes_sub_msg;
            } else {
                return $no_sub_msg;
            }
        }
    }
}