<?php

namespace App\Controller;

use App\App;
use App\DBAuth;
use App\Session;
use App\Validator;

class UserController extends AppController
{
    public function login()
    {
        $title = "Se connecter";
        $extraCss = "form";
        // $auth = App::getAuth();
        // $db = App::getDB();
        // $auth->connectFromCookie($db);
        // if ($auth->user()) {
        //     App::redirect("account.php");
        // }
        if (!empty($_POST) && !empty($_POST['username']) && !empty($_POST['password'])) {
            $session = Session::getInstance();
            $auth = new DBAuth(Session::getInstance());
            $user = $auth->login($_POST['username'], $_POST['password'], isset($_POST['remember']));
            if ($user) {
                $session->setFlash("success", "Vous êtes maintenant connecté");
                if ($user->ROLE == 'admin') {
                    App::redirect("index.php?p=adminPanel");
                } else {
                    App::redirect("index.php?p=account");
                }
            } else {
                $session->setFlash("danger", "Identifiant ou mot de passe incorrecte");
            }
        }
        $this->render("user.login", compact("title", "extraCss"));
    }

    public function register()
    {
        $title = "S'inscrire";
        $extraCss = "form";

        if (!empty($_POST)) {
            $errors = array();
            $db = App::getInstance()->getDB();
            $validator = new Validator($_POST);
            $validator->isAlphaNum('username', "Votre pseudo n'est pas valide (alphanumérique)");
            if ($validator->isValid()) {
                $validator->isUniq('username', $db, 'USERS', "Ce pseudo est déjà pris");
            }
            $validator->isEmail('email', "Votre email n'est pas valide");
            if ($validator->isValid()) {
                $validator->isUniq('email', $db, 'USERS', "Cet email est déjà utilisé pour un autre compte");
            }
            $validator->isConfirmed('password', "Vous devez rentrer un mot de passe valide");
            if ($validator->isValid()) {
                App::getAuth()->register($db, $_POST['username'], $_POST['password'], $_POST['email']);
                Session::getInstance()->setFlash('success', "Un email de confirmation vous a été envoyé pour valider votre compte");
                App::redirect("index.php?p=login");
            } else {
                $errors = $validator->getErrors();
            }
        }
        $this->render("user.register", compact("title", "extraCss", "errors"));
    }

    public function confirm()
    {
        $db = App::getInstance()->getDB();
        if (App::getAuth()->confirm($db, $_GET['id'], $_GET['token'])) {
            Session::getInstance()->setFlash("success", "Votre compte a bien été validé");
            App::redirect("index.php?p=account");
        } else {
            Session::getInstance()->setFlash("danger", "Ce token n'est plus valide");
            App::redirect("index.php?p=login");
        }
        // $this->render("user.login", compact("title", "extraCss"));
    }

    public function forget()
    {
        $title = 'Mot de passe oublié';
        $extraCss = 'form';
        if (!empty($_POST) && !empty($_POST['email'])) {
            $db = App::getInstance()->getDB();
            $auth = App::getAuth();
            $session = Session::getInstance();
            if ($auth->resetPassword($db, $_POST['email'])) {
                $session->setFlash("success", "Les instructions du rappel de mot de passe vous ont été envoyées par emails");
                App::redirect("index.php?p=login");
            } else {
                $session->setFlash("danger", "Aucun compte ne correspond a cet email");
                App::redirect("index.php?p=forget");
            }
        }
        $this->render("user.forget", compact("title", "extraCss"));
    }

    public function reset()
    {
        $title = 'Reset du mot de passe';
        $extraCss = 'form';

        if (isset($_GET['id']) && isset($_GET['token'])) {
            $auth = App::getAuth();
            $db = App::getInstance()->getDB();
            $user = $auth->checkResetToken($db, $_GET['id'], $_GET['token']);

            if ($user) {
                if (!empty($_POST)) {
                    $validator = new Validator($_POST);
                    $validator->isConfirmed("password");
                    if ($validator->isValid()) {
                        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
                        $db->prepareReq("UPDATE USERS SET password = ?, reset_at = NULL, reset_token = NULL WHERE id_user = ?", [$password, $_GET['id']]);
                        Session::getInstance()->setFlash('success', "Votre mot de passe a bien été modifié");
                        $auth->connect($user);
                        App::redirect("index.php?p=account");
                    }
                }
            } else {
                Session::getInstance()->setFlash('danger', "Ce token n'est pas valide");
                App::redirect("index.php?p=login");
            }
        } else {
            App::redirect("index.php?p=login");
        }
        $this->render("user.reset", compact("title", "extraCss"));
    }

    public function logout()
    {
        App::getAuth()->logout();
        Session::getInstance()->setFlash("success", "Vous êtes maintenant déconnecté");
        App::redirect("index.php?p=home");
    }

    public function account()
    {
        $title = 'Mon compte';
        $extraCss = 'form';
        App::getAuth()->restrict();
        if (!empty($_POST)) {
            if (empty($_POST['password']) || $_POST['password'] != $_POST['password_confirm']) {
                $_SESSION['flash']['danger'] = "Les mots de passe ne correspondent pas";
            } else {
                $user_id = $_SESSION['auth']->ID_USER;
                $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
                App::getInstance()->getTable("USERS")->editPass($password, $user_id);
                $_SESSION['flash']['success'] = "Votre mot de passe a bien été mis à jour";
            }
        }
        $this->render("user.account", compact("title", "extraCss"));
    }
}
