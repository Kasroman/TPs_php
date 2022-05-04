<?php

namespace Kasroman\Models;

require_once('Model.php');

class ArticlesModel extends Model{
    protected $id_article;
    protected $id_user;
    protected $titre_article;
    protected $contenu_article;
    protected $image_article;
    protected $date_article;

    public function __construct(){
        $this->table = "articles";
    }

    public function getArticleOrderByAlphabetical(){
        return $this->myQuery("SELECT * FROM $this->table ORDER by titre_article")->fetchAll();
    }

    /**
     * Get the value of date_article
     */ 
    public function getDate_article()
    {
        return $this->date_article;
    }

    /**
     * Set the value of date_article
     *
     * @return  self
     */ 
    public function setDate_article($date_article)
    {
        $this->date_article = $date_article;

        return $this;
    }

    /**
     * Get the value of image_article
     */ 
    public function getImage_article()
    {
        return $this->image_article;
    }

    /**
     * Set the value of image_article
     *
     * @return  self
     */ 
    public function setImage_article($image_article)
    {
        $this->image_article = $image_article;

        return $this;
    }

    /**
     * Get the value of contenu_article
     */ 
    public function getContenu_article()
    {
        return $this->contenu_article;
    }

    /**
     * Set the value of contenu_article
     *
     * @return  self
     */ 
    public function setContenu_article($contenu_article)
    {
        $this->contenu_article = $contenu_article;

        return $this;
    }

    /**
     * Get the value of titre_article
     */ 
    public function getTitre_article()
    {
        return $this->titre_article;
    }

    /**
     * Set the value of titre_article
     *
     * @return  self
     */ 
    public function setTitre_article($titre_article)
    {
        $this->titre_article = $titre_article;

        return $this;
    }

    /**
     * Get the value of id_user
     */ 
    public function getId_user()
    {
        return $this->id_user;
    }

    /**
     * Set the value of id_user
     *
     * @return  self
     */ 
    public function setId_user($id_user)
    {
        $this->id_user = $id_user;

        return $this;
    }

    /**
     * Get the value of id_article
     */ 
    public function getId_article()
    {
        return $this->id_article;
    }

    /**
     * Set the value of id_article
     *
     * @return  self
     */ 
    public function setId_article($id_article)
    {
        $this->id_article = $id_article;

        return $this;
    }
}