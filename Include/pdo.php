<?php

// PDO FINAL HOSTED ON ALWAYSDATA
function getPDO()
{
    $pdo = new PDO('mysql:host=mysql-c2p.alwaysdata.net;dbname=c2p_database-c2p;charset=utf8', 'c2p', 'Reazseca360');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
}

// PDO PRODUCTION ON WAMPSERVER
// function getPDO()
// {
//     $pdo = new PDO('mysql:host=localhost;dbname=dbklaphoto;charset=utf8', 'root', '');
//     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//     return $pdo;
// }
