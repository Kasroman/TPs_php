<?php

namespace Kasroman\Controllers;

require_once('Controller.php');

class ErrorsController extends Controller {

    public function error404(){
        require_once ROOT . '/Views/' . 'errors/404.php';
    }
}