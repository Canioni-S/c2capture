<?php

class Database
{
    private $pdo;

    public function __construct($host, $db_name, $login, $password)
    {
        $this->pdo = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8", $login, $password);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    }

    /**
     * @param [type] $statment
     * @param boolean|array $params
     * @return PDOStatement
     */
    public function queryReq($statement, $params = false)
    {
        if ($params) {
            $req = $this->pdo->prepare($statement);
            $req->execute($params);
        } else {
            $req = $this->pdo->query($statement);
        }
        return $req;
    }

    public function lastInsertId(){
        return $this->pdo->lastInsertId();
    }
}
