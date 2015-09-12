<?php
//die('roop');
include 'lib/function.php';
$objfunction = new scriptClass();
//print_r($objfunction);die;



$email= $_POST["email"];

$pass=$_POST["password"];

 

	
	$emailExistance = $objfunction->checkEmailExist($email); // Get Profile Details

	if ($emailExistance) { // Check User is Exist or Not
//    if($emailExistance['dbcsFacebookProfile'] !='' || $emailExistance['dbcsFacebookProfile']!=Null || $emailExistance['dbcsFacebookProfile']!='0'){
 
        
            
    
	
        $nickNameMsg = "Email". " ". $email . " "."already exists, please choose another";
    
	}
	else {
    $setProfileData = $objfunction->createNewAccount($email, $pass); // Create new Account
}


if (isset($setProfileData)) {// Check Create New User or Not
   
    $array = array(
        "Status" => "1",
        "Message" => "Congratulations on Hackathon women. Your account has been registered.",
        "ID" => $setProfileData,
            "code"=>"200"
    );

    $json = json_encode($array);
    //echo $json;
	   header('Location: http://localhost.hackathonwomen.com/login.php');
} 
else {

    
}

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>