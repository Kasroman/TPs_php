<?php

namespace Kasroman\Controllers;

class Controller{
    public function render(string $file, string $title = null, array $data = [], string $template = 'base'){
        
        // On extrait le contenu de $data
        extract($data);

        // On démarre le buffer de sortie
        // A partir de ce point, toute sortie est conservée en mémoire
        ob_start();

        // On récupère la vue
        require_once ROOT . '/Views/' . $file . '.php';

        // On stoque le contenu du buffer dans la variable $content (tout le html du fichier chargé)
        $content = ob_get_clean();

        // On ajoute une variable titre
        $title !== null ? $title = $title . ' - ' : $title = '';

        // On execute le contenu dans le fichier $template
        require_once ROOT . '/Views/' . $template . '.php';
    }
}