<?php

namespace Kasroman\Models;

class CommentairesModel extends Model{
    protected $id_commentaire;
    protected $id_user;
    protected $id_article;
    protected $contenu_commentaire;
    protected $date_commentaire;

    public function __construct(){
        $this->table = "commentaires";
    }

    // Récupères les commentaires du plus récent au plus ancien
    public function getCommentairesOrderByRecent(int $idArticle){
        return $this->myQuery("SELECT * FROM $this->table WHERE id_article = ? ORDER by date_commentaire", [$idArticle])->fetchAll();
    }

    /**
     * Get the value of date_commentaire
     */ 
    public function getDate_commentaire()
    {
        return $this->date_commentaire;
    }

    /**
     * Set the value of date_commentaire
     *
     * @return  self
     */ 
    public function setDate_commentaire($date_commentaire)
    {
        $this->date_commentaire = $date_commentaire;

        return $this;
    }

    /**
     * Get the value of contenu_commentaire
     */ 
    public function getContenu_commentaire()
    {
        return $this->contenu_commentaire;
    }

    /**
     * Set the value of contenu_commentaire
     *
     * @return  self
     */ 
    public function setContenu_commentaire($contenu_commentaire)
    {
        $this->contenu_commentaire = $contenu_commentaire;

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
     * Get the value of id_commentaire
     */ 
    public function getId_commentaire()
    {
        return $this->id_commentaire;
    }

    /**
     * Set the value of id_commentaire
     *
     * @return  self
     */ 
    public function setId_commentaire($id_commentaire)
    {
        $this->id_commentaire = $id_commentaire;

        return $this;
    }
}