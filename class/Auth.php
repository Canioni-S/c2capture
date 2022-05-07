<?php
class Auth
{

    private $session;
    private $options = ["restriction_msg" => "Vous n'avez pas le droit d'acceder a cette page !"];

    public function __construct($session, $options = [])
    {
        $this->options = array_merge($this->options, $options);
        $this->session = $session;
    }

    public function register($db, $username, $password, $email)
    {
        $password = password_hash($password, PASSWORD_BCRYPT);
        $token = Str::random(60);
        $db->queryReq("INSERT INTO USERS SET username = ?, password = ?, email = ?, role = 'visiteur', confirmation_token = ?", [
            $username, $password, $email, $token
        ]);
        $user_id = $this->db->lastInsertId();

        //SEND THE VERIFICATION BY EMAIL
        $to = $_POST['email'];
        $subject = "Confirmation de votre compte";
        $message = "<html>
                      <h2>Merci d'avoir créer un compte</h2><br>
                      <p>Afin de valider votre compte merci de cliquer sur ce lien</p><br>
                      <a href='http://c2p.alwaysdata.net/confirm.php?id=$user_id&token=$token'>Confirmez votre compte</a><br>
                    </html>";
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html; charset=utf-8';
        $headers[] = 'From: c2p.alwaysdata@gmail.com';
        mail($to, $subject, $message, implode("\r\n", $headers));
    }

    public function confirm($db, $user_id, $token)
    {
        $user = $this->db->queryReq("SELECT * FROM USERS WHERE id_user = ?", [$user_id])->fetch();

        if ($user && $user['CONFIRMATION_TOKEN'] == $token) {
            $db->queryReq("UPDATE USERS SET CONFIRMATION_TOKEN = NULL, confirmed_at = NOW() WHERE id_user = ?", [$user_id]);
            $this->session->write('auth', $user);
            return true;
        }
        return false;
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

    public function login($db, $username, $password, $remember = false)
    {
        $user = $db->queryReq("SELECT * FROM USERS WHERE (username = :username OR email = :username) AND confirmed_at IS NOT NULL", ['username' => $username])->fetch();
        if (password_verify($password, $user->password)) {
            $this->connect($user);
            if ($remember) {
                $this->remember($db, $user->id);
            }
            return $user;
        } else {
            return false;
        }
    }

    public function remember($db, $user_id)
    {
        $remember_token = Str::random(250);
        $db->queryReq("UPDATE USERS SET remember_token = ? WHERE id = ?", [$remember_token, $user_id]);
        setcookie("remember", $user_id . "==" . $remember_token . sha1($user_id . 'ratonlaveurs'), time() + 60 * 60 * 24 * 7);
    }

    public function logout()
    {
        setcookie("remember", NULL, -1);
        $this->session->delete("auth");
    }

    public function resetPassword($db, $email)
    {
        $user = $db->queryReq("SELECT * FROM USERS WHERE email = ? AND confirmed_at IS NOT NULL", [$email])->fetch();
        if ($user) {
            $reset_token = Str::random(60);
            $db->queryReq("UPDATE USERS SET reset_token = ?, reset_at = NOW() WHERE id_user = ?", [$reset_token, $user['ID_USER']]);
            mail($_POST['email'], 'Réinitiatilisation de votre mot de passe', "Afin de réinitialiser votre mot de passe merci de cliquer sur ce lien\n\nhttp://c2p.alwaysdata.net/reset.php?id={$user['ID_USER']}&token=$reset_token");
            return $user;
        }
        return false;
    }

    public function checkResetToken($db, $user_id, $token)
    {
    return $db->queryReq("SELECT * FROM USERS WHERE id_user = ? AND reset_token IS NOT NULL AND reset_token = ? AND reset_at > DATE_SUB(NOW(), INTERVAL 30 MINUTE)", [$user_id, $token])->fetch();
    }

}
