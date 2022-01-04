<?php
  // Se connecter à la base de données
  include("db_connect.php");
  include('./Offer.php');

  $request_method = $_SERVER["REQUEST_METHOD"];

  function getOffers()
  {
    global $conn;

    $offer = new Offer();

    $sql = "SELECT writer_id,first_name,last_name,email,phone_number,`offer`.id,content, DATE_FORMAT(date_creation, '%d/%m/%Y - %H:%i') as date_c,date_current,date_obsolescence,type FROM `offer` inner join `account` on `offer`.writer_id=`account`.id";
    $query = $conn->prepare($sql);
    $query->execute();
    $stmt=$query;

    if($stmt->rowCount() > 0){

      $tableOffers = [];

      while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
          extract($row);
          $offer=[
            "offer_id" => $id,
              "writer_id" => $writer_id,
              "first_name" => $first_name,
              "last_name" => $last_name,
              "email" => $email,
              "content" => $content,
              "date_creation" => $date_c,
              "date_current" => $date_current,
              "date_obsolescence" => $date_obsolescence,
              "type" => $type
          ];
          $tableOffers[$id]=$offer;
      }
      echo json_encode($tableOffers);
      http_response_code(200);
    }}

    function getOffer($idOffer)
  {
    global $conn;

    $offer = new Offer();

    $sql = "SELECT writer_id,first_name,last_name,email,phone_number,`offer`.id,content, DATE_FORMAT(date_creation, '%d/%m/%Y - %H:%i') as date_c,date_current,date_obsolescence,type FROM `offer` inner join `account` on `offer`.writer_id=`account`.id where `offer`.id=$idOffer";
    $query = $conn->prepare($sql);
    $query->execute();
    $stmt=$query;
    
    if($stmt->rowCount() > 0){


      if($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        $offer=[
          "offer_id" => $id,
          "writer_id" => $writer_id,
          "first_name" => $first_name,
          "last_name" => $last_name,
          "email" => $email,
          "content" => $content,
          "date_creation" => $date_c,
          "date_current" => $date_current,
          "date_obsolescence" => $date_obsolescence,
          "type" => $type
      ];}
      header('Content-Type: application/json');
      echo json_encode($offer,JSON_PRETTY_PRINT);
      http_response_code(200);
    }}
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    
    switch($request_method)
  {
    case 'GET':
      if(!empty($_GET["id"]))
      {
        // Récupérer un seul produit
        $id = intval($_GET["id"]);
        getOffer($id);
      }
      else
      {
        // Récupérer tous les produits
        getOffers();
      }
      break;
    default:
      // Requête invalide
      header("HTTP/1.0 405 Method Not Allowed");
      break;

  }
  ?>