<?php

require("app/connect.php");

if(empty($_SESSION['user'])) 
    { 
      
        header("Location: ../../index.php"); 
         
        
        die("Redirecting to ../../index.php"); 
    } 

?>