<?php
namespace Model;

use PDO;
use PDOException;
use PDOStatement;
use stdClass;

class Receta
{
    private PDO $db;
    public int $id;
    public string $titulo;
    public array $materiales;
    public array $pasos;
    public array $manny;
    public bool $favorito;
    public int|null $usuario_creador;
    public string|null $image;

    public function __construct()
    {
        $this->db = new DataBase();
    }

    public function get_receta(int $id, int $id_usuario=null): array
    {
        if (is_null($id_usuario)) {
            $query = 'SELECT id, titulo, imagen, usuario_creador FROM receta where id = :id order by id desc ';
        } else {
            $query = 'SELECT r.id,r.titulo,if(ur.id_usuario = :id_usuario, true, false) favorito, r.imagen, r.usuario_creador FROM receta r 
                       left join usuario_receta ur on ur.id_receta = r.id
                       where r.id = :id';
        }
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        if (!is_null($id_usuario)) {
            $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        }
        $stmt->execute();
        $resp = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($resp) {
            $this->id = $resp['id'];
            $this->titulo = $resp['titulo'];
            $this->image = $resp['imagen'] ?? null;
            $this->usuario_creador = $receta['usuario_creador'] ?? null;
            if (isset($resp['favorito'])){
                $this->favorito = !($resp['favorito'] == 0);
            } else {
                $this->favorito = false;
            }
            if (!is_null($this->image)) {
                $this->image = base64_encode($this->image);
            }
            $this->get_receta_materiales($this->id);
        }
        $this->manny = [];

        return (array)$this;

    }

    public function search_id_receta_by_title(string $titulo): int
    {
        $titulo = strtoupper($titulo);

        $query = "select id from receta where upper(titulo) like :titulo";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':titulo', $titulo);
        $stmt->execute();
        $resp = $stmt->fetch();


