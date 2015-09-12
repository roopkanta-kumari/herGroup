<?php 

include 'lib/function.php';
$objfunction = new scriptClass();
//print_r($objfunction);die;
session_start();
 $userid=$_SESSION['uid']



$lat= $_POST["lat"];
$long= $_POST["long"];

$myissue=$_POST["reporttext"];
 $insertdetail = $objfunction->insertdetails($userid,$lat,$long,$myissue) ;
 if($insertdetail)
 {
	    header('Location: http://localhost.hackathonwomen.com/dashboard.php');
 }


?>