<?php
namespace Model;

use PDO;
use PDOException;

class Receta
{
    private PDO $db;
    public int $id;
    public string $titulo;
    public array $materiales;
    public array $pasos;
    public array $manny;
    public $image;

    public function __construct()
    {
        $this->db = new DataBase();
    }

    public function get_receta(int $id): void
    {
        $query = 'SELECT id, titulo, imagen FROM receta where id = :id order by id desc ';
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $resp = $stmt->fetch();

        if ($resp) {
            $this->id = $resp[0];
            $this->titulo = $resp[1];
            $this->image = $resp[3] ?? null;
            $this->get_receta_materiales($this->id);
        }
        $this->manny = [];

    }

    public function search_receta_by_title(string $titulo)
    {
        $titulo = strtoupper($titulo);
        $query = "select id from receta where titulo like '%:titulo%'";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':titulo', $titulo);
        $stmt->execute();
    }

    public function get_all(int $limit=null, int$offset=null)
    {
        $query = 'SELECT id, titulo, imagen FROM receta order by id desc';
        $query .= is_null($limit) ? '' : " limit $limit";
        $query .= is_null($offset) ? '' : " offset $offset";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $resp = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (!is_null($resp)) {
            foreach ($resp as $receta) {
                $tmp = new \stdClass();
                $tmp->id = $receta['id'];
                $tmp->titulo = $receta['titulo'];
                $tmp->imagen = $receta['imagen'] ?? null;
                $this->get_receta_materiales($tmp->id);
                $tmp->materiales = $this->materiales;
                $tmp->pasos = $this->pasos;
                $this->manny[] = $tmp;
            }
        }
        return $this->manny;
    }

    public function set_imagen(int $id, $bin)
    {
        $query = "UPDATE receta SET imagen=:bin WHERE id=:id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id,PDO::PARAM_INT);
        $stmt->bindParam(':bin', $bin, PDO::PARAM_LOB);
        $stmt->execute();
    }

    private function get_receta_materiales(int $id_receta): void
    {
        $query = 'SELECT id_material,descripcion FROM receta_materiales where id_receta = :id_receta order by id_material desc';
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':id_receta', $id_receta, PDO::PARAM_INT);

        $stmt->execute();
        $resp = $stmt->fetchAll(PDO::FETCH_ASSOC);
        var_dump($resp);

        if ($resp) {
            $this->materiales = $resp;
            $this->get_receta_pasos($id_receta);
        }

    }

    private function get_receta_pasos(int $id_receta): void
    {
        $query = 'SELECT id_paso, descripcion FROM receta_pasos where id_receta = :id_receta order by id_paso desc';
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_receta', $id_receta, PDO::PARAM_INT);

        $stmt->execute();
        $resp = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($resp) {
            $this->pasos = $resp;
        }
    }



}
