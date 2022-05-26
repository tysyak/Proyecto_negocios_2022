<?php
namespace Model;

use PDO;
use PDOException;
/**
 * Clase encargada de manipular a los usuarios
 */
class Usuario
{
    private PDO $db;
    public string $username;
    public int $id;
    public bool $outcome;
    public array $creation_time;
    public array $modification_time;
    public array $manny;


    public function __construct()
    {
        $this->db = new DataBase();
    }

    /**
     * Insert an user un the DB
     * @param string $username
     * @return void
     */
    public function set_usuario(string $username): void
    {
        $query = 'insert into usuario(username) values (:username)';
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':username', $username);

        try {
            $this->outcome = $stmt->execute();
        } catch (PDOException $ex) {
            echo 'Error usuario duplicado';
            $this->outcome = false;
        }
    }

    public function check_user_password(string $username, string $hash_password) :bool
    {
        $query = 'select true as val from usuario_password 
         where usuario = :username and password = :password';

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $hash_password);

        $stmt->execute();

        $resp = $stmt->fetch(PDO::FETCH_ASSOC);

        return isset($resp['val']);

    }

    public function set_password(string $username, string $password)
    {
        $query = 'INSERT INTO usuario_password(usuario, password)VALUES(:username, :password)';
        $password = hash('sha512', $password);

        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);

        $this->outcome = $stmt->execute();

    }

    public function es_favorito(int $id_usuario, int $id_receta) : bool
    {
        $query = 'SELECT true val from receta r 
            inner join usuario_receta ur on r.id = ur.id_receta 
            where ur.id_usuario = :id_usuario and ur.id_receta = :id_receta';

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt->bindParam(':id_receta', $id_receta, PDO::PARAM_INT);

        $stmt->execute();

        $resp = $stmt->fetch(PDO::FETCH_ASSOC);

        return $resp!=false;
    }

    public function add_favorito(int $id_usuario, int $id_receta)
    {
        $query = 'INSERT INTO usuario_receta (id_usuario, id_receta) VALUES(:id_usuario, :id_receta)';
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt->bindParam(':id_receta', $id_receta, PDO::PARAM_INT);

        $stmt->execute();
    }

    public function del_favorito(int $id_usuario, int $id_receta)
    {
        $query = 'DELETE FROM usuario_receta WHERE id_usuario = :id_usuario AND id_receta = :id_receta';
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt->bindParam(':id_receta', $id_receta, PDO::PARAM_INT);

        $stmt->execute();
    }


    /**
     * Get a user from db
     * @param string $username
     * @return void
     */
    public function get_usuario(string $username): array
    {
        $query = "select id, username, creation_time, modification_time from usuario where upper(username) = upper(:username)";
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':username', $username);

        $stmt->execute();
        $resp = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($resp) {
            $this->set($resp['id'],$resp['username'],$resp['creation_time'],$resp['modification_time'],true);
        }
        return (array)$this;
    }

    /**
     * Select the entire database. it is recommended to use limit and offset to avoid full access table
     * @param int|null $limit
     * @param int|null $offset
     * @return void
     */
    public function get_all(int $limit=null, int $offset=null): void
    {
        $query = 'SELECT id, username, creation_time, modification_time from usuario';
        $query .= is_null($limit) ? '' : " limit $limit";
        $query .= is_null($offset) ? '' : " offset $offset";

        $stmt = $this->db->prepare($query);

        $stmt->execute();

        $resp = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->set_all($resp);
        $this->outcome = true;
    }

    /**
     * Automatic setter for individual parameters
     * @param int $id
     * @param string $username
     * @param string $creation_time
     * @param string $modification_time
     * @param bool $outcome
     * @return void
     */
    private function set(
        int $id=0,
        string $username='',
        string $creation_time='0001-01-01 00:00:01.000',
        string $modification_time='0001-01-01 00:00:01.000',
        bool $outcome=false
    ) : void
    {
        $this->id = $id;
        $this->username = $username;
        $this->creation_time = getdate(strtotime($creation_time));
        $this->modification_time = getdate(strtotime($modification_time));
        $this->outcome = $outcome;
        $this->manny = array();
    }

    private function set_all(array $manny_users): void
    {
        $i = 0;
        while ($i != count($manny_users)) {
            $manny_users[$i] = (object) $manny_users[$i];
            $manny_users[$i]->creation_time  = (object) getdate(strtotime($manny_users[$i]->creation_time));
            $manny_users[$i]->modification_time  = (object) getdate(strtotime($manny_users[$i]->modification_time));
            $i++;
        }
        $this->manny = $manny_users;
    }
}
