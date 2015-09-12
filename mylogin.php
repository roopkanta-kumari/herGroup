    <?php
session_start();
    include 'lib/function.php';

    $objfunction = new scriptClass(); // Create Class Object

    $email = trim($_REQUEST['email']);
    $pass = trim($_REQUEST['password']);
    $resultval[0] = filter_var($email, FILTER_VALIDATE_EMAIL);
    //----------------------------------------- Check Mandatory Field-----------------------------//  
  
    //----------------------------------------- END----------------------------------------------// 

    $getprofiledata = $objfunction->getProfileDetails($email, $pass); // Get Profile Details
    $_SESSION['uid']= $getprofiledata['userID'];
    //print"<pre>";print_r($getprofiledata);print"</pre>"; die;
    if (!$getprofiledata) { // Check User is Exist or Not
        $array = array(
          
            "Status" => "0",
            "Message" => "Invalid Email and Password",
              "code" => "198"
        );
        $json = json_encode($array);
        echo $json;
        return;
    } 
    else {
       
 $array = array(  
                        "Status" => "1",
                       
                        "code"=>"200"
                           
                    );
                    $json = json_encode($array);
                   // echo $json;
				   
				   	   header('Location: http://localhost.hackathonwomen.com/dashboard.php');
          
        
        }
    
    ?>






