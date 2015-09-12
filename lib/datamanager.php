<?php

class Connection {

    public function __construct() {
        $this->getConnection();
    }

    public function getConnection() {
		
$username = "root";
$password = "";
$hostname = "localhost"; 

	$dbhandle = mysql_connect($hostname, $username, $password)
 or die("Unable to connect to MySQL");



//select a database to work with
$selected = mysql_select_db("php-app",$dbhandle)
  or die("Could not select DB");


    }
	

}

?>
