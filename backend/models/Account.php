<?php

class Account{
    private $connexion;

    public $id;
    public $first_name;
    public $last_name;
    public $email;
    public $phone_number;

    public function __construct($db){
        $this->connexion = $db;
    }

    public function getAccounts(){
        $sql = "SELECT * from account";
        $query = $this->connexion->prepare($sql);
        $query->execute();
        return $query;
    }
}

?>