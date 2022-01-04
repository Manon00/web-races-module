<?php
 $username = "root";
 $password = "";
    $conn = null;
    $add='mysql:host=127.0.0.1;port=3307;dbname=projet_gci';
    try{
        $conn= new PDO($add, $username, $password);            
        $conn->exec("set names utf8");

    }catch(PDOException $e){
        echo "Erreur de connexion " . $e->getMessage();
    }
?>