<?php

namespace App\Controller;

class AppController extends Controller{

    protected $template = "default";

    public function __construct(){
        $this->viewPath = ROOT . "/app/View/";
    }

}