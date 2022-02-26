<?php
  //pour création des tokens
  require "vendor/autoload.php";
  use \Firebase\JWT\JWT;

  //connection à la base
  include("db_connect.php");

  //structure des comptes
  include('./Account.php');

  //récupération de la méthode de la requête (GET,POST,PUT...)
  $request_method = $_SERVER["REQUEST_METHOD"];

  ///////////////////////////////////////////////////////////////////
  //FONCTIONS

  //récupération de tous les comptes
  function getAccounts()
  {
    //connexion
    global $conn;

    //variable avec la structure d'un compte
    $account = new Account();

    //requête 
    $sql = "SELECT account.id, first_name, last_name,email,phone_number  from account";
    $query = $conn->prepare($sql);
    $query->execute();
    $stmt=$query;

    if($stmt->rowCount() > 0){ //si la requête ramène plus qu'une ligne

      //table des comptes
      $tableAccounts = [];
      
      while($row = $stmt->fetch(PDO::FETCH_ASSOC)){ //pour toutes les lignes du résultats
          extract($row); //récupération de la ligne
          //requête 
        $sqlRoles = "SELECT description FROM `account_role` inner join account on account_id=account.id inner join role on role_id=role.id where account.id=$id;";
        $queryRoles = $conn->prepare($sqlRoles);
        $queryRoles->execute();
        $stmtRoles=$queryRoles;
        $tableRoles = [];
        if($stmtRoles->rowCount() > 0){ //si la requête ramène plus qu'une ligne

          //table des roles
          
      
          while($row = $stmtRoles->fetch(PDO::FETCH_ASSOC)){ //pour toutes les lignes du résultats
            extract($row); //récupération de la ligne
  
            //ajout dans la table
            $tableRoles[]=$description;
          }
        }
          //récupération des infos du compte
          $account=[
              "id" => $id,
              "first_name" => $first_name,
              "last_name" => $last_name,
              "email" => $email,
              "phone_number" => $phone_number,
              "roles" => $tableRoles
          ];

          //ajout dans la table
          $tableAccounts[]=$account;
      }
      
      //affiche des résultats
      echo json_encode($tableAccounts);

      //code de réussite
      http_response_code(200);
    }}



    //récupération des infos du compte correspondant à $idAccount
    function getAccount($idAccount)
  {
    //connexion
    global $conn;

    //variable avec la structure d'un compte
    $account = new Account();

    //requête 
    $sql = "SELECT account.id, first_name, last_name,email,phone_number  from account where account.id=$idAccount";
    $query = $conn->prepare($sql);
    $query->execute();
    $stmt=$query;
    
    if($stmt->rowCount() > 0){//si la requête ramène plus qu'une ligne

      if($row = $stmt->fetch(PDO::FETCH_ASSOC)){ 
        extract($row); //récupération de la ligne
        
        //requête 
        $sqlRoles = "SELECT description FROM `account_role` inner join account on account_id=account.id inner join role on role_id=role.id where account.id=$idAccount;";
        $queryRoles = $conn->prepare($sqlRoles);
        $queryRoles->execute();
        $stmtRoles=$queryRoles;
        $tableRoles = [];
        if($stmtRoles->rowCount() > 0){ //si la requête ramène plus qu'une ligne

          //table des roles
          
      
          while($row = $stmtRoles->fetch(PDO::FETCH_ASSOC)){ //pour toutes les lignes du résultats
            extract($row); //récupération de la ligne
  
            //ajout dans la table
            $tableRoles[]=$description;
          }
        }
        //récuperation des info sur le compte
        $account=[
              "id" => $id,
              "first_name" => $first_name,
              "last_name" => $last_name,
              "email" => $email,
              "phone_number" => $phone_number,
              "roles" => $tableRoles
        ];
      }
    }
        //affichage du compte
        echo json_encode($account);

        //code de réussite
        http_response_code(200);
  }



  //récupération des infos de login
function getLogin($email,$pw){
  //connexion    
  global $conn;

  //requete (id, first_name & last_name du compte correspondant aux email et password)
  $sql = "SELECT id, first_name, last_name from account where account.email='$email' and account.password='$pw'" ;
  $query = $conn->prepare($sql);
  $query->execute();
  $stmt=$query;

  if($stmt->rowCount() > 0){ //si la requete retourne un résultat
        
    $row = $stmt->fetch(PDO::FETCH_ASSOC); //récuperation de la ligne

    //infos récupérées
    $id = $row['id'];
    $firstname = $row['first_name'];
    $lastname = $row['last_name'];
    
    //infos necessaires à la creation du token
    $secret_key = "YOUR_SECRET_KEY";
    $issuer_claim = "THE_ISSUER"; 
    $audience_claim = "THE_AUDIENCE";
    $issuedat_claim = time(); 
    $notbefore_claim = $issuedat_claim + 10; 
    $expire_claim = $issuedat_claim + 60; 
    
    //token
    $token = array(
      "iss" => $issuer_claim,
      "aud" => $audience_claim,
      "iat" => $issuedat_claim,
      "nbf" => $notbefore_claim,
      "exp" => $expire_claim,
      "data" => array(
        "id" => $id,
        "firstname" => $firstname,
        "lastname" => $lastname,
        "email" => $email
      )
    );

    $jwt = JWT::encode($token, $secret_key);

    //requête 
    $sqlRoles = "SELECT description FROM `account_role` inner join account on account_id=account.id inner join role on role_id=role.id where account.id=$id;";
    $queryRoles = $conn->prepare($sqlRoles);
    $queryRoles->execute();
    $stmtRoles=$queryRoles;
    $tableRoles = [];
    if($stmtRoles->rowCount() > 0){ //si la requête ramène plus qu'une ligne

      //table des roles
      
  
      while($row = $stmtRoles->fetch(PDO::FETCH_ASSOC)){ //pour toutes les lignes du résultats
        extract($row); //récupération de la ligne

        //ajout dans la table
        $tableRoles[]=$description;
      }
    }

    //infos de login
    $login=[
      "message" => "Success login.",
      "jwt" => $jwt,
      "id" => $id,
      "expireAt" => $expire_claim,
      "roles" => $tableRoles];
    
    //affichage des infos de login
    echo json_encode($login);     

  }else{//la requete n'a rien retournée

    //infos de login erreur
    $login=[
      "message" => "Error login.",
      "jwt" => '',
      "id" => -1];
  
    //affiche des infos de login
    echo json_encode($login);
  }
    //code de réussite
    http_response_code(200);
}

