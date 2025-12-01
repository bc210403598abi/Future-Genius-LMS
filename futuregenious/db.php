<?php 


session_start();
ob_start();


$db = new mysqli('localhost', 'root', '', 'futurelms');


if($db->connect_error){
    die("Connection failed: " . $db->connect_error);
}

if(isset($_SESSION['id']) AND isset($_SESSION['role'])){

    $user_id = $_SESSION['id'];
    $user_role = $_SESSION['role'];
    
}


?>