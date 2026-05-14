<?php
    require("DBConfig.php");


    class ManageAdmin extends DBconfig 
    {
        function Authentation($user , $Passwd)
        {
            $Query = "select * from adminmaster where
                        UserName='$user' and Password='$Passwd'";

            $res =mysqli_query($this->Con , $Query);

            if($row = mysqli_fetch_assoc($res)){
                return array("Status" => "Ok" , "Result" => $row);
            }
            else
            {
                return array("Status" => "Fail" , "Result" => "Wrong username and password");
            }
        }
    }

    ?>