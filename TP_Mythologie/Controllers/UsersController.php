<?php

namespace Kasroman\Controllers;

use Kasroman\Models\UsersModel;

require_once('Controller.php');
require_once('../Models/UsersModel.php');


class UsersController extends Controller{

    public function register(){

        // Si l'utilisateur est déjà connecté
        if(isset($_SESSION['user'])){
            $_SESSION['msg'] = ['success', 'Vous êtes déjà connecté en tant que ' . ucFirst($_SESSION['user']['pseudo'])];
            header('Location: ' . ROOT_PUBLIC . 'articles');
            exit;
        }

        if($_POST){
            // Si tous les champs sont remplis
            if($_POST['email'] && $_POST['pseudo'] && $_POST['password']){

                // On nettoie et on hash le psw
                $email = htmlspecialchars($_POST['email']);
                $pseudo = htmlspecialchars($_POST['pseudo']);
                $password = password_hash(htmlspecialchars($_POST['password']), PASSWORD_ARGON2I);

                // On vérifie qu'un utilisateur n'est pas déjà enregistré avec cet e-mail
                $usersModel = new UsersModel;
                if(!$usersModel->getBy(['email_user' => $email])){

                    // On créer l'utilisateur
                    $usersModel->setEmail_user($email)
                        ->setPseudo_user($pseudo)
                        ->setPassword_user($password);
                    $usersModel->create();

                    $_SESSION['msg'] = ['success', 'Vous-vous êtes inscrit avec succès !'];
                    header('Location: ' . ROOT_PUBLIC . 'users/login');
                    exit;
                }else{
                    $_SESSION['msg'] = ['danger', 'Un utilisateur utilisant cet email est déjà enregistré'];
                }
            }else{
                $_SESSION['msg'] = ['danger', 'Veuillez remplir tous les champs.'];
            }
        }
        $this->render('users/register', 'Register');
    }

    public function login(){

        // Si déjà connecté
        if(isset($_SESSION['user'])){
            $_SESSION['msg'] = ['success', 'Vous êtes déjà connecté en tant que ' . ucFirst($_SESSION['user']['pseudo'])];
            header('Location: ' . ROOT_PUBLIC . 'articles');
            exit;
        }

        if($_POST){
            // Si champs remplis
            if($_POST['email'] && $_POST['password']){
                
                // On cherche en bdd si un utilisateur est enregistré a cet email
                $usersModel = new UsersModel;
                $userArray = $usersModel->getBy(['email_user' => htmlspecialchars($_POST['email'])]);
                if($userArray){

                    // On hydrate
                    $user = new UsersModel;
                    $user->setId_user($userArray[0]->id_user)
                        ->setEmail_user($userArray[0]->email_user)
                        ->setPseudo_user($userArray[0]->pseudo_user)
                        ->setPassword_user($userArray[0]->password_user)
                        ->setRole_user($userArray[0]->role_user);


                    // On vérifie que les psw correspondent
                    if(password_verify($_POST['password'], $user->getPassword_user())){

                        // On créer la session
                        $user->setSession();

                        $_SESSION['msg'] = ['success', 'Bonjour ' . ucFirst($user->getPseudo_user()) . ' ! Vous êtes bien connecté.'];
                        header('Location: ' . ROOT_PUBLIC);
                        exit;
                    }else{
                        $_SESSION['msg'] = ['danger', 'L\'e-mail ou le mot de passe est incorrect'];
                    }
                }else{
                    $_SESSION['msg'] = ['danger', 'L\'e-mail ou le mot de passe est incorrect'];
                }
            }else{
                $_SESSION['msg'] = ['danger', 'Veuillez remplir tous les champs.'];
            }
        }
        $this->render('users/login', 'Login');
    }

    public function logout(){

        // Si pas connecté
        if(!isset($_SESSION['user'])){
            $_SESSION['msg'] = ['danger', 'Connectez-vous ou créez un compte !'];
            header('Location: ' . ROOT_PUBLIC . 'users/login');
            exit;
        }

        // On déconnecte
        unset($_SESSION['user']);
        
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
}