<?php
class App
{

    static $db = null;

    static function getDB()
    {
        if (!self::$db) {
            self::$db = new Database('mysql-c2p.alwaysdata.net', 'c2p_database-c2p', 'c2p', 'Reazseca360');
        }
        return self::$db;
    }
    

    static function getAuth(){
        return new Auth(Session::getInstance(), ["restriction_msg" => "Tu es bloqué !"]);
    }

    static function redirect($page)
    {
        header("Location: $page");
        exit();
    }
}
