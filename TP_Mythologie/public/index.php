<?php
// Index du site qui démarre le router


use Kasroman\Core\Router;

require_once('../Core/Router.php');

// On definit une constante contenant le dossier racine du projet
define('ROOT', dirname(__DIR__));

// Et une deuxieme qui serra le dossier public depuis la racine du projet
define('ROOT_PUBLIC', '/tp_mythologie/public/');

// On instancie notre router
$app = new Router;

// On démarre l'app
$app->start();