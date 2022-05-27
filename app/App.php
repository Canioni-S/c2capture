<?php

namespace App;


class App
{

    private $db_instance;
    private static $_instance;

    public static function getInstance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new App();
        }
        return self::$_instance;
    }

    public static function load()
    {
        require ROOT . '/app/Autoloader.php';
        Autoloader::register();
        return Session::getInstance();
    }

    public static function getAuth()
    {
        return new DBAuth(Session::getInstance(), ["restriction_msg" => "Tu es bloqué !"]);
    }

    public static function redirect($page)
    {
        header("Location: $page");
        exit();
    }

    public function getTable($name)
    {
        $class_name = "\\App\\Table\\" . ucfirst(strtolower($name)) . "Table";
        return new $class_name($this->getDB());
    }

    public function getDB()
    {
        $config = Config::getInstance(ROOT . "/config/config.php");
        if (is_null($this->db_instance)) {
            $this->db_instance = new Database($config->get('db_name'), $config->get('db_user'), $config->get('db_pass'), $config->get('db_host'));
        }
        return $this->db_instance;
    }

    public function forbidden(){
        header("HTTP/1.0 403 Forbidden");
        die("Acces interdit");
    }

    public function notFound(){
        header("HTTP/1.0 404 Not Found");
        die("Page introuvable");
    }
}
