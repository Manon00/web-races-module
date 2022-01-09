<?php
  //connection à la base
  include("db_connect.php");

  //structure des offres
  include('./Offer.php');

  //récupération de la méthode de la requête (GET,POST,PUT...)
  $request_method = $_SERVER["REQUEST_METHOD"];

  ///////////////////////////////////////////////////////////////////
  //FONCTIONS

  //récupération de toutes les offres
  function getOffers()
  {
   //connexion
   global $conn;

   //variable avec la structure d'une offre
    $offer = new Offer();

    //requete
    $sql = "SELECT writer_id,first_name,last_name,email,phone_number,`offer`.id,content, date_creation, date_current, date_obsolescence,type FROM `offer` inner join `account` on `offer`.writer_id=`account`.id";
    $query = $conn->prepare($sql);
    $query->execute();
    $stmt=$query;

    if($stmt->rowCount() > 0){//si la requête ramène plus qu'une ligne

      //table des offres
      $tableOffers = [];

      while($row = $stmt->fetch(PDO::FETCH_ASSOC)){ //pour toutes les lignes du résultats
        extract($row); //récupération de la ligne

          //determination du status par rapport aux dates

          $status="";

          if($date_creation != null){ //l'offre a une date de création

            //l'offre n'a pas de date de validation ni d'obsolescence -> elle est à valider
            if($date_current == null && $date_obsolescence == null)
              $status="to_validate";

            //l'offre a une date de validation mais pas d'obsolescence -> elle est validée
            if($date_current != null && $date_obsolescence == null)
              $status="validate";

            //l'offre a une date d'obscolescence -> elle est obsolete
            if($date_obsolescence != null)
              $status="obsolete";

          }

          //récupération des infos
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

          //ajout dans la table
          $tableOffers[]=$offer;
      }
      //affichage des résultats
      echo json_encode($tableOffers);

      //code de réussite
      http_response_code(200);
    }
  }


  //récupération des infos du compte correspondant à $idAccount
    function getOffer($idOffer)
  {
    //connexion
    global $conn;

    //variable avec la structure d'une offre
    $offer = new Offer();

    //requete
    $sql = "SELECT writer_id,first_name,last_name,email,phone_number,`offer`.id,content, DATE_FORMAT(date_creation, '%d/%m/%Y - %H:%i') as date_creation,DATE_FORMAT(date_current, '%d/%m/%Y - %H:%i') as date_current,DATE_FORMAT(date_obsolescence, '%d/%m/%Y - %H:%i') as date_obsolescence,type FROM `offer` inner join `account` on `offer`.writer_id=`account`.id where `offer`.id=$idOffer";
    $query = $conn->prepare($sql);
    $query->execute();
    $stmt=$query;
    
    if($stmt->rowCount() > 0){//si la requête ramène plus qu'une ligne

      if($row = $stmt->fetch(PDO::FETCH_ASSOC)){ 
        extract($row); //récupération de la ligne

        //determination du status par rapport aux dates

        $status="";

        if($date_creation != null){ //l'offre a une date de création

          //l'offre n'a pas de date de validation ni d'obsolescence -> elle est à valider
          if($date_current == null && $date_obsolescence == null)
            $status="to_validate";

          //l'offre a une date de validation mais pas d'obsolescence -> elle est validée
          if($date_current != null && $date_obsolescence == null)
            $status="validate";

          //l'offre a une date d'obscolescence -> elle est obsolete
          if($date_obsolescence != null)
            $status="obsolete";

        }
        
        //récuperation des info
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

      //affichage des info de l'offre
      echo json_encode($offer,JSON_PRETTY_PRINT);

      //code de réussite
      http_response_code(200);
    }}



    //instanciation de la date de validation d'une offre
    function setDateValidate($idOffer){
      //connexion
      global $conn;

      //requete (date de validation de l'offre $idOffer mise à la date courante)
      $sql = "update offer set date_current=NOW() where id=$idOffer";
      $query = $conn->prepare($sql);
      $query->execute();
      $stmt=$query;
      
      http_response_code(200);
    }


    //instanciation de la date d'obsolescence d'une offre
    function setDateObsolescence($idOffer){
     //connexion
     global $conn;

     //requete (date d'obsolescence de l'offre $idOffer mise à la date courante)
      $sql = "update offer set date_obsolescence=NOW() where id=$idOffer";
      $query = $conn->prepare($sql);
      $query->execute();
      $stmt=$query;
      
      http_response_code(200);
    }


    //suppression de la date d'obsolescence
    function removeDateObsolescence($idOffer){
      //connexion
      global $conn;

      //requete
      $sql = "update offer set date_obsolescence=NULL where id=$idOffer";
      $query = $conn->prepare($sql);
      $query->execute();
      $stmt=$query;
      
      http_response_code(200);
    }

    //suppression d'une offre
    function removeOffer($idOffer){
      //connexion
      global $conn;

      //requete
      $sql = "delete from offer where id=$idOffer";
      $query = $conn->prepare($sql);
      $query->execute();
      $stmt=$query;
      
      http_response_code(200);
    }

/////////////////////////////////////////////


///////////////////////////////////////////
//GESTION DES REQUETES A L'API

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    
  //vérification de la méthode de requete
    switch($request_method)
  {
    case 'GET':
      if(!empty($_GET["id"])) //s'il y a un id (ex : api/offers/1)
      {
        // Récupérer une seule offre
        $id = intval($_GET["id"]);
        getOffer($id);
      }
      else //il n'y a pas d'id (ex : api/offres/)
      {
        // Récupérer toutes les offres
        getOffers();
      }
      break;
    case 'POST':
      switch(true){
        case (!empty($_GET["id"]) && !empty($_POST['status'])) : //il y a un id et un status passés en parametres
          /* exemple :
            api/accounts/1
            form_data : {status : 'validate'}
          */
          //verification du parametre status
          switch($_POST['status']){
            case 'validate' : setDateValidate($_GET['id']); //valider offre
              break;
            case 'archive' : setDateObsolescence($_GET['id']); //archiver offre
              break; 
            case 'unarchive' : removeDateObsolescence($_GET['id']); //désarchiver offre
              break;
            case 'remove' : removeOffer($_GET['id']); //refuser offre, suprimer offre
            break;
            default : http_response_code(400);  //erreur le parametre ne correspond à aucune action
          }
          break;
        default : http_response_code(400); //erreur pas de parametre
      }
      break;
    default:
      // Requête invalide
      header("HTTP/1.0 405 Method Not Allowed");
      break;

  }
  ?>