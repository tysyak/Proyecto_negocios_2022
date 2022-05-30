<?php

namespace Model;

use PDO;
use PDOStatement;
use stdClass;

class Suscripcion
{
    private DataBase $db;
    public int $id;
    public string $titulo;
    public string $descripcion;
    public float $precio;
    public int $meses_duracion;
    public array $creation_time;
    public bool $activo;
    public array $manny = [];


    public function __construct()
    {
        $this->db = new DataBase();
    }

    public function get_suscripcion(int $id): array
    {
        $query = 'SELECT id, titulo, descripcion, precio, duracion, creation_time, activo FROM subscripciones
                  where id = :id';
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        $stmt->execute();

        $resp = $stmt->fetch(PDO::FETCH_ASSOC);

        if($resp) {
            $this->set_obj($resp, $this);
            $this->activo = $resp['activo'] == 1;

        }
        $this->manny = [];

        return (array)$this;

    }

    public function get_suscripcion_all(): array
    {
        $query = 'SELECT id, titulo, descripcion, precio, duracion, creation_time, activo FROM subscripciones';
        $stmt = $this->db->prepare($query);
        return $this->set_manny($stmt);

    }

    public function info_sub(int $id_usuario):array
    {
        $query = 'SELECT id, id_subscripcion, id_usuario, inicio, fin
                  FROM usuario_subscripcion
                  WHERE id_usuario = :id_usuario order by fin desc limit 1';
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);

        $stmt->execute();

        $resp = $stmt->fetch(PDO::FETCH_ASSOC);

        $ret = [];

        if($resp) {
            $ret['id'] = $resp['id'];
            $ret['id_subscripcion'] = $resp['id_subscripcion'];
            $ret['id_usuario'] = $resp['id_usuario'];
            $ret['inicio'] = $resp['inicio'];
            $ret['fin'] = $resp['fin'];
        }

        return $ret;
    }

    public function nueva_sub(int $id_sub, int $id_usuario): void
    {
        $target_sub = $this->get_suscripcion($id_sub)['meses_duracion'];
        $query = "INSERT INTO usuario_subscripcion (id_subscripcion, id_usuario, inicio, fin)
                  VALUES(
                         :id_sub, 
                         :id_usuario, 
                         current_timestamp(), 
                         (select current_timestamp() + interval $target_sub month)
                         )";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_sub', $id_sub, PDO::PARAM_INT);
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt->execute();
    }

    private function set_manny(bool|PDOStatement $stmt): array
    {
        $stmt->execute();
        $resp = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (!is_null($resp)) {
            foreach ($resp as $subscripcion) {
                if ($subscripcion['activo'] == 1) {
                    $tmp = new stdClass();

                    $this->set_obj($subscripcion, $tmp);

                    $this->manny[] = (array)$tmp;
                }
            }
        }

        return $this->manny;
    }

    public function sub_activa_usuario(int $id_usuario)
    {
        $query = 'select fin from usuario_subscripcion where id_usuario = :id_usuario order by fin desc limit 1';
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt->execute();
        $resp = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resp;
    }

    /**
     * @param mixed $resp
     * @return void
     */
    private function set_obj(mixed $resp, $obj): void
    {
        $obj->id = $resp['id'];
        $obj->titulo = $resp['titulo'];
        $obj->descripcion = $resp['descripcion'];
        $obj->precio = $resp['precio'];
        $obj->meses_duracion =  $resp['duracion'];
        $obj->creation_time = getdate(strtotime($resp['creation_time']));
    }

}