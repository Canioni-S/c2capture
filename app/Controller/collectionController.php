<?php

namespace App\Controller;

use App\App;

class CollectionController extends AppController
{
    public function index()
    {
        $collections = App::getInstance()->getTable('COLLECTIONS')->findAll();
        $title = "Acceuil";
        $extraCss = "home";

        $this->render("blog.home", compact("collections", "picture", "title", "extraCss"));
    }

    public function showCollection()
    {
        $collection = App::getInstance()->getTable('COLLECTIONS')->findOne(htmlentities($_GET['id']));
        $galleries = App::getInstance()->getTable('GALLERIES')->findAllGallFromColl($collection->ID_COLL);

        $this->render("blog.collection", compact("collection", "galleries"));
    }

    public function showGallery()
    {
        $gallery = App::getInstance()->getTable('GALLERIES')->findOneGall(htmlentities($_GET['id']));
        $pictures = App::getInstance()->getTable('PICTURES')->getAllPicByGall($gallery->ID_GALL);

        $title =  $gallery->NAME_GALL;
        $extraCss = "gallery";

        $this->render("blog.gallery", compact("gallery", "pictures", "title", "extraCss"));
    }
}
