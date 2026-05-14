<?php
    require("../DBOperations/ManageCategorie.php");
    $method =$_SERVER["REQUEST_METHOD"];
    $ManageCategorie =new ManageCategorie();
    switch($method){
        
        case "POST":
            $input =json_decode(file_get_contents("php://input")) ;
            $result = $ManageCategorie->saveCategorie($input);
            echo json_encode($result);
        break;
         case "GET":
            
            if(isset($_REQUEST["ID"])){

            $input =json_decode(file_get_contents("php://input")) ;
              $result = $ManageCategorie->getDetails($_REQUEST["ID"]);
              echo json_encode($result);

            }
            else
            {
            $input =json_decode(file_get_contents("php://input")) ;
            $result = $ManageCategorie->getData($input);
            echo json_encode($result);
            }
            
           
        break;
         case "DELETE":
             if(isset($_REQUEST["ID"])){
                $result = $ManageCategorie->deleteCategory($_REQUEST["ID"]);
               echo json_encode($result);
             }
             else
            {
                echo json_encode(array("Status" => "Fail", "Result" => "ID is not found"));
            }
            
        break;
         case "PUT":
            $input =json_decode(file_get_contents("php://input")) ;
            $result = $ManageCategorie->editCategorie($input);
            echo json_encode($result);
        break;
    }
?>