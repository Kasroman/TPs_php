<?php

namespace Kasroman\Controllers;

use Kasroman\Models\CommentairesModel;
use Kasroman\Models\UsersModel;

require_once('Controller.php');
require_once('ErrorsController.php');

require_once('../Models/CommentairesModel.php');
require_once('../Models/UsersModel.php');

class CommentairesController extends Controller{
    
    public function add(int $idArticle){

        if($_POST){

            // Si pas connecté
            if(!isset($_SESSION['user'])){
                $_SESSION['msg'] = ['danger', 'Veuillez vous connecter pour poster un commentaire'];
                header('Location: ' . ROOT_PUBLIC . 'users/login');
                exit;
            }

            // Si champs rempli
            if(isset($_POST['content'])){

                // On nettoie le contenu du commentaire
                $comment = htmlspecialchars($_POST['content']);

                // On enregistre le commentaire
                $commentairesModel = new CommentairesModel;
                $commentairesModel->setId_user($_SESSION['user']['id'])
                    ->setId_article($idArticle)
                    ->setContenu_commentaire($comment);

                $commentairesModel->create();
            }
        }

        // Page 404
        $errorsController = new ErrorsController;
        $errorsController->error404();
    }

    public function read(int $idArticle){

        // On cherche a savoir si cet article à des commentaires
        $commentairesModel = new CommentairesModel;
        $comments = $commentairesModel->getCommentairesOrderByRecent($idArticle);
        if($comments){

            // On récupère le pseudo de l'auteur de chaque commentaires
            $i = 0;
            foreach($comments as $comment){
                $usersModel = new UsersModel;
                $user = $usersModel->get($comment->id_user);
                $comments[$i]->pseudo_user = $user->pseudo_user;
                $i++;
            }

            // On ecrit en JSON pour traiter cette sortie avec AJAX
            echo json_encode($comments);
        }
    }

    public function remove(int $idCommentaire){

        // Si connecté
        if(isset($_SESSION['user'])){

            // si admin
            if($_SESSION['user']['role'] === 'admin'){

                // On cherche a savoir si le commentaire existe
                $commentairesModel = new CommentairesModel;
                if($commentairesModel->get($idCommentaire)){
                    $commentairesModel->delete($idCommentaire);
                }
            }else{

                // 404
                $errorsController = new ErrorsController;
                $errorsController->error404();
            }
        }else{

            // 404
            $errorsController = new ErrorsController;
            $errorsController->error404();
        }
    }
}