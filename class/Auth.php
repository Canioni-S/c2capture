<?php
class Auth
{

    private $db;
    // private $session;

    // public function __construct($session){
    //     $this->session = $session;
    // }

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function register($username, $password, $email)
    {
        $password = password_hash($password, PASSWORD_BCRYPT);
        $token = Str::random(60);
        $this->db->queryReq("INSERT INTO USERS SET username = ?, password = ?, email = ?, role = 'visiteur', confirmation_token = ?", [
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

    public function connect($user)
    {
        $this->session->write('auth', $user);
    }

    public function login($db, $username, $password)
    {
        $user = $db->query('SELECT * FROM users WHERE (username = :username OR email = :username) AND confirmed_at IS NOT NULL', ['username' => $username])->fetch();
        if (password_verify($password, $user->password)) {
            $this->connect($user);
            return $user;
        } else {
            return false;
        }
    }

    public function restrict()
    {
        if (!$this->session->read('auth')) {
            $this->session->setFlash('danger', "Vous n'avez pas le droit d'accéder à cette page");
            header('Location: login.php');
            exit();
        }
    }
}