//ajout d'un compte
function addAccount($first_name, $last_name, $email,$phone_number, $password,$type)
{
  //connexion
  global $conn;

  //requête ajout
  $sql = "insert into account( first_name, last_name,email,phone_number,password ) values ('$first_name', '$last_name', '$email','$phone_number', '$password') returning id;";
  $query = $conn->prepare($sql);
  $query->execute();
  $stmt=$query;

  if($stmt->rowCount() > 0){ //si la requete retourne un résultat
        
    $row = $stmt->fetch(PDO::FETCH_ASSOC); //récuperation de la ligne

    $id = $row['id'];

    
  switch($type)
  {
    case 'skipper':
      $role=3;
      break;
    case 'crew':
      $role=4;
      break;
    default:
      $role=0;
      break;
    }
  //requête role
  $sqlRole = "insert into account_role(account_id,role_id ) values ($id,$role)";
  $queryRole = $conn->prepare($sqlRole);
  $queryRole->execute();
  }
  

  //code de réussite
  http_response_code(200);
}


//ajout d'un compte anonyme
function addAccountAnonyme($first_name, $last_name, $email,$phone_number)
{
  //connexion
  global $conn;
  

  //requête ajout
  $sql = "insert into account( first_name, last_name,email,phone_number ) values ('$first_name', '$last_name', '$email','$phone_number') returning id;";
  $query = $conn->prepare($sql);
  $query->execute();
  $stmt=$query;

  if($stmt->rowCount() > 0){ //si la requete retourne un résultat
        
    $row = $stmt->fetch(PDO::FETCH_ASSOC); //récuperation de la ligne

    $id = $row['id'];

    
  $role=5;
  //requête role
  $sqlRole = "insert into account_role(account_id,role_id ) values ($id,$role)";
  $queryRole = $conn->prepare($sqlRole);
  $queryRole->execute();
  }
  

  //code de réussite
  http_response_code(200);
}
/////////////////////////////////////////////


///////////////////////////////////////////
//GESTION DES REQUETES A L'API
  header("Access-Control-Allow-Origin: *");
  header("Access-Control-Allow-Origin: http://localhost:8080");
  header("Content-Type: application/json; charset=UTF-8");
  header("Access-Control-Allow-Headers", "Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  //vérification de la méthode de requete
  switch($request_method)
  {
    case 'GET':
      if(!empty($_GET["id"])) //s'il y a un id (ex : api/accounts/1)
      {
        $id = intval($_GET["id"]);
        // Récupérer un seul compte
        getAccount($id);
        
      }else{ //il n'y a pas d'id (ex : api/accounts/)
          // Récupérer tous les comptes
          getAccounts();
      }
      break;
    case 'POST':
            if(!empty($_POST['first_name']) && !empty($_POST['last_name']) && !empty($_POST['email']) && !empty($_POST['phone_number']) && !empty($_POST['password']) && !empty($_POST['type'])){ //s'il y a des informations d'inscription 
              //ajouter le compte
              addAccount($_POST['first_name'], $_POST['last_name'], $_POST['email'], $_POST['phone_number'], $_POST['password'], $_POST['type']);
            }else{
              if(!empty($_POST['first_name']) && !empty($_POST['last_name']) && !empty($_POST['email']) && !empty($_POST['phone_number'])){
                //ajouter le compte anonyme
                addAccountAnonyme($_POST['first_name'], $_POST['last_name'], $_POST['email'], $_POST['phone_number']);  
              }else{
                if(!empty($_POST['email']) && !empty($_POST['password'])){ //s'il y a un email et un mot de passe 
                  /* exemple :
                    api/accounts/ 
                    form_data : {email : "email", password : "password"}
                  */
                  //recupérer les infos de connection
                  getLogin($_POST['email'],$_POST['password']);
                }else{
                  http_response_code(400);
                }
              }
            }
          
      break;
    default:
      // Requête invalide
      header("HTTP/1.0 405 Method Not Allowed");
      break;

  }
?>