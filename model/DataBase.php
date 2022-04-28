<?php
namespace Model\DataBase;

use PDO;
use PDOException;

class DataBase extends PDO
{
    protected PDO $conn;

    public function __construct(
        string $driver=DRIVER,
        string $host=HOST,
        string $dbname=DBNAME,
        string $port=PORT,
        string $user_db=USER_DB,
        string $pass_db=PASS_DB
    )
    {
        try {
            $this->connn = parent::__construct(
                $driver.
                ':host='.$host.
                ';dbname='.$dbname.
                ';port='.$port,
                $user_db,
                $pass_db
            );
        } catch(PDOException $ex) {
            echo 'Error: '.$ex->getMessage();
        }
    }
}

