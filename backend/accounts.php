<?php
  // Se connecter à la base de données
  include("db_connect.php");
  include('./Account.php');

  $request_method = $_SERVER["REQUEST_METHOD"];

  function getAccounts()
  {
    global $conn;

    $account = new Account();

    $sql = "SELECT account.id, first_name, last_name,email,phone_number,description  from account inner join role on account.role=role.id";
    $query = $conn->prepare($sql);
    $query->execute();
    $stmt=$query;

    if($stmt->rowCount() > 0){

      $tableAccounts = [];

      while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
          extract($row);

          $account=[
              "id" => $id,
              "first_name" => $first_name,
              "last_name" => $last_name,
              "email" => $email,
              "phone_number" => $phone_number,
              "role" => $description,
          ];
          $tableAccounts[$id]=$account;
      }
      
    
      echo json_encode($tableAccounts);
      http_response_code(200);
    }}

    function getAccount($idAccount)
  {
    global $conn;

    $account = new Account();

    $sql = "SELECT account.id, first_name, last_name,email,phone_number,description  from account inner join role on account.role=role.id where account.id=$idAccount";
    $query = $conn->prepare($sql);
    $query->execute();
    $stmt=$query;
    
    if($stmt->rowCount() > 0){


      if($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        $account=[
              "id" => $id,
              "first_name" => $first_name,
              "last_name" => $last_name,
              "email" => $email,
              "phone_number" => $phone_number,
              "role" => $description,
        ];}
        
   echo json_encode($account);
      http_response_code(200);
    }}

    header("Content-Type: application/json; charset=UTF-8");
    
    switch($request_method)
  {
    case 'GET':
      if(!empty($_GET["id"]))
      {
        // Récupérer un seul produit
        $id = intval($_GET["id"]);
        getAccount($id);
      }
      else
      {
        // Récupérer tous les produits
        getAccounts();
      }
      break;
    default:
      // Requête invalide
      header("HTTP/1.0 405 Method Not Allowed");
      break;

  }
?>