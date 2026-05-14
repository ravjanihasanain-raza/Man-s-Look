<?php
    require("DBConfig.php");

        class ManageCategorie extends DBconfig
        {

            // Save Category 

            function saveCategorie($Data){
                $Query = "INSERT INTO `categories` (`Categorieid`, `category_name`, `description`) 
                                            VALUES (NULL, '".$Data->Name."', '".$Data->Description."');";
                                            
                if (mysqli_query($this->Con , $Query)){

                    return array ("Status" => "Ok" ,"Result" =>"Successfully Saved");
                }
                else
                {
                    return array ("Status" => "Fail" ,"Result" => mysqli_error($this->Con));
                }
            }

            // gets Category (Display)

            function getData(){

                $Query = "select * from categories";
                $row = [] ;
                $res = mysqli_query($this->Con , $Query);

                while($row = mysqli_fetch_assoc($res)){

                    $rows[] = $row;

                }
                return array("Status" => "Ok" , "Result" => $rows);
            }

            // getDetails Category
             function getDetails($Id){
                $Query = "select * from categories where Categorieid=$Id ";
                $res = mysqli_query($this->Con , $Query);
                if($row = mysqli_fetch_assoc($res)){
                         return array("Status" => "Ok" , "Result" => $row);
                }
                else
                {
                        return array("Status" => "Fail" , "Result" => "Not Found");
                }
            }
            // deleteCategory Category
             function deleteCategory($Id){

                $Query = "delete from categories where Categorieid=$Id ";
                $res = mysqli_query($this->Con , $Query);
                return array("Status" => "Ok" , "Result" => "Successfully Deleted");
            }
             // Edit Category 
            function EditCategorie($Data){
                $Query = "update  `categories` set `category_name`='".$Data->Name."', 
                                                    `description`='".$Data->Description."'
                                                    where  `Categorieid`='".$Data->CategorieId."' ";      
                if (mysqli_query($this->Con , $Query)){

                    return array ("Status" => "Ok" ,"Result" =>"Successfully Saved");
                }
                else
                {
                    return array ("Status" => "Fail" ,"Result" => mysqli_error($this->Con));
                }
            }
                  

                    public function getCount() {
                        $query = "SELECT COUNT(*) as cnt FROM categories"; // change table name
                        $result = $this->Con->query($query);
                        $row = $result->fetch_assoc();
                        return $row['cnt'];
                    }

        }
?>