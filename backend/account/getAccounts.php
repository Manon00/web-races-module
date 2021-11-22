<?php

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    if($_SERVER['REQUEST_METHOD']='GET'){
        include_once '../config/Database.php';
        include_once '../models/Account.php';

        $database = new Database();
        $db = $database->getConnexion();

        $account = new Account($db);

        $stmt = $account->getAccounts();

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
                    "password" => $password
                ];
                $tableAccounts[$id]=$account;
            }
            echo json_encode($tableAccounts);
            http_response_code(200);
        }
    }else{
        http_response_code(405);
        echo json_encode(["message" => "La methode n'est pas autorisée"]);
    }