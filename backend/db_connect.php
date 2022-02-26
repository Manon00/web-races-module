<?php
  //connexion à la base de données

  //login
  $username = "root";
  $password = "";

  //info sur la base
  $host="127.0.0.1";
  $port="3307";
  $dbname="bdd_gci";

  $add="mysql:host=$host;port=$port;dbname=$dbname";

  //connexion
  $conn = null;

  try{
    $conn= new PDO($add, $username, $password);            
    $conn->exec("set names utf8");
    //connexion réussie
  }catch(PDOException $e){      
    echo "Erreur de connexion " . $e->getMessage();
    //connexion échouée
  }
?>