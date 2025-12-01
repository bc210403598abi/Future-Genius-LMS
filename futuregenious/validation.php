<?php 

if(!isset($user_id)){
    header('location: logout.php');
}

$profile_data = $db->query("SELECT * FROM users WHERE id = '$user_id'");
if(!$profile_data->num_rows){
    header('location: logout.php');
}

$profile       = $profile_data->fetch_assoc();
$user_name     = $profile['name'];
$user_email    = $profile['email'];
$user_number   = $profile['number'];
$user_password = $profile['password'];


?>