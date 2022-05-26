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
    public array $manny;


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
        $obj->meses_duracion =  getdate(strtotime($resp['duracion']));
        $obj->creation_time = $resp['creation_time'];
    }

}