        return $resp['id'];
    }

    public function get_all(
        int $id_usuario=null,
        int $limit=null,
        int $offset=null,
        bool $only_user=false,
        bool $only_fav=false
    )
    {
        $this->pasos = [];
        if (is_null($id_usuario)) {
            $query = 'SELECT id, titulo, imagen, usuario_creador FROM receta ';
        } else {
            $query = 'SELECT r.id,r.titulo,if(ur.id_usuario = :id_usuario, true, false) favorito, r.imagen, r.usuario_creador FROM receta r 
                       left join usuario_receta ur on ur.id_receta = r.id 
                       ';
            $query .= ($only_user) ? 'where r.usuario_creador = :id_usuario' : '';
            $query .= ($only_fav) ? 'where ur.id_usuario = :id_usuario' : '';
        }
        $query .= is_null($limit) ? '' : " limit $limit";
        $query .= is_null($offset) ? '' : " offset $offset";
        $stmt = $this->db->prepare($query);
        if (!is_null($id_usuario)) {
            $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        }
        return $this->set_obj($stmt);
    }

    public function get_favorite_recipes_user(int $id_usuario) : array
    {
        $query = 'select id, imagen, titulo, usuario_creador from receta r 
                where exists (
                    select 1 from usuario_receta ur  
                    where ur.id_usuario  = r.usuario_creador  
                      and r.usuario_creador = :id_usuario)';

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        return $this->set_obj($stmt);
    }

    public function set_imagen(int $id, $bin)
    {
        $query = "UPDATE receta SET imagen=:bin WHERE id=:id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id,PDO::PARAM_INT);
        if (is_null($bin)) {
            $stmt->bindParam(':bin', $bin, PDO::PARAM_NULL);
        } else {
            $stmt->bindParam(':bin', $bin, PDO::PARAM_LOB);
        }
        $stmt->execute();
    }

    public function set_titulo(int $id, string $titulo)
    {
        $query = "UPDATE receta SET titulo = :titulo WHERE id=:id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id,PDO::PARAM_INT);
        $stmt->bindParam(':titulo', $titulo);
        $stmt->execute();
    }

    public function set_paso(int $id_receta, int $id_paso, string $descripcion)
    {
        $query = "INSERT INTO receta_pasos(id_receta, id_paso, descripcion, tipo)
                  VALUES(:id_receta, :id_paso, :descripcion, default)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_paso', $id_paso,PDO::PARAM_INT);
        $stmt->bindParam(':id_receta', $id_receta,PDO::PARAM_INT);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->execute();
    }
    public function delete_pasos_receta(int $id_receta){
        $query = 'DELETE FROM receta_pasos
                  WHERE id_receta=:id_receta';
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_receta', $id_receta,PDO::PARAM_INT);
        $stmt->execute();

    }

    public function set_material(int $id_receta, int $id_material, string $descripcion)
    {
        $query = "INSERT INTO receta_materiales(id_receta, id_material, descripcion)
                  VALUES(:id_receta, :id_material, :descripcion)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_material', $id_material,PDO::PARAM_INT);
        $stmt->bindParam(':id_receta', $id_receta,PDO::PARAM_INT);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->execute();
    }

    public function delete_materiales_receta(int $id_receta){
        $query = 'DELETE FROM receta_materiales
                  WHERE id_receta = :id_receta';
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_receta', $id_receta,PDO::PARAM_INT);
        $stmt->execute();

    }

    public function new_receta(string $titulo, string $descripcion, array $pasos, array $materiales, $blob_imagen=null)
    {
        $id_receta = $this->new_receta_titulo($titulo);
        for ($id_paso = 0 ; $id_paso < sizeof($pasos) ; $id_paso++) {
            $this->new_paso_receta($id_receta, $id_paso, $pasos[$id_paso]);
        }
        for ($id_materiales = 0 ; $id_materiales < sizeof($materiales) ; $id_materiales++) {
            $this->new_material_receta($id_receta, $id_materiales, $materiales[$id_materiales]);
        }
        if (!is_null($blob_imagen))
            $this->set_imagen($id_receta, $blob_imagen);

    }

    public function new_paso_receta(int $id_receta, int $id_paso, string $descripcion)
    {
        $query = "INSERT INTO receta_pasos(id_receta, id_paso, descripcion, tipo)
                  VALUES(:id_receta, :id_paso, :descripcion, 'P')";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_receta', $id_receta,PDO::PARAM_INT);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':id_paso', $id_paso);

        $stmt->execute();
    }

    public function new_material_receta(int $id_receta, int $id_material, string $material)
    {
        $query = "INSERT INTO receta_materiales(id_receta, id_material, descripcion)
                  VALUES(:id_receta, :id_material, :material)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_receta', $id_receta,PDO::PARAM_INT);
        $stmt->bindParam(':id_material', $id_material,PDO::PARAM_INT);
        $stmt->bindParam(':descripcion', $material);

        $stmt->execute();
    }

    public function new_receta_titulo(string $titulo): int
    {
        $query = "INSERT INTO receta(titulo, imagen, usuario_creador) VALUES(:titulo, NULL, {$_SESSION['id_usuario']})";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':titulo', $titulo);
        $stmt->execute();

        return $this->search_id_receta_by_title($titulo);
    }

    private function get_receta_materiales(int $id_receta): void
    {
        $query = 'SELECT id_material,descripcion FROM receta_materiales where id_receta = :id_receta order by id_material asc';
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':id_receta', $id_receta, PDO::PARAM_INT);

        $stmt->execute();
        $resp = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($resp) {
            $this->materiales = $resp;
            $this->get_receta_pasos($id_receta);
        }

    }

    private function get_receta_pasos(int $id_receta): void
    {
        $query = 'SELECT id_paso, descripcion FROM receta_pasos where id_receta = :id_receta order by id_paso asc';
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_receta', $id_receta, PDO::PARAM_INT);

        $stmt->execute();
        $resp = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($resp) {
            $this->pasos = $resp;
        }
    }

    /**
     * @param array $pasos
     */
    public function set_pasos(int $id_receta, array $pasos): void
    {
        $this->pasos = $pasos;
    }

    /**
     * @param bool|PDOStatement $stmt
     * @return array
     */
    private function set_obj(bool|PDOStatement $stmt): array
    {
        $stmt->execute();

        $resp = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (!is_null($resp)) {
            foreach ($resp as $receta) {
                $tmp = new stdClass();
                $tmp->id = $receta['id'];
                $tmp->titulo = $receta['titulo'];
                $tmp->imagen = $receta['imagen'] ?? null;
                $tmp->usuario_creador = $receta['usuario_creador'] ?? null;
                if (isset($receta['favorito'])) {
                    $tmp->favorito = !($receta['favorito'] == 0);
                }
                if (!is_null($tmp->imagen)) {
                    $tmp->imagen = base64_encode($tmp->imagen);
                }
                $this->get_receta_materiales($tmp->id);
                $tmp->materiales = $this->materiales;
                $tmp->pasos = $this->pasos;
                $this->manny[] = (array)$tmp;
            }
        }
        return $this->manny;
    }


}
