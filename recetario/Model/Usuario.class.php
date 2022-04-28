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
    public object $creation_time;
    public object $modification_time;
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
    public function set_usuario(string $username)
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

    /**
     * Get a user from db
     * @param string $username
     * @return void
     */
    public function get_usuario(string $username)
    {
        $query = "select id, username, creation_time, modification_time from usuario where username = :username";
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':username', $username);

        $stmt->execute();
        $resp = $stmt->fetch();
        if ($resp) {
            $this->set($resp[0],$resp[1],$resp[2],$resp[3],true);
        }
        $this->set();
    }

    /**
     * Select the entire database. it is recommended to use limit and offset to avoid full access table
     * @param int|null $limit
     * @param int|null $offset
     * @return void
     */
    public function get_all(int $limit=null, int $offset=null)
    {
        $query = 'SELECT id, username, creation_time, modification_time from usuario';
        $query .= (!is_null($limit)) ? " limit $limit" : '';
        $query .= (!is_null($offset)) ? " offset $offset" : '';

        $stmt = $this->db->prepare($query);

        $stmt->execute();

        $resp = $stmt->fetchAll();
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
    )
    {
        var_dump(strtotime($creation_time));
        $this->id = $id;
        $this->username = $username;
        $this->creation_time = (object) getdate(strtotime($creation_time));
        $this->modification_time = (object) getdate(strtotime($modification_time));
        $this->outcome = $outcome;
        $this->manny = array();
    }

    private function set_all(array $manny_users)
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