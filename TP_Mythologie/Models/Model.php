<?php

namespace Kasroman\Models;

use Kasroman\Core\Db;

require_once('../Core/Db.php');

class Model extends Db{

    // Table de la actuellement utilisé dans la requête
    protected $table;

    // Instance de Db
    private $db;

    // --------------------------------------- QUERY ---------------------------------------------------------------------
    
    // Permet de faire une requête simple ou une requête préparée si il y a des arguments ou pas
    public function myQuery(string $sql, array $attributs = null){

        // On récupère l'instance de Db avec sa méthode statique
        $this->db = Db::getInstance();

        // On vérifie l'existance d'attributs
        if($attributs !== null){
            $query = $this->db->prepare($sql);
            $query->execute($attributs);
            return $query;
        }else{
            return $this->db->query($sql);
        }
    }

    // --------------------------------------- CREATE --------------------------------------------------------------------
    public function create(){

        // Nos tableaux qui accueillent les fields, values et les '?';
        $fields = [];
        $values = [];
        $questMarks = [];

        // On éclate l'object
        foreach($this as $field => $value){

            // On vérifie que la valeur n'est pas nule et on n'ajoute pas d'element au tableau pour les propriétés $table et $db
            if($value !== null && $field !== 'db' && $field !== 'table'){
                $fields[] = $field;
                $values[] = $value;
                $questMarks[] = '?';
            }
        }

        // On transforme les deux tableaux en string, les elements sont séparés par une ',' dans la string
        $fieldsString = implode(',', $fields);
        $questMarksString = implode(',', $questMarks);

        // On execute la requête
        return $this->myQuery("INSERT INTO $this->table ($fieldsString) VALUES ($questMarksString)", $values);
    }

    // --------------------------------------- READ ----------------------------------------------------------------------
    public function getAll(){
        $query = $this->myQuery("SELECT * FROM $this->table");
        return $query->fetchAll();
    }

    public function get(int $id){
        return $this->myQuery("SELECT * FROM $this->table WHERE id_" . substr($this->table, 0, -1) . "= ?", [$id])->fetch();
    }

    // Requête des enregistrements sous la forme d'un tableau associatif. Exemple getBy(['id' => 2, 'pseudo' => 'albert', 'email' => 'albert@albert.com']);
    public function getBy(array $crits){
        $fields = [];
        $values = [];

        // On éclate le tableau donné en argument
        foreach($crits as $field => $value){
            $fields[] = "$field = ?";
            $values[] = $value;
        }

        // On fait une chaine de caractère du tableau
        $fieldsString = implode(' AND ', $fields);

        return $this->myQuery("SELECT * FROM $this->table WHERE $fieldsString", $values)->fetchAll();
    }

    // --------------------------------------- DELETE --------------------------------------------------------------------
    public function delete(int $id){
        // On enlève le 's' au nom de la table de l'objet courent pour acceder au champ en bdd
        return $this->myQuery("DELETE FROM {$this->table} WHERE id_" . substr($this->table, 0, -1) . "= $id");
    }
}