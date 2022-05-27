<?php

namespace App\Table;

class GalleriesTable extends Table
{

    public function findFirstGall($id_coll)
    {
        return $this->queryReq("SELECT * FROM GALLERIES WHERE id_coll = $id_coll ORDER BY name_gall LIMIT 1", null, true);
    }

    public function findAllGallFromColl($id_coll) 
    {
        return $this->queryReq("SELECT * FROM GALLERIES WHERE ID_COLL = ? ORDER BY NAME_GALL", [$id_coll]);
    }

    public function findOneGall($id_gall)
    {
        return $this->queryReq("SELECT * FROM GALLERIES WHERE ID_GALL = ? ", [$id_gall], true);
    }
}