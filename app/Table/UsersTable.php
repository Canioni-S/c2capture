<?php

namespace App\Table;

class UsersTable extends Table
{
    public function findOne($username) {
        return $this->queryReq("SELECT * FROM USERS WHERE USERNAME = ?", [$username], true);
    }

    public function editPass($password, $user_id){
        return $this->queryReq("UPDATE USERS SET password = ? WHERE id_user = ?", [$password, $user_id]);
    }

    public function findOneUserWithID($user_id) {
        return $this->queryReq("SELECT * FROM USERS WHERE id_user = ?", [$user_id], true);
    }
}