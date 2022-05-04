<?php

namespace Kasroman\Controllers;

use Kasroman\Models\ArticlesModel;
use Kasroman\Models\CommentairesModel;
use Kasroman\Models\UsersModel;

require_once('Controller.php');
require_once('CommentairesController.php');
require_once('ErrorsController.php');


require_once('../Models/ArticlesModel.php');
require_once('../Models/UsersModel.php');

class ArticlesController extends Controller{

    // Page qui affiche tous les articles
    public function index(){

        // On récupère tous les articles en bdd
        $articlesModel = new ArticlesModel;
        $articles = $articlesModel->getArticleOrderByAlphabetical();

        // On récupère le nom de l'auteur pour chaque article et on lui rajoute une propriété 'pseudo_user'
        $i = 0;
        foreach($articles as $article){
            $user = new UsersModel;
            $user = $user->get($article->id_user);
            $articles[$i]->pseudo_user = $user->pseudo_user;
            $i++;
        }

        $this->render('articles/index', null, ['articles' => $articles]);
    }

    public function read(int $id){

        if(isset($_POST['delete_article'])){
            $this->remove(htmlspecialchars($_POST['delete_article']));
        }

        // On récupère un article par son id
        $articlesModel = new ArticlesModel;
        $article = $articlesModel->get($id);

        if(!$article){
            $_SESSION['msg'] = ['danger', 'Désolé, l\'article recherché n\'a pas était trouvé.'];
            header('Location: ' . ROOT_PUBLIC);
            exit;
        }

        // On récupère le pseudo de l'auteur de l'article
        $usersModel = new UsersModel;
        $user = $usersModel->get($article->id_user);
        $article->pseudo_user = $user->pseudo_user;

        $this->render('articles/read', $article->titre_article, ['article' => $article]);
    }

    public function add(){

        // On vérifie que l'utilisateur soit admin
        if(!isset($_SESSION['user'])){
            $errorsModel = new ErrorsController;
            $errorsModel->error404();
            exit;

        }
        if($_SESSION['user']['role'] !== 'admin'){
            $_SESSION['msg'] = ['danger', 'Vous n\'avez pas la permission d\'acceder à cette page.'];
            header('Location: ' . ROOT_PUBLIC . 'articles');
            exit;
        }

        if($_POST){

            // Si tous les champs sont remplis et qu'il n'y a pas d'erreur de chargement du fichier image
            if($_POST['title'] && $_POST['content'] && $_FILES['userfile']['error'] === 0){

                // On vérifie que l'image soit d'une extension .jpg, .jpeg ou .png
                if(strpos($_FILES['userfile']['type'], 'png') || strpos($_FILES['userfile']['type'], 'jpg') || strpos($_FILES['userfile']['type'], 'jpeg')){      
                }else{
                    $_SESSION['msg'] = ['danger', 'Votre fichier doit être du format .jpg, .jpeg ou .png.'];
                    header('Location: ' . $_SERVER['HTTP_REFERER']);
                    exit;
                }
                
                // On vérifie que la taille de l'image soit inférieure a 1mo
                if($_FILES['userfile']['size'] > 1048576){
                    $_SESSION['msg'] = ['danger', 'Votre fichier image est trop volumineux ! (max 1Mo).'];
                    header('Location: ' . $_SERVER['HTTP_REFERER']);
                    exit;
                }

                // On vérifie que le contenu soit supérieur a 100 caractères
                if(strlen($_POST['content']) < 100){
                    $_SESSION['msg'] = ['danger', 'Le contenu de votre article doit être de plus de 100 caractères.'];
                    header('Location: ' . $_SERVER['HTTP_REFERER']);
                    exit;
                }

                // On nettoie les entrées
                $title = htmlspecialchars($_POST['title']);
                $content = htmlspecialchars($_POST['content']);

                // On vérifie si un article portant le même titre n'est pas déjà présent en bdd
                $articlesModel = new ArticlesModel;

                if($articlesModel->getBy(['titre_article' => $title])){
                    $_SESSION['msg'] = ['danger', 'Un article avec ce titre existe déjà.'];
                    header('Location: ' . $_SERVER['HTTP_REFERER']);
                    exit;
                }

                // On sépare l'extension de son nom de fichier dans un tableau
                $extension = explode('.', $_FILES['userfile']['name']);
                
                // On enregistre l'image avec le nom de l'article en nom de fichier
                move_uploaded_file($_FILES['userfile']['tmp_name'], 'assets/img/articles/' . str_replace(' ', '_', $title) . '.' . end($extension));

                // On enregistre l'article en bdd
                $article = new ArticlesModel;
                
                $article->setId_user($_SESSION['user']['id'])
                    ->setTitre_article($title)
                    ->setContenu_article($content)
                    ->setImage_article(str_replace(' ', '_', $title) . '.' . end($extension));

                $article->create();

                $_SESSION['msg'] = ['success', 'Votre article a été publié !'];
                header('Location: ' . ROOT_PUBLIC . 'articles');
                exit;
            }else{
                $_SESSION['msg'] = ['danger', 'Veuillez remplir tous les champs et choisir une image.'];
            }
        }
        $this->render('articles/add', 'Ajouter article');
    }

    public function remove(int $id){

        // Si $_SESSION est vide
        if(!$_SESSION){
            $errorsController = new ErrorsController;
            $errorsController->error404();
            exit;
        }

        // Si l'utilisateur n'est pas admin
        if($_SESSION['user']['role'] !== 'admin'){
            $errorsController = new ErrorsController;
            $errorsController->error404();
            exit;
        }

        // On vérifie que l'article existe
        $articlesModel = new ArticlesModel;
        $article = $articlesModel->get($id);

        if(!$article){
            $errorsController = new ErrorsController;
            $errorsController->error404();
            exit;
        }


        // On vérifie que l'image est présente dans le dossier
        if(file_exists('../public/assets/img/articles/' . $article->image_article)){

            // On supprime l'article et l'image
            $articlesModel->delete($id);
            unlink('../public/assets/img/articles/' . $article->image_article);

            $_SESSION['msg'] = ['success', 'L\'article a été supprimé avec succès.'];
            header('Location: ' . ROOT_PUBLIC);
            exit;
        }else{
            $_SESSION['msg'] = ['danger', 'Malheureusement une erreur est survenue dans la suppression de l\'article.'];
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        }
    }
}



