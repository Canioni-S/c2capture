<?php

namespace App\Table;

class PicturesTable extends Table
{

    public function findFirstPic($id_gall)
    {
        return $this->queryReq("SELECT * FROM PICTURES WHERE id_gall = $id_gall LIMIT 1", null, true);
    }
}
