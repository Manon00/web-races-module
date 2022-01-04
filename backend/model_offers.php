<?php
  // Se connecter à la base de données
  include("db_connect.php");
  include('./Offer.php');

  $request_method = $_SERVER["REQUEST_METHOD"];

  function getOffers()
  {
    global $conn;

    $offer = new Offer();

    $sql = "SELECT writer_id,first_name,last_name,email,phone_number,`offer`.id,content, date_creation, date_current, date_obsolescence,type FROM `offer` inner join `account` on `offer`.writer_id=`account`.id";
    $query = $conn->prepare($sql);
    $query->execute();
    $stmt=$query;

    if($stmt->rowCount() > 0){

      $tableOffers = [];

      while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
          extract($row);
          $status="";
          if($date_creation != null){
            if($date_current == null && $date_obsolescence == null)
              $status="to_validate";
            if($date_current != null && $date_obsolescence == null)
              $status="validate";
            if($date_obsolescence != null)
              $status="obsolete";
          }
          $offer=[
            "offer_id" => $id,
              "writer_id" => $writer_id,
              "first_name" => $first_name,
              "last_name" => $last_name,
              "email" => $email,
              "content" => $content,
              "date_creation" => $date_creation,
              "date_current" => $date_current,
              "date_obsolescence" => $date_obsolescence,
              "type" => $type,
              "status" => $status
          ];
          $tableOffers[]=$offer;
      }
      echo json_encode($tableOffers);
      http_response_code(200);
    }}

    function getOffer($idOffer)
  {
    global $conn;

    $offer = new Offer();

    $sql = "SELECT writer_id,first_name,last_name,email,phone_number,`offer`.id,content, DATE_FORMAT(date_creation, '%d/%m/%Y - %H:%i') as date_creation,DATE_FORMAT(date_current, '%d/%m/%Y - %H:%i') as date_current,DATE_FORMAT(date_obsolescence, '%d/%m/%Y - %H:%i') as date_obsolescence,type FROM `offer` inner join `account` on `offer`.writer_id=`account`.id where `offer`.id=$idOffer";
    $query = $conn->prepare($sql);
    $query->execute();
    $stmt=$query;
    
    if($stmt->rowCount() > 0){


      if($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $status="";
        if($date_creation != null){
          if($date_current == null && $date_obsolescence == null)
            $status="to_validate";
          if($date_current != null && $date_obsolescence == null)
            $status="validate";
          if($date_obsolescence != null)
            $status="obsolete";
        }
        $offer=[
          "offer_id" => $id,
          "writer_id" => $writer_id,
          "first_name" => $first_name,
          "last_name" => $last_name,
          "email" => $email,
          "content" => $content,
          "date_creation" => $date_creation,
          "date_current" => $date_current,
          "date_obsolescence" => $date_obsolescence,
          "type" => $type,
          "status" => $status
      ];}
      header('Content-Type: application/json');
      echo json_encode($offer,JSON_PRETTY_PRINT);
      http_response_code(200);
    }}


    function setDateValidate($idOffer){
      global $conn;

      $offer = new Offer();
  
      $sql = "update offer set date_current=NOW() where id=$idOffer";
      $query = $conn->prepare($sql);
      $query->execute();
      $stmt=$query;
      
      http_response_code(200);
    }

    function setDateObsolescence($idOffer){
      global $conn;

      $offer = new Offer();
  
      $sql = "update offer set date_obsolescence=NOW() where id=$idOffer";
      $query = $conn->prepare($sql);
      $query->execute();
      $stmt=$query;
      
      http_response_code(200);
    }

    function removeDateObsolescence($idOffer){
      global $conn;

      $offer = new Offer();
  
      $sql = "update offer set date_obsolescence=NULL where id=$idOffer";
      $query = $conn->prepare($sql);
      $query->execute();
      $stmt=$query;
      
      http_response_code(200);
    }

    function removeOffer($idOffer){
      global $conn;

      $offer = new Offer();
      $sql = "delete from offer where id=$idOffer";
      $query = $conn->prepare($sql);
      $query->execute();
      $stmt=$query;
      
      http_response_code(200);
    }


    //

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
    case 'POST':
      switch(true){
        case (!empty($_GET["id"]) && !empty($_POST['status'])) : 
          switch($_POST['status']){
            case 'validate' : setDateValidate($_GET['id']);
              break;
            case 'archive' : setDateObsolescence($_GET['id']);
              break; 
            case 'unarchive' : removeDateObsolescence($_GET['id']);
              break;
            case 'remove' : removeOffer($_GET['id']);
            break;
            default : http_response_code(400); 
          }
          break;
        default : http_response_code(400); 
      }
      break;
    default:
      // Requête invalide
      header("HTTP/1.0 405 Method Not Allowed");
      break;

  }
  ?>