<?php

namespace App\Table;

use App\Database;

class Table
{
    
    protected $table;
    protected $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
        if (is_null($this->table)) {
            $parts = explode('\\', get_class($this));
            $class_name = end($parts);
            $this->table = strtolower(str_replace('Table', '', $class_name));
        }
    }

    public function findAll()
    {
        return $this->queryReq("SELECT * FROM  " . strtoupper($this->table));
    }

    public function queryReq($statement, $attributes = null, $one = false)
    {
        if ($attributes) {
            return $this->db->prepareReq(
                $statement,
                $attributes,
                str_replace("Table", "Entity", get_class($this)),
                $one
            );
        } else {
            return $this->db->queryReq(
                $statement,
                str_replace("Table", "Entity", get_class($this)),
                $one
            );
        }
    }
}
