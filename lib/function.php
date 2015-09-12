<?php

require_once 'datamanager.php';

class scriptClass {

    public $connection;

    public function __construct() {

        //data base connection.

        $this->connection = new Connection();
    }


    public function getAllUsers() {

        $sql="select* from users"; 

         $result = mysql_query($sql);
       
 while ($record = mysql_fetch_assoc($result)) {

            $users[] = $record;
        }

        return $users;
    }
	    public function checkEmailExist($email) {
        
        $sql = "SELECT email FROM users WHERE email='{$email}'";

        $result = mysql_query($sql) or die(mysql_error());

        $record = mysql_fetch_assoc($result);

        if ($record) {

            return $record;
        } else {

            return false;
        }
		}
	
	public function createNewAccount($email, $password) {
//        echo$deviceRegId;die;
//die('123');
        $password = md5($password);

        $sql = "Insert 

                INTO 

                    users(`userID`,`email`,`password`)

                VALUES

                ('','{$email}','{$password}')";	

			
//        print_r($sql);die;
        if (!$data = mysql_query($sql)) {

            die('Error: ' . mysqli_error());
        }



        return mysql_insert_id();
    }
	
		public function insertdetails($userid,$lat, $long,$description, $time) {
//        echo$deviceRegId;die;
//die('123');
        $password = md5($password);

        $sql = "Insert 

                INTO 

                    complains(`Complain_id`,`userid`,Lat`,`lon`,`description`,'time' )

                VALUES

                ('','{$userid}','{$lat}','{$long}','{$description}','{$time}')";	

			
//        print_r($sql);die;
        if (!$data = mysql_query($sql)) {

            die('Error: ' . mysqli_error());
        }



        return mysql_insert_id();
    }
    
	    public function getProfileDetails($email, $password) {

        $password = md5($password);

        $query = "SELECT * FROM users WHERE Email='{$email}' AND Password='{$password}'";

        $result = mysql_query($query);

        $record = mysql_fetch_assoc($result);

        return $record;
    }


}
?>

