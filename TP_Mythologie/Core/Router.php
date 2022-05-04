<?php

namespace Kasroman\Core;

use Kasroman\Controllers\ArticlesController;
use Kasroman\Controllers\ErrorsController;

require_once('../Controllers/UsersController.php');
require_once('../Controllers/ArticlesController.php');
require_once('../Controllers/CommentairesController.php');
require_once('../Controllers/ErrorsController.php');

class Router{

    public function start(){

        // On demarre la session
        session_start();

        // On sépare dans un tableau les paramètres envoyés dans $_GET['p'];
        // url -> p=controlleur/methode/paramètres
        $params = explode('/', $_GET['p']);

        // Si on a au moins un element dans le $_GET
        if($params[0] !== ''){

            // On récupère le chemin du controlleur correspondant a la valeur rentrée en $_GET
            $controller = '\\Kasroman\\Controllers\\' . ucfirst(array_shift($params)) . 'Controller';

        
            // On vérifie l'existance du controleur appelé dans le $_GET
            if(class_exists($controller)){
                // On l'instancie
                $controller = new $controller();

                // Si d'autres paramètres on était entrés dans le $_GET on déplace le premier dans $method, sinon on lui defini 'index' par defaut
                $method = isset($params[0]) ? array_shift($params) : 'index';

                // Si la méthode $method existe dans l'objet $controller
                if(method_exists($controller, $method)){

                    // Si il reste encore des paramètres entrés dans le $_GET, on les donne en paramètre à la méthode du controlleur sinon on appelle simplement la méthode du controlleur
                    // Au lieu de faire $controller->$method($params) on utilise la fonction call_user_func_array() qui fait appel a une méthode d'un controleur on lui donnant les params en tableau
                    isset($params[0]) ? call_user_func_array([$controller, $method], $params) : $controller->$method();
                    
                }else{
                    http_response_code(404);
                    $controller = new ErrorsController;
                    $controller->error404();
                }

            }else{
                http_response_code(404);
                $controller = new ErrorsController;
                $controller->error404();
            }
        }else{
            // Si il n'y a pas de paramètres, on instancie le controleur par defaut et on appelle sa methode index();
            $controller = new ArticlesController;
            $controller->index();
        }
    }
}