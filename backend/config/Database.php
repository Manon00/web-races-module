<?php

class Database{
    private $username = "root";
    private $password = "";
    public $connexion;

    public function getConnexion(){
        $this->connexion = null;
        $add='mysql:host=127.0.0.1;port=3307;dbname=projet_gci';
        try{
            $this->connexion = new PDO($add, $this->username, $this->password);
            $this->connexion->exec("set names utf8");

        }catch(PDOException $e){
            echo "Erreur de connexion " . $e->getMessage();
        }

        return $this->connexion;
    }
}

?>