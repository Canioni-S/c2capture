<?php

namespace App\Table;

class CollectionsTable extends Table
{
    public function findOne($id_coll) {
        return $this->queryReq("SELECT * FROM  COLLECTIONS WHERE ID_COLL = ?", [$id_coll], true);
    }
}
