<?php

class Offer{
    private $connexion;

    public $writer_id;
    public $first_name;
    public $last_name;
    public $email;
    public $phone_number;
    public $id;
    public $content;
    public $date_creation;
    public $date_current;
    public $date_obsolescence;
    public $zone;
    public $type;

    public function __construct($db){
        $this->connexion = $db;
    }

    public function getOffers(){
        $sql = "SELECT writer_id,first_name,last_name,email,phone_number,`offer`.id,content,date_creation,date_current,date_obsolescence,zone,type FROM `offer` inner join `account` on `offer`.writer_id=`account`.id";
        $query = $this->connexion->prepare($sql);
        $query->execute();
        return $query;
    }
}

?>