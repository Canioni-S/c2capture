<?php

namespace App\Entity;


class CollectionsEntity extends Entity
{
    public function getUrl()
    {
        return "index.php?p=collection&id=" . $this->ID_COLL;
    }
}
