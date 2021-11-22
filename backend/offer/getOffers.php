<?php

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    if($_SERVER['REQUEST_METHOD']='GET'){
        include_once '../config/Database.php';
        include_once '../models/Offer.php';

        $database = new Database();
        $db = $database->getConnexion();

        $offer = new Offer($db);

        $stmt = $offer->getOffers();

        
        if($stmt->rowCount() > 0){
            
            $tableOffers = [];

            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                extract($row);
                $offer=[
                    "writer_id" => $writer_id,
                    "first_name" => $first_name,
                    "last_name" => $last_name,
                    "email" => $email,
                    "offer_id" => $id,
                    "content" => $content,
                    "date_creation" => $date_creation,
                    "date_current" => $date_current,
                    "date_obsolescence" => $date_obsolescence,
                    "zone" => $zone,
                    "type" => $type
                ];
                $tableOffers[$id]=$offer;
            }
            echo json_encode($tableOffers);
            http_response_code(200);
        }
    }else{
        http_response_code(405);
        echo json_encode(["message" => "La methode n'est pas autorisée"]);
    }