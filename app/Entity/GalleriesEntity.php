<?php

namespace App\Entity;


class GalleriesEntity extends Entity
{
    
    public function getUrl()
    {
        return "index.php?p=gallery&id=" . $this->ID_GALL;
    }
}
