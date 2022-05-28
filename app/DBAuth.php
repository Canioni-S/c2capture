<?php

namespace App;

use App\Database;


class DBAuth
{
    // private $db;
    private $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public static function adminOnly()
    {
        if ($_SESSION['auth']->ROLE != 'admin') {
            $_SESSION['flash']['danger'] = "Vous n'avez pas le droit d'accéder à cette page";
            App::redirect("index.php?p=login");
        }
    }

    public function login($username, $password, $remember = false)
    {

        // $user = $this->db->prepareReq("SELECT * FROM USERS WHERE USERNAME = ? AND confirmed_at IS NOT NULL", [$username], null, true);
        $user = App::getInstance()->getTable("USERS")->findOne($username);
        if ($user) {
            if (password_verify($password, $user->PASSWORD)) {
                $this->connect($user);
                // if ($remember) {
                //     $this->remember($this->db, $user->id);
                // }
                return $user;
            }
        }
        return false;
    }

    public function register($db, $username, $password, $email)
    {
        $password = password_hash($password, PASSWORD_BCRYPT);
        $token = Str::random(60);
        $db->prepareReq("INSERT INTO USERS SET username = ?, password = ?, email = ?, role = 'visiteur', confirmation_token = ?", [
            $username, $password, $email, $token
        ]);
        $user_id = $db->lastInsertId();

        //SEND THE VERIFICATION BY EMAIL
        $to = $email;
        $subject = "Confirmation de votre compte";
        $message = "<html>
                      <h2>Merci d'avoir créer un compte</h2><br>
                      <p>Afin de valider votre compte merci de cliquer sur ce lien</p><br>
                      <a href='http://c2p.alwaysdata.net/index.php?p=confirm&id=$user_id&token=$token'>Confirmez votre compte</a><br>
                    </html>";
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html; charset=utf-8';
        $headers[] = 'From: c2p.alwaysdata@gmail.com';
        mail($to, $subject, $message, implode("\r\n", $headers));
    }

    public function confirm($db, $user_id, $token)
    {
        $user = App::getInstance()->getTable("USERS")->findOneUserWithID($user_id);
        // $user = $this->db->queryReq("SELECT * FROM USERS WHERE id_user = ?", [$user_id])->fetch();

        if ($user && $user->CONFIRMATION_TOKEN == $token) {
            $db->prepareReq("UPDATE USERS SET CONFIRMATION_TOKEN = NULL, confirmed_at = NOW() WHERE id_user = ?", [$user_id]);
            $this->session->write('auth', $user);
            return true;
        }
        return false;
    }

    public function resetPassword($db, $email)
    {
        $user = $db->prepareReq("SELECT * FROM USERS WHERE email = ? AND confirmed_at IS NOT NULL", [$email], null, true);
        if ($user) {
            $reset_token = Str::random(60);
            $db->prepareReq("UPDATE USERS SET reset_token = ?, reset_at = NOW() WHERE id_user = ?", [$reset_token, $user->ID_USER]);
            mail($_POST['email'], 'Réinitiatilisation de votre mot de passe', "Afin de réinitialiser votre mot de passe merci de cliquer sur ce lien\n\nhttp://c2p.alwaysdata.net/index.php?p=reset&id={$user->ID_USER}&token=$reset_token");
            return $user;
        }
        return false;
    }

    public function checkResetToken($db, $user_id, $token)
    {
        return $db->prepareReq("SELECT * FROM USERS WHERE id_user = ? AND reset_token IS NOT NULL AND reset_token = ? AND reset_at > DATE_SUB(NOW(), INTERVAL 30 MINUTE)", [$user_id, $token]);
    }

    public function restrict()
    {
        if (!$this->session->read('auth')) {
            $this->session->setFlash('danger', "Vous n'avez pas le droit d'accéder à cette page");
            header('Location: login.php');
            exit();
        }
    }


    public function user()
    {
        if (!$this->session->read('auth')) {
            return false;
        }
        return $this->session->read('auth');
    }

    public function connect($user)
    {
        $this->session->write('auth', $user);
    }

    public function connectFromCookie($db)
    {

        if (isset($_COOKIE['remember']) && !$this->user()) {
            $remember_token = $_COOKIE['remember'];
            $parts = explode('==', $remember_token);
            $user_id = $parts[0];
            $user = $db->queryReq("SELECT * FROM USERS WHERE id_user = ?", [$user_id])->fetch();
            if ($user) {
                $expected = $user_id . '==' . $user['remember_token'] . sha1($user_id . 'ratonlaveurs');
                if ($expected == $remember_token) {
                    $this->connect($user);
                    setcookie('remember', $remember_token, time() + 60 * 60 * 24 * 7);
                } else {
                    setcookie('remember', null, -1);
                }
            } else {
                setcookie('remember', null, -1);
            }
        }
    }

    // public function login($username, $password) {
    //     $user = $this->db->prepareReq("SELECT * FROM USERS WHERE USERNAME = ?", [$username], null, true);

    // }


    public function logout()
    {
        setcookie("remember", NULL, -1);
        $this->session->delete("auth");
    }


    public function remember($db, $user_id)
    {
        $remember_token = Str::random(250);
        $db->queryReq("UPDATE USERS SET remember_token = ? WHERE id = ?", [$remember_token, $user_id]);
        setcookie("remember", $user_id . "==" . $remember_token . sha1($user_id . 'ratonlaveurs'), time() + 60 * 60 * 24 * 7);
    }

    public function logged()
    {
        return isset($_SESSION["auth"]);
    }
}
