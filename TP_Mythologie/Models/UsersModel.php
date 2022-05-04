<?php

namespace Kasroman\Models;

require_once('Model.php');

class UsersModel extends Model{
    protected $id_user;
    protected $email_user;
    protected $pseudo_user;
    protected $password_user;
    protected $role_user;

    public function __construct(){
        $this->table = "users";
    }

    // Créer la session utilisateur
    public function setSession(){
        $_SESSION['user'] = [
            'id' => $this->id_user,
            'email' => $this->email_user,
            'pseudo' => $this->pseudo_user,
            'role' => $this->role_user
        ];
    }

    /**
     * Get the value of role_user
     */ 
    public function getRole_user()
    {
        return $this->role_user;
    }

    /**
     * Set the value of role_user
     *
     * @return  self
     */ 
    public function setRole_user($role_user)
    {
        $this->role_user = $role_user;

        return $this;
    }

    /**
     * Get the value of password_user
     */ 
    public function getPassword_user()
    {
        return $this->password_user;
    }

    /**
     * Set the value of password_user
     *
     * @return  self
     */ 
    public function setPassword_user($password_user)
    {
        $this->password_user = $password_user;

        return $this;
    }

    /**
     * Get the value of pseudo_user
     */ 
    public function getPseudo_user()
    {
        return $this->pseudo_user;
    }

    /**
     * Set the value of pseudo_user
     *
     * @return  self
     */ 
    public function setPseudo_user($pseudo_user)
    {
        $this->pseudo_user = $pseudo_user;

        return $this;
    }

    /**
     * Get the value of email_user
     */ 
    public function getEmail_user()
    {
        return $this->email_user;
    }

    /**
     * Set the value of email_user
     *
     * @return  self
     */ 
    public function setEmail_user($email_user)
    {
        $this->email_user = $email_user;

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
}