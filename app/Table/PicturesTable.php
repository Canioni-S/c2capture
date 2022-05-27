<?php

namespace App\Table;

class PicturesTable extends Table
{

    public function findFirstPic($id_gall)
    {
        return $this->queryReq("SELECT * FROM PICTURES WHERE id_gall = $id_gall LIMIT 1", null, true);
    }

    function getAllPicByGall($id_gall)
    {
        return $this->queryReq("SELECT * FROM PICTURES WHERE id_gall = ? ORDER BY added_at DESC", [$id_gall]);
    }
}
