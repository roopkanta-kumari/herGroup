<?php

require_once 'datamanager.php';

class scriptClass {

    public $connection;

    public function __construct() {

        //data base connection.

        $this->connection = new Connection();
    }

    /**

     * Get user details on profile table

     * $email String

     * $password String

     * return <Array> formate

     */
    public function getProfileDetails($email, $password) {

        $password = md5($password);

        $query = "SELECT * FROM profiles WHERE Email='{$email}' AND Password='{$password}'";

        $result = mysql_query($query);

        $record = mysql_fetch_assoc($result);

        return $record;
    }

    /**

     * Get user details on profile table

     * $userid Integer

     * return <Array> formate

     */
    public function getUserDetails($userid) {

        $query = "SELECT * FROM profiles WHERE ID='{$userid}'";

        $result = mysql_query($query);

        $record = mysql_fetch_assoc($result);

        return $record;
    }

    /**

     * Get user details on profile table

     * $email String

     * $oldpass String

     * return <Array> formate

     */
    public function checkPasswordQuery($email, $oldpass) {



        $password = md5($oldpass);

        $query1 = "SELECT * FROM profiles WHERE profiles.Email='{$email}' AND profiles.Password='{$password}' LIMIT 1";

        $result1 = mysql_query($query1, $this->connection->con);



        if ($result1) {



            $record1 = mysql_fetch_assoc($result1);

            return $record1;
        } else {

            return FALSE;
        }
    }

    /**

     * Update user details on profile table

     * $email String

     * $pass String

     */
    public function changePasswordQuery($email, $pass) {

        $password = md5($pass);

        $sql = "UPDATE profiles SET Password='{$password}' WHERE Email='{$email}'";

        mysql_query($sql);
    }

    /** Roopkanta 9thmay2015 for getallquestion_with_thumbimage_and_newvotebar webservice

     * get user,question, details on profile and bx_photos_main table

     * $limit Integer

     * return <Array> formate

     */
    public function getFeaturedQuestions($limit, $range) {

        $sql = "SELECT 

                    bx_photos_main.ID,

                    bx_photos_main.unique_que,

                    bx_photos_main.Owner,
                    
                    Title,

                    NickName,

                    Avatar,

                    dbcsFacebookProfile,

                    QuestionType,

                    Categories,

                    SubCategoryID,

                    Hash,

                    Ext

                    FROM profiles, bx_photos_main

                    WHERE 



                            bx_photos_main.unique_que NOT IN (SELECT bx_report.unique_que FROM bx_report Where status = '0') 

                   AND

                           bx_photos_main.Owner = profiles.ID 

                    

                   ORDER BY 

                           bx_photos_main.ID ASC LIMIT {$limit} OFFSET {$range}";



        $result = mysql_query($sql);

        while ($data = mysql_fetch_assoc($result)) {

            $record[] = $data;
        }

        return $record;
    }

    /**

     * get user,question, details on profile and bx_photos_main table

     * $id Integer

     * return <Array> formate

     */
    public function getFeaturedQuestion($id) {



        $sql = "SELECT bx_photos_main.ID,bx_photos_main.Owner,bx_photos_main.unique_que,NickName,Title,Hash,Ext,QuestionType,DirectIndirectQuestion FROM profiles,bx_photos_main Where profiles.ID=bx_photos_main.Owner AND bx_photos_main.ID ='{$id}'";

        $result = mysql_query($sql);

        $record = mysql_fetch_array($result);

        return $record;
    }

    /**

     * get multichoice image details on multichoicetablepic table

     * $id Integer

     * return <Array> formate

     */
    public function getFeaturedQuestionMultichoice($id) {

        $sql = "SELECT * FROM multichoicetablepic Where qid ='{$id}'";

        $result = mysql_query($sql);

        $record = mysql_fetch_array($result);

        return $record;
    }

    /**

     * set question details on bx_photos_main table

     * $cat String   

     * $id Integer     

     * $ext String

     * $title String 

     * $date Integer 

     * $name String 

     * $type Integer 

     * $uniqeID String

     * $dopen Integer

     * $subid Integer 

     */
    public function addQuestion($cat, $id, $ext, $title1, $date, $name, $type, $uniqeID, $dopen) {
        $title = mysql_real_escape_string($title1);


        $sql = "INSERT INTO `bx_photos_main`(`Categories`, `Owner`, `Ext`, `Size`, `Title`, `Uri`, `Desc`, `Tags`, `Date`, `Views`, `Rate`, `RateCount`, `CommentsCount`, `Featured`, `Status`, `Hash`, `QuestionType`, `DirectIndirectQuestion`, `unique_que`, `urgeLevel`, `daysOpen`, `SubCategoryID`, `widgetId`) 

               VALUES ('{$cat}','{$id}','{$ext}','320X240','{$title}','URI','{$title}','Groupinion Alpha','{$date}','0','0','0','0','0','approved','$name','{$type}','','{$uniqeID}','','{$dopen}','{$subid}','')";

        if (!$data = mysql_query($sql)) {

            die('Error: ' . mysql_error());
        }

        return mysql_insert_id();
    }

    public function addQuestionwithoutpic($cat, $id, $ext, $title1, $date, $name, $type, $uniqeID, $dopen) {
        $title = mysql_real_escape_string($title1);


        $sql = "INSERT INTO `bx_photos_main`(`Categories`, `Owner`, `Ext`, `Size`, `Title`, `Uri`, `Desc`, `Tags`, `Date`, `Views`, `Rate`, `RateCount`, `CommentsCount`, `Featured`, `Status`, `Hash`, `QuestionType`, `DirectIndirectQuestion`, `unique_que`, `urgeLevel`, `daysOpen`, `SubCategoryID`, `widgetId`) 

               VALUES ('{$cat}','{$id}','','','{$title}','URI','{$title}','Groupinion Alpha','{$date}','0','0','0','0','0','approved','$name','{$type}','','{$uniqeID}','','{$dopen}','{$subid}','')";

        if (!$data = mysql_query($sql)) {

            die('Error: ' . mysql_error());
        }

        return mysql_insert_id();
    }

//    public function addQuestionwithoutpic($cat, $id,$title1, $date, $name, $type, $uniqeID, $dopen, $subid) {
//        $title = mysql_real_escape_string($title1);
//
//
//        $sql = "INSERT INTO `bx_photos_main`(`Categories`, `Owner`, `Title`, `Uri`, `Desc`, `Tags`, `Date`, `Views`, `Rate`, `RateCount`, `CommentsCount`, `Featured`, `Status`, `Hash`, `QuestionType`, `DirectIndirectQuestion`, `unique_que`, `urgeLevel`, `daysOpen`, `SubCategoryID`, `widgetId`) 
//
//               VALUES ('{$cat}','{$id}','{$title}','URI','{$title}','Groupinion Alpha','{$date}','0','0','0','0','0','approved','$name','{$type}','','{$uniqeID}','','{$dopen}','{$subid}','')";
//       $data=mysql_query($sql);
////               print_r($data);die('123');
//        if (!$data = mysql_query($sql)) {
//
//            die('Error: ' . mysql_error());
//
//        }
//
//        return mysql_insert_id();
//
//    }
//    public function multiQuestionwithoutpic($qid, $id1, $date1,$des1, $des2, $des3, $des4) {
////        die('123');
//        $des1 = mysql_real_escape_string(stripcslashes($des1));
//        $des2 = mysql_real_escape_string(stripcslashes($des2));
//        $des3 = mysql_real_escape_string(stripcslashes($des3));
//        $des4 = mysql_real_escape_string(stripcslashes($des4));
//        
//        $sql = "INSERT INTO multichoicetablepic(`id`,`qid`,`owner`,`date`,`description1`,`description2`,`description3`,`description4`) VALUES('','{$qid}','{$id1}','{$date1}','{$des1}','{$des2}','{$des3}','{$des4}')";
////        echo "Multichoice quesry : ".$sql;
//        mysql_query($sql);
//
//        return mysql_insert_id();
//
//    }

    /**

     * get question details on bx_photos_main table    

     * $id Integer         

     * return <Array> formate

     */
    public function getID($id) {

        $query = "SELECT unique_que FROM bx_photos_main WHERE ID='{$id}'";

        $result = mysql_query($query);

        $record = mysql_fetch_assoc($result);

        return $record;
    }

    /**

     * set multi choice question details on multichoicetablepic table

     * $qid Integer   

     * $id1 Integer     

     * $date1 DATETIME

     * $loc String 

     * $name1 String 

     * $name2 String 

     * $name3 String 

     * $name4 String

     * $des1 String

     * $des2 String 

     * $des3 String

     * $des4 String

     */
    public function multiQuestion($qid, $id1, $date1, $name1, $name2, $name3, $name4, $des1, $des2, $des3, $des4) {
        $des1 = mysql_real_escape_string(stripcslashes($des1));
        $des2 = mysql_real_escape_string(stripcslashes($des2));
        $des3 = mysql_real_escape_string(stripcslashes($des3));
        $des4 = mysql_real_escape_string(stripcslashes($des4));

        $sql = "INSERT INTO multichoicetablepic(`id`,`qid`,`owner`,`date`,`pic_loc`,`option1`,`option2`,`option3`,`option4`,`description1`,`description2`,`description3`,`description4`) VALUES('','{$qid}','{$id1}','{$date1}','','','','','','{$des1}','{$des2}','{$des3}','{$des4}')";
//        echo "Multichoice quesry : ".$sql;
        mysql_query($sql);

        return mysql_insert_id();
    }

    public function multiQuestionwithoutpic($qid, $id1, $date1, $loc, $name1, $name2, $name3, $name4, $des1, $des2, $des3, $des4) {
        $des1 = mysql_real_escape_string(stripcslashes($des1));
        $des2 = mysql_real_escape_string(stripcslashes($des2));
        $des3 = mysql_real_escape_string(stripcslashes($des3));
        $des4 = mysql_real_escape_string(stripcslashes($des4));

        $sql = "INSERT INTO multichoicetablepic(`id`,`qid`,`owner`,`date`,`pic_loc`,`option1`,`option2`,`option3`,`option4`,`description1`,`description2`,`description3`,`description4`) VALUES('','{$qid}','{$id1}','{$date1}','','','','','','{$des1}','{$des2}','{$des3}','{$des4}')";
//        echo "Multichoice quesry : ".$sql;
        mysql_query($sql);

        return mysql_insert_id();
    }

    /**

     * Get user details on profile table

     * $userid Integer

     * return <Array> formate

     */
    public function getProfileDetilsID($uid) {
//echo $uid; die;
        $sql = "SELECT * FROM profiles WHERE ID='{$uid}'";

        $result = mysql_query($sql);

        $record = mysql_fetch_assoc($result);

        return $record;
    }

    /**

     * Get user details on profile table

     * $userid Integer

     * return <Array> formate

     */
    public function getProfileDetilsEmail($email) {

        $sql = "SELECT * FROM profiles WHERE Email ='{$email}'";

        $result = mysql_query($sql);

        $record = mysql_fetch_assoc($result);

        return $record;
    }

    /**

     * Get user details on profile table

     * $userid Integer

     * return <Array> formate

     */
    public function updateProfilePic($imageName, $uid) {

        $sql = "UPDATE profiles SET profile_pic='{$imageName}' WHERE ID='{$uid}'";

//        echo $sql;

        mysql_query($sql);

        return true;
    }

    /**

     * Get groupinion friends details on sys_friend_list table

     * $ownerid Integer

     * $friendid String

     * return <Array> formate

     */
    public function checkFriend($ownerid, $friendid) {

        $sql = "SELECT ID FROM sys_friend_list WHERE ID='{$ownerid}' AND Profile='{$friendid}'";



        $result = mysql_query($sql);

        $record = mysql_fetch_assoc($result);

        return $record;
    }

    /**

     * set question details on bx_photos_main table

     * $cat String   

     * $id Integer     

     * $ext String

     * $title String 

     * $date Integer 

     * $name String 

     * $type Integer 

     * $uniqeID String

     * $dopen Integer

     */
    public function addQuestionwithDirect($cat, $id, $ext, $title, $date, $name, $type, $to, $uniqeID, $dopen) {
        $title = stripcslashes($title);
        $sql = "INSERT INTO bx_photos_main VALUES('','{$cat}','{$id}','{$ext}','320?240','{$title}','URI','{$title}','Groupinion Alpha','{$date}','0','0','0','0','0','approved','$name','{$type}','{$to}','{$uniqeID}','','{$dopen}','')";



        if (!$data = mysql_query($sql)) {

            die('Error: ' . mysqli_error());
        }

        return mysql_insert_id();
    }

    /**

     * Get user details on profiles table

     * $uname String

     * return <Array> formate

     */
    public function getProfileDetilsName($uname) {

        $sql = "SELECT * FROM profiles WHERE NickName='{$uname}'";

        $result = mysql_query($sql);

        $record = mysql_fetch_assoc($result);

        return $record;
    }

    /** Roopkanta kumari: get comments with images and follow service 11thMay2015

     * Get question details on bx_photos_main table

     * $uniqeID String

     * return <Array> formate

     */
    public function getQuestionID($uniqeID) {

        $query = "SELECT bx_photos_main.ID AS questionID,QuestionType,Owner,Title,SubCategoryID FROM bx_photos_main WHERE unique_que='{$uniqeID}'";

        $result = mysql_query($query);

        $record = mysql_fetch_assoc($result);

        return $record;
    }

    /**

     * Get uniqe value

     * $length Integer

     * return <String> formate

     */
    public function randomPrefix($length) {

        $random = "";

        srand((double) microtime() * 1000000);



        $data = "AbcDE123IJKLMN67QRSTUVWXYZ";

        $data .= "aBCdefghijklmn123opq45rs67tuv89wxyz";

        $data .= "0FGH45OP89";



        for ($i = 0; $i < $length; $i++) {

            $random .= substr($data, (rand() % (strlen($data))), 1);
        }



        return $random;
    }

    /**

     * Get user details on profiles table

     * $uniqeID String

     * return <Array> formate

     */
    public function getProfileByFbId($fbid) {

        $sql = "SELECT ID FROM profiles WHERE dbcsFacebookProfile='{$fbid}'";

        $result = mysql_query($sql);

        $record = mysql_fetch_assoc($result);

        if ($record) {

            return $record;
        } else {

            return FALSE;
        }
    }

    /**

     * Get user details on profiles table

     * $uniqeID String

     * return <Array> formate

     */
    public function getProfileData($fbid) {

        $sql = "SELECT ID,Email FROM profiles WHERE dbcsFacebookProfile='{$fbid}'";

        $result = mysql_query($sql);

        $record = mysql_fetch_assoc($result);

        if ($record) {

            return $record;
        } else {

            return FALSE;
        }
    }

    /**

     * Get user details on profiles table

     * $uniqeID String

     * return <Array> formate

     */
    public function getProfileEmail($email) {

        $sql = "SELECT ID FROM profiles WHERE Email ='{$fbid}'";

        $result = mysql_query($sql);

        $record = mysql_fetch_assoc($result);

        if ($record) {

            return $record;
        } else {

            return FALSE;
        }
    }

    /**

     * Get user and question details on profiles and bx_photos_main table

     * $id Integer

     * return <Array> formate

     */
    public function getMyFeaturedQuestions($id) {

        $record = "";

        $sql = "SELECT NickName,

                    unique_que,

                    bx_photos_main.ID,
                    bx_photos_main.Owner,
                    bx_photos_main.Hash,
                    bx_photos_main.Ext,
                    Title,

                    QuestionType,

                    FROM_UNIXTIME(`Date`) as Date,bx_photos_main.Categories,

                    bx_photos_main.SubCategoryID 

                FROM 

                    profiles,

                    bx_photos_main 

                Where 

                    bx_photos_main.Owner='{$id}' 

                AND 

                    profiles.ID='{$id}' 

                    ORDER BY bx_photos_main.ID DESC";

        $result = mysql_query($sql);

        while ($data = mysql_fetch_assoc($result)) {

            $record[] = $data;
        }

        if ($record) {

            return $record;
        } else {

            return FALSE;
        }
    }

    /**

     * Get question and question rating details on bx_photos_rating and bx_photos_main table

     * $id Integer

     * return <Array> formate

     */
    public function getFeaturedQuestionsRate($id) {

        $sql = "SELECT ID,(bx_photos_rating.gal_rating_sum/bx_photos_rating.gal_rating_count) as avragequestionrate FROM bx_photos_main,bx_photos_rating Where bx_photos_rating.gal_id = bx_photos_main.ID AND bx_photos_main.ID='{$id}'";

        $result = mysql_query($sql);

        $record = mysql_fetch_assoc($result);

        return $record;
    }

    /**

     * Get question vote details on bx_photos_cmts table

     * $id Integer

     * return <Array> formate

     */
    public function getFeaturedQuestionsTotalVote($id) {

        $query = "SELECT COUNT(*) as TotalVote FROM bx_photos_cmts Where cmt_object_id={$id}";

        $result = mysql_query($query);

        $record = mysql_fetch_assoc($result);

        return $record;
    }

    /**

     * Get yes no question vote details on bx_photos_cmts table

     * $qid Integer

     * return <Array> formate

     */
    public function getVotePercent($qid) {

        $votesql = "SELECT SUM(cmt_mood) as TotalVote FROM bx_photos_cmts WHERE (cmt_mood=1 AND cmt_object_id='{$qid}')";

        $sqlcount = "SELECT COUNT(cmt_mood) as TotalRow FROM bx_photos_cmts WHERE (cmt_object_id='{$qid}')";



        $voteresult = mysql_query($votesql);

        $totalvote = mysql_fetch_assoc($voteresult);



        $coountresult = mysql_query($sqlcount);

        $countrecord = mysql_fetch_assoc($coountresult);

        $value = array(
            "totalvote" => $totalvote['TotalVote'],
            "noofvote" => $countrecord['TotalRow']
        );

        return $value;
    }

    /**

     * Get multichoice question vote details on bx_photos_cmts table

     * $qid Integer

     * return <Array> formate

     */
    public function getVotePercentMultichoice($qid) {

        $sqltwo = "SELECT COUNT(cmt_mood) as TwoRow FROM bx_photos_cmts WHERE (cmt_mood=2 AND cmt_object_id='{$qid}')";

        $sqlthree = "SELECT COUNT(cmt_mood) as ThreeRow FROM bx_photos_cmts WHERE (cmt_mood=3 AND cmt_object_id='{$qid}')";

        $sqlfour = "SELECT COUNT(cmt_mood) as FourRow FROM bx_photos_cmts WHERE (cmt_mood=4 AND cmt_object_id='{$qid}')";

        $sqlfive = "SELECT COUNT(cmt_mood) as FiveRow FROM bx_photos_cmts WHERE (cmt_mood=5 AND cmt_object_id='{$qid}')";





        $coountresult = mysql_query($sqltwo);

        $counttwo = mysql_fetch_assoc($coountresult);



        $coountresult = mysql_query($sqlthree);

        $countthree = mysql_fetch_assoc($coountresult);



        $coountresult = mysql_query($sqlfour);

        $countfour = mysql_fetch_assoc($coountresult);



        $coountresult = mysql_query($sqlfive);

        $countfive = mysql_fetch_assoc($coountresult);



        $value = array(
            "TwoRow" => $counttwo['TwoRow'],
            "ThreeRow" => $countthree['ThreeRow'],
            "FourRow" => $countfour['FourRow'],
            "FiveRow" => $countfive['FiveRow']
        );

        return $value;
    }

    /**

     * Get question,profileand vote details on bx_photos_cmts,bx_photos_main and profiles table

     * $qid Integer

     * return <Array> formate

     */
    public function getMyAnswer($id) {

        $sql = "Select  

                    bx_photos_cmts.cmt_id,

                    bx_photos_cmts.cmt_author_id ,

                    bx_photos_main.ID,

                    unique_que,

                    bx_photos_main.QuestionType,

                    bx_photos_cmts.cmt_text,

                    bx_photos_cmts.cmt_mood,

                    bx_photos_main.Title,
                    
                    bx_photos_main.Hash,
                    
                    bx_photos_main.Ext,
                    
                    profiles.NickName,

                    bx_photos_main.Categories,

                    bx_photos_main.SubCategoryID 

                From 

                    bx_photos_cmts,

                    bx_photos_main,profiles

                WHERE

                    profiles.ID=bx_photos_main.Owner

                AND

                    bx_photos_main.ID = cmt_object_id

                AND 

                    bx_photos_cmts.cmt_author_id={$id} AND bx_photos_cmts.cmt_object_id IN

                    (SELECT cmt_object_id FROM bx_photos_cmts WHERE cmt_author_id={$id}) ORDER BY bx_photos_cmts.cmt_id DESC";



        $result = mysql_query($sql);

        while ($data = mysql_fetch_assoc($result)) {

            $record[] = $data;
        }

        if ($record) {

            return $record;
        } else {

            return FALSE;
        }
    }

    public function getMyAnswerByLimit($id, $limit) {

        $sql = "Select  

                    bx_photos_cmts.cmt_id,

                    bx_photos_cmts.cmt_author_id ,

                    bx_photos_main.ID,

                    unique_que,

                    bx_photos_main.QuestionType,

                    bx_photos_cmts.cmt_text,

                    bx_photos_cmts.cmt_mood,

                    bx_photos_main.Title,
                    
                    bx_photos_main.Hash,
                    
                    bx_photos_main.Ext,
                    
                    profiles.NickName,

                    bx_photos_main.Categories,

                    bx_photos_main.SubCategoryID 

                From 

                    bx_photos_cmts,

                    bx_photos_main,profiles

                WHERE

                    profiles.ID=bx_photos_main.Owner

                AND

                    bx_photos_main.ID = cmt_object_id

                AND 

                    bx_photos_cmts.cmt_author_id={$id} AND bx_photos_cmts.cmt_object_id IN

                    (SELECT cmt_object_id FROM bx_photos_cmts WHERE cmt_author_id={$id}) ORDER BY bx_photos_cmts.cmt_id DESC LIMIT '{$limit}',10 ";



        $result = mysql_query($sql);

        while ($data = mysql_fetch_assoc($result)) {

            $record[] = $data;
        }

        if ($record) {

            return $record;
        } else {

            return FALSE;
        }
    }

    public function getFbProfileDetails($fbid) {

//        $password = md5($password);

        $query = "SELECT * FROM Profiles WHERE FacebookProfile='{$fbid}'";

        $result = mysql_query($query);

        $record = mysql_fetch_assoc($result);

        return $record;
    }

    /**

     * Get question details on bx_photos_main table

     * $qid Integer

     * return <Array> formate

     */
    public function getQuestion($id) {

        $query = "SELECT QuestionType FROM bx_photos_main WHERE ID='{$id}'";

        $result = mysql_query($query);

        $record = mysql_fetch_assoc($result);

        return $record;
    }

    /** Roopkanta kumari: this is for follow service 11th may 2015

     * Get subscriber details on sys_sbs_entries table

     * $question_userid String

     * $qid Integer

     * return <Array> formate

     */
    public function getSubscriberEntryDetails($question_userid, $qid) {

        $sql = "SELECT * FROM sys_sbs_entries WHERE (subscriber_id='{$question_userid}' AND object_id='{$qid}')";

        $result = mysql_query($sql);

        $record = mysql_fetch_array($result);

        return $record;
    }

    /** roopkanta kumari: this is for follow service. 11thmay2015

     * Get groupinion friend details on sys_friend_list table

     * $user_id String

     * $question_userid String

     * return <Array> formate

     */
    public function getFriendEntryDetails($user_id, $question_userid) {

        $sql = "SELECT * FROM sys_friend_list WHERE (ID='{$user_id}' AND Profile='{$question_userid}')";

        $result = mysql_query($sql);

        $record = mysql_fetch_array($result);

        return $record;
    }

    /** Roopkanta: THIS IS for follow services. 11th may 2015

     * Set subscriber details on sys_sbs_entries table

     * $question_userid String

     * $qid Integer

     * return <Array> formate

     */
    public function newSubscriberEntry($question_userid, $qid) {

        $sql = "INSERT INTO sys_sbs_entries VALUES('NULL','{$question_userid}','1','7','{$qid}')";

        mysql_query($sql);
    }

    /** Roopkanta  kumari: this is for follow service. 11th may 2015

     * Set friend details on sys_friend_list table

     * $user_id String

     * $question_userid String

     * $friendadddate DATETIME

     * return <Array> formate

     */
    public function newFriendEntry($user_id, $question_userid, $friendadddate) {

        $sql = "INSERT INTO sys_friend_list VALUES('{$user_id}','{$question_userid}','1','$friendadddate')";

        mysql_query($sql);
    }

    /** Roopkanta: getcommentswithpic 11thmay2015

     * Get question and User details on profiles and bx_photos_cmts table

     * $id Integer

     * return <Array> formate

     */
    public function getFeaturedQuestionCmt($id) {

        $record = "";

        $sql = "SELECT profiles.ID,profiles.profile_pic,Avatar,cmt_id, cmt_mood, NickName, cmt_text, (cmt_rate/cmt_rate_count) as cmt_rate,dbcsFacebookProfile

         FROM bx_photos_cmts,profiles WHERE profiles.ID=cmt_author_id AND cmt_object_id='{$id}' ORDER BY cmt_id DESC";

//       echo $sql;     

        $result = mysql_query($sql);

        while ($data = mysql_fetch_assoc($result)) {

            $record[] = $data;
        }

        if ($record) {

            return $record;
        } else {

            return FALSE;
        }
    }

    /**

     * Get question details on bx_photos_cmts table

     * $qid Integer

     * return <Array> formate

     */
    public function getbx_photos_main_details($qid) {

        $sql = "SELECT * FROM bx_photos_main WHERE ID='{$qid}'";

        $result = mysql_query($sql);

        $record = mysql_fetch_assoc($result);

        return $record;
    }

    /**

     * Get question rating details on bx_photos_rating table

     * $qid Integer

     * return <Array> formate

     */
    public function getratingDetails($qid) {

        $sql = "SELECT * FROM bx_photos_rating WHERE gal_id='{$qid}'";

        $result = mysql_query($sql);

        $record = mysql_fetch_assoc($result);

        return $record;
    }

    /**

     * Update question details on bx_photos_main table

     * $qid Integer

     * $view String

     * $rate String

     * $ratecount String

     * return <Array> formate

     */
    public function updateBx_photos_main($qid, $view, $rate, $ratecount) {

        $sql = "UPDATE bx_photos_main SET Views='{$view}',Rate='{$rate}',RateCount='{$ratecount}' WHERE ID='{$qid}'";

        mysql_query($sql);
    }

    /**

     * Update question rating details on bx_photos_rating table

     * $qid Integer

     * $ratingcount String

     * $ratingsum String

     * return <Array> formate

     */
    public function updateRatingDetails($qid, $ratingcount, $ratingsum) {

        $sql = "UPDATE bx_photos_rating SET gal_rating_count='{$ratingcount}',gal_rating_sum='{$ratingsum}' WHERE gal_id='{$qid}'";

        mysql_query($sql);
    }

    /**

     * Set question rating details on bx_photos_rating table

     * $qid Integer

     * $ratingcount String

     * $ratingsum String

     * return <Array> formate

     */
    public function insertRating($qid, $ratingcount, $ratingsum) {

        $sql = "INSERT INTO bx_photos_rating VALUES('{$qid}','{$ratingcount}','{$ratingsum}')";

        mysql_query($sql);
    }

    /**

     * Update question  details on bx_photos_main table

     * $cmt_count String

     * $qid Integer

     * return <Array> formate

     */
    public function update_RateCount_Bx_photos_main($cmt_count, $qid) {

        $sql = "UPDATE bx_photos_main SET CommentsCount='{$cmt_count}' WHERE ID='{$qid}'";

        mysql_query($sql);
    }

    /**

     * Set vote details on bx_photos_cmts table

     * $qid Integer

     * $uid String

     * $cmt String

     * $mode String

     * $cmt_date DATETIME

     * return <Array> formate

     */
    public function addComment($qid, $uid, $cmt, $mode, $cmt_date) {

        $cmt = mysql_real_escape_string(stripcslashes($cmt));

        $sql = "INSERT INTO bx_photos_cmts VALUES('NULL','','$qid','$uid','$cmt','{$mode}','','','$cmt_date','','','')";

        $result = mysql_query($sql) or die(mysql_error());

        return mysql_insert_id();
    }

    /**

     * Update vote details on bx_photos_cmts table

     * $qid Integer

     * $id Integer

     * $star String

     * return <Array> formate

     */
    public function addQuestionRate($qid, $id, $star) {

        $sql = "UPDATE bx_photos_cmts SET question_rate='{$star}' WHERE (cmt_object_id='{$qid}' AND cmt_author_id='{$id}')";

        mysql_query($sql);
    }

    /**

     * Get vote details on bx_photos_cmts table

     * $id Integer

     * return <Array> formate

     */
    public function totalCMT($id) {



        $query = "SELECT count(*) as TOTAL_CMT FROM bx_photos_cmts WHERE cmt_author_id={$id}";

        $result = mysql_query($query);

        $record = mysql_fetch_assoc($result);

        return $record;
    }

    /**

     * Get rating details on bx_photos_voting_track table

     * $id Integer

     * return <Array> formate

     */
    public function totalRATE($id) {

        $query = "SELECT sum(cmt_rate) as TotalRate,count(*) as NoofComment

                    FROM 

                    bx_photos_voting_track

                    WHERE 

                    gal_id

                    IN 

                    (SELECT cmt_id FROM bx_photos_cmts WHERE cmt_author_id={$id})";

        $result = mysql_query($query);

        $record = mysql_fetch_assoc($result);

        return $record;
    }

    /**

     * Get question details on bx_photos_main table

     * $id Integer

     * return <Array> formate

     */
    public function totalQuestion($id) {

        $query = "SELECT count(*)as Tota_Question FROM bx_photos_main WHERE Owner={$id}";

        $result = mysql_query($query);

        $record = mysql_fetch_assoc($result);

        return $record;
    }

    /**

     * Get question details on bx_photos_main table

     * $id Integer

     * return <Array> formate

     */
    public function Description($id) {

        $query = "SELECT DescriptionMe FROM profiles WHERE ID={$id}";

        $result = mysql_query($query);

        $record = mysql_fetch_assoc($result);

        return $record;
    }

    /**

     * Get question rating details on bx_photos_rating table

     * $id Integer

     * return <Array> formate

     */
    public function totalQuestionRate($id) {

        $query = "SELECT SUM(gal_rating_count)as NoOfRating, SUM(gal_rating_sum)as TotalRating 

                  FROM 

                  bx_photos_rating

                  WHERE 

                  gal_id

                  IN 

                 (SELECT ID FROM bx_photos_main WHERE Owner={$id})";

        $result = mysql_query($query);

        $record = mysql_fetch_assoc($result);

        return $record;
    }

    /**

     * Get question details on bx_photos_cmts table

     * $cmt_id String

     * return <Array> formate

     */
    public function getCommentRate($cmt_id) {

        $sql = "SELECT * FROM bx_photos_cmts WHERE cmt_id='{$cmt_id}'";

        $result = mysql_query($sql);

        $record = mysql_fetch_assoc($result);

        return $record;
    }

    /**

     * Get question vote track details on bx_photos_voting_track table

     * $cmt_id String

     * $mem_id String

     * return <Array> formate

     */
    public function getCommentDetails($cmt_id, $mem_id) {

        $sql = "SELECT * FROM bx_photos_voting_track WHERE gal_id='{$cmt_id}' AND memberID='{$mem_id}'";

        $result = mysql_query($sql);

        $record = mysql_fetch_assoc($result);

        return $record;
    }

    /**

     * Update vote details on bx_photos_cmts table

     * $cmt_id String

     * $rating String

     * $cmt_count String

     * return <Array> formate

     */
    public function updateRate($cmt_id, $rating, $cmt_count) {

        $sql = "UPDATE bx_photos_cmts SET cmt_rate='{$rating}',cmt_rate_count='{$cmt_count}' WHERE cmt_id='{$cmt_id}'";

        $result = mysql_query($sql);
    }

    /**

     * Get question vote track details on bx_photos_voting_track table

     * $cmt_id String

     * $sysip String

     * $ratingdate String

     * $mem_id String

     * $cmt_rate String

     * return <Array> formate

     */
    public function addCommentRate($cmt_id, $sysip, $ratingdate, $mem_id, $cmt_rate) {

        $sql = "INSERT INTO bx_photos_voting_track VALUES('{$cmt_id}','{$sysip}','{$ratingdate}','{$mem_id}','{$cmt_rate}')";

        mysql_query($sql);
    }

    /**

     * Get Category details on sys_categories table   

     * return <Array> formate

     */
    public function getCategories() {

        $record = "";

        $sql = "SELECT Category,CategoryID FROM sys_categories WHERE ApprovedCat=1";

        $result = mysql_query($sql);

        while ($data = mysql_fetch_assoc($result)) {

            $record[] = $data;
        }

        return $record;
    }

    /**

     * Get Sub-category details on sys_subcategory table

     * $id Integer

     * return <Array> formate

     */
    public function getsubCategories($id) {

        $record = "";

        $sql = "SELECT SubCategory,SubCategoryID as CategoryID FROM sys_subcategory WHERE CategoryID='{$id}'";

        $result = mysql_query($sql);

        while ($data = mysql_fetch_assoc($result)) {

            $record[] = $data;
        }

        return $record;
    }

    /**

     * Get Sub-category details on sys_subcategory table

     * $id Integer

     * return <Array> formate

     */
    public function chkCategories($id) {

        $record = "";

        $sql = "SELECT Category FROM sys_categories WHERE CategoryID='{$id}'";

        $result = mysql_query($sql);

        $record = mysql_fetch_assoc($result);

        return $record;
    }

    /**

     * Get multichoice question details on multichoicetablepic table

     * $qId String

     * return <Array> formate

     */
    public function getMultichoiceImage($qId) {

        $query = "SELECT option1,option2,option3,option4,description1,description2,description3,description4 FROM multichoicetablepic WHERE qid='{$qId}'";

        $result = mysql_query($query);

        $record = mysql_fetch_assoc($result);

        return $record;
    }

    /**

     * Get Yes no question details on bx_photos_main table

     * $key String

     * return <Array> formate

     */
    public function getYesnoImage($key) {

        $query = "SELECT Ext,Hash FROM bx_photos_main WHERE unique_que='{$key}'";

        $result = mysql_query($query);

        $record = mysql_fetch_assoc($result);

        return $record;
    }

    /**

     * Set User details on profiles table

     * $username String

     * $password String

     * $email String

     * $gender String

     * $birthday DATE

     * $date_of_registration DATETIME

     * $friendList String

     * $fid String

     * return <Array> formate

     */
    public function create_facebook_account($username, $password, $email, $gender, $birthday, $date_of_registration, $friendList, $fid) {

        $password = md5($email);

        $flist = explode(",", $friendList);

        $friendsJson = json_encode($flist);

        $sql = "INSERT INTO profiles
            
                (`NickName`,`Email`,`Password`,`Status`,`Sex`,`DateOfBirth`,`DateReg`,`dbcsFacebookProfile`,`friends`,`profile_pic`,`fb_email`,`accesstoken`,`accesstoken_datetime`) 
                
                VALUES ('{$username}','{$email}','{$password}','Active','$gender','{$birthday}','{$date_of_registration}','{$fid}','{$friendList}','','$email','','')";


        if (!$data = mysql_query($sql)) {

            die('Error: ' . mysql_error());
        }



        return mysql_insert_id();
    }

    /**

     * Set User details on profiles table

     * $username String

     * $password String

     * $email String

     * $gender String

     * $birthday DATE

     * $date_of_registration DATETIME

     * $friendList String

     * $fid String

     * return <Array> formate

     */
    public function create_facebook_account_cemail($username, $password, $cemail, $gender, $birthday, $date_of_registration, $friendList, $fid) {

        $password = md5($email);

        $flist = explode(",", $friendList);

        $friendsJson = json_encode($flist);

//        $sql = "INSERT INTO profiles VALUES ('NULL','{$username}','{$cemail}','{$password}','','Unconfirmed','','','','','','','','','{$birthday}','','{$date_of_registration}','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','{$fid}','','{$friendsJson}')";

        $sql = "INSERT INTO profiles
            
                (`NickName`,`Email`,`Password`,`Status`,`Sex`,`DateOfBirth`,`DateReg`,`dbcsFacebookProfile`,`friends`,`profile_pic`,`fb_email`,`accesstoken`,`accesstoken_datetime`) 
                
                VALUES ('{$username}','{$cemail}','{$password}','Unconfirmed','$gender','{$birthday}','{$date_of_registration}','{$fid}','{$friendList}','','','','')";

        if (!$data = mysql_query($sql)) {

            die('Error: ' . mysql_error());
        }



        return mysql_insert_id();
    }

    /**

     * Get Facebook user details

     * $email String     

     * return <Array> formate

     */
    public function get_facebook_profileDetails($email) {

        $query = "SELECT * FROM profiles WHERE Email='{$email}'";

        $result = mysql_query($query);

        $record = mysql_fetch_assoc($result);

        return $record;
    }

    /**

     * Get vote details on bx_photos_cmts table

     * $qid Integer

     * $id Integer

     * return <Array> formate

     */
    public function getQuestionVote($qid, $id) {

        $sql = "SELECT * FROM bx_photos_cmts WHERE (cmt_object_id='{$qid}' AND cmt_author_id='{$id}')";

        $result = mysql_query($sql) or die(mysql_error());

        $record = mysql_fetch_array($result);

        return $record;
    }

    /**

     * Get Categoryes and Sub Categoryes details on sys_subcategory and sys_categories table

     * $id Integer

     * return <Array> formate

     */
    public function getsubCategoriesDetails($id) {

        $sql = "SELECT sys_categories.Category,sys_subcategory.CategoryID,sys_subcategory.SubCategoryID  FROM sys_subcategory,sys_categories WHERE sys_categories.CategoryID=sys_subcategory.CategoryID AND sys_subcategory.`SubCategoryID` ='{$id}'";

        $result = mysql_query($sql) or die(mysql_error());

        $record = mysql_fetch_array($result);

        return $record;
    }

    /**

     * Get Categoryes details on  sys_categories table

     * $id Integer

     * return <Array> formate

     */
    public function getMainCategoriesName($id) {



        $sql = "SELECT `Category` FROM `sys_categories` WHERE `CategoryID`='{$id}'";

        $result = mysql_query($sql) or die(mysql_error());

        $record = mysql_fetch_array($result);

        return $record;
    }

    /**

     * Get Avrage Category details

     * $ownerId int 

     * return <Array> formate

     */
    public function getCategoryItdsByOwner($ownerId) {

        $query = "SELECT DISTINCT(`Category`) as Categories,SubCategoryID FROM `bx_points` WHERE `OwnerID`='{$ownerId}'";

//        echo $query;

        $result = mysql_query($query);

        while ($data = mysql_fetch_assoc($result)) {

            $record[] = $data;
        }

        return $record;
    }

    /**

     * Get Avrage CategoryPoints

     * $categoryId int 

     * Desc : get sum of points basis of category id and devided 10 to get average rate and show it as a star

     * return <Array> formate

     */
    public function getCategoryPoints($categoryId, $id) {

        $query = "SELECT MAX(`levels`)as catAvgRate FROM `bx_levels` WHERE `levePoints` BETWEEN 10 and (

                  SELECT SUM(Points) as catTotalPoints FROM `bx_points` WHERE `SubCategoryID` ={$categoryId} AND OwnerID='{$id}')";
//        echo $query."<br/>";
        $result = mysql_query($query);

        $record = mysql_fetch_assoc($result);

        return $record;
    }

    /**

     * Get Avrage CategoryPoints

     * $categoryId int 

     * Desc : get sum of points basis of category id and devided 10 to get average rate and show it as a star

     * return <Array> formate

     */
    public function getTotalCategoryPoints($categoryId, $id) {

        $query = "SELECT (SELECT DISTINCT(`Category`) as Categories FROM `bx_points` WHERE `OwnerID`='{$id}' AND SubCategoryID = '{$categoryId}') as Category, SUM(Points) as catTotalPoints FROM `bx_points` WHERE `SubCategoryID` ={$categoryId} AND OwnerID='{$id}'";
//        echo $query."<br/>";
        $result = mysql_query($query);
        while ($data = mysql_fetch_assoc($result)) {

            $record[] = $data;
        }

        return $record;
//        $record = mysql_fetch_assoc($result);
//
//        return $record;
    }

    /** Roopkanta:this function is for updating profile service. 12thmay2015

     * Update User details on profiles table

     * $id int 

     * $dis String

     * Desc : get sum of points basis of category id and devided 10 to get average rate and show it as a star

     * return <Array> formate

     */
    public function updateDescription($id, $dis) {

        $query = "Update profiles set DescriptionMe='{$dis}' WHERE ID={$id}";

        $result = mysql_query($query);

        return 1;
    }

    /**

     * Post user details

     * $uid String 

     * $password String  

     * $email String     

     * return String

     */
    public function createNewAccount($nickName, $email, $password) {
//die('123');
        $password = md5($password);

        $sql = "Insert 

                INTO 

                    profiles(`ID`,

                            `NickName`,`Email`,`Password`,`Salt`,`Status`,`Role`,`Couple`,`Sex`,`LookingFor`,`Headline`,`DescriptionMe`,

                            `Country`,`City`,`DateOfBirth`,`Featured`,`DateReg`,`DateLastEdit`,`DateLastLogin`,`DateLastNav`,`aff_num`,

                            `Tags`,`zip`,`EmailNotify`,`LangID`,`UpdateMatch`,`Views`,`Rate`,`RateCount`,`CommentsCount`,

                            `PrivacyDefaultGroup`,`allow_view_to`,`UserStatus`,`UserStatusMessage`,`UserStatusMessageWhen`,`Avatar`,

                            `Height`,`Weight`,`Income`,`Occupation`,`Religion`,`Education`,`RelationshipStatus`,`Hobbies`,`Interests`,

                            `Ethnicity`,`FavoriteSites`,`FavoriteMusic`,`FavoriteFilms`,`FavoriteBooks`,`FirstName`,`LastName`,

                            `FacebookProfile`,`dbcsFacebookProfile`,`fbAccessToken`,`friends`)

                VALUES

                ('','{$nickName}','{$email}','{$password}','','Unconfirmed','','','','','','','','','','',now(),'','','','','','','','',

                 '','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','')";

        if (!$data = mysql_query($sql)) {

            die('Error: ' . mysqli_error());
        }



        return mysql_insert_id();
    }

    /**

     * Get user details on profiles table

     * $nickName String  

     * return <Array>

     */
    public function checkNickNameExist($nickName) {

        $sql = "SELECT NickName FROM profiles WHERE NickName='{$nickName}'";

        $result = mysql_query($sql) or die(mysql_error());

        $record = mysql_fetch_assoc($result);

        if ($record) {

            return $record;
        } else {

            return false;
        }
    }

    /** Roopkanta

     * Get user details on profiles table

     * $nickName String  

     * return <Array>

     */
    public function checkEmailExist($email) {;
        $sql = "SELECT Email,dbcsFacebookProfile FROM profiles WHERE Email='{$email}'";

        $result = mysql_query($sql) or die(mysql_error());

        $record = mysql_fetch_assoc($result);

        if ($record) {

            return $record;
        } else {

            return false;
        }
    }

    /**

     * Developer : Sanjay Singh

     * Date Updated : 06/06/13

     * Description : Insert bonus point when user post rate a question and when user rate a answer.(Note : Here when user rate a question then type should be     

      "QS" and when user rate on answer then type should be "AS").

     * @return : 1

     */
    public function insertBonusPoint($SubCategoryID, $qId, $ownerId, $type, $category) {



        $sql = "Insert INTO bx_points(`SubCategoryID`,`QID`,`OwnerID`,`Point`,`Type`, `Category`)VALUES

                ('{$SubCategoryID}','{$qId}','{$ownerId}','1','{$type}','{$category}')";

        $result = mysql_query($sql);

        if ($result) {

            return "1";
        }
    }

    /**

     * Set points details on bx_points table

     * $SubCategoryID String  

     * $qId String  

     * $ownerId String  

     * $point String  

     * $type Integer

     * $category String

     * return <Array>

     */
    public function insertStarBonusPoint($SubCategoryID, $qId, $ownerId, $point, $type, $category) {

        $sql = "Insert INTO bx_points(`SubCategoryID`,`QID`,`OwnerID`,`Points`,`Type`,`Category`)VALUES

                ('{$SubCategoryID}','{$qId}','{$ownerId}','{$point}','{$type}','{$category}')";



        $result = mysql_query($sql);

        if ($result) {

            return "1";
        }
    }

    /**

     * Get Question and user details on profiles and bx_photos_main table     

     * return <Array>

     */
    public function getAllFeaturedQuestions() {

        $sql = "SELECT bx_photos_main.unique_que,bx_photos_main.ID,Title,NickName,profiles.ID as user_id,QuestionType,bx_photos_main.Date FROM profiles ,bx_photos_main Where bx_photos_main.Owner = profiles.ID ORDER BY bx_photos_main.ID DESC";



        $result = mysql_query($sql);

        while ($data = mysql_fetch_assoc($result)) {

            $record[] = $data;
        }

        return $record;
    }

    /**

     * Post Notification details

     * $id int 

     * $questionTo Json  

     * $discription Text     

     */
    public function setNotification($id, $questionTo, $discription, $uniqeID) {

        $sql = "INSERT INTO  `bx_notification` (`User_id`,`Sender`,`Receiver`,`Unique_que`,`Description`,`Status`,`Type`) VALUES ('{$questionTo}','{$id}','{$questionTo}','{$uniqeID}','" . mysql_real_escape_string($discription) . "','0','1')";

//        echo $sql;

        $result = mysql_query($sql);
    }

    /**

     * Post Notification details

     * $id int 

     * $questionTo Json  

     * $discription Text     

     */
    public function checkPostQuestionNotification($questionId) {

        $sql = "SELECT User_id FROM `bx_notification` WHERE `Status`='1' AND `User_id` = '$questionId' AND `send_notification` = '1' AND `Type`='1' GROUP BY `User_id`";

//        echo $sql;

        $result = mysql_query($sql);

        $record = mysql_fetch_assoc($result);

        if ($record) {

            return $record;
        } else {

            return FALSE;
        }
    }

    /**

     * Get Notification details

     * $id Integer     

     * return <Array>

     */
    public function getNotification($id) {

        $sql = "SELECT COUNT(*) as Total_Notification FROM `bx_notification` WHERE `Status`='0' AND  `User_id` = '{$id}' AND `send_notification` = '0'";

        $result = mysql_query($sql);

        $record = mysql_fetch_assoc($result);

        if ($record) {

            return $record;
        } else {

            return FALSE;
        }
    }

    /**
     * 
     * @param type $id
     * @return boolean
     */
    public function getExpiryNotification($id) {

//        $sql = "SELECT COUNT(*) as Total_Notification,  FROM `bx_notification` WHERE `Status`='0' AND  `User_id` = '{$id}' AND `send_notification` = '0'";
        $sql = "SELECT Id,Description  FROM `bx_notification` WHERE `Status`='0' AND  `User_id` = '{$id}' AND `send_notification` = '0' AND Type = '2'";

        $result = mysql_query($sql);
        $record = "";

        while ($data = mysql_fetch_assoc($result)) {

            $record[] = $data;
        }
        if ($record) {

            return $record;
        } else {

            return FALSE;
        }
    }

    /**
     * 
     * @param type $id
     * @return boolean
     */
    public function getAnsweredquestionNotification($id) {

//        $sql = "SELECT COUNT(*) as Total_Notification,  FROM `bx_notification` WHERE `Status`='0' AND  `User_id` = '{$id}' AND `send_notification` = '0'";
        $sql = "SELECT Id,Description  FROM `bx_notification` WHERE `Status`='0' AND  `User_id` = '{$id}' AND `send_notification` = '0' AND Type = '1'";

        $result = mysql_query($sql);
        $record = "";

        while ($data = mysql_fetch_assoc($result)) {

            $record[] = $data;
        }
        if ($record) {

            return $record;
        } else {

            return FALSE;
        }
    }

    /**

     * Get Notification details

     * $id Integer     

     * return <Array>

     */
    public function getUnreadNotification($id) {

        $sql = "SELECT COUNT(*) as Total_Notification FROM `bx_notification` WHERE `Status`='0' AND  `User_id` = '{$id}'";

        $result = mysql_query($sql);

        $record = mysql_fetch_assoc($result);

        if ($record) {

            return $record;
        } else {

            return FALSE;
        }
    }

    /**

     * View Notification details

     * $id Integer     

     * return <Array>

     */
    public function viewNotification($id) {

        $sql = "UPDATE `bx_notification` SET `Status`='1' WHERE `Status`='0' AND  `Unique_que` LIKE '%{$id}%'";
        $result = mysql_query($sql);
    }

    /**

     * Get All Expaire Question details    

     * return <Array>

     */
    public function getAllExpaireFeaturedQuestions() {

        //$sql = "SELECT bx_photos_main.unique_que,bx_photos_main.ID,Title,NickName,profiles.ID as user_id,QuestionType,bx_photos_main.Date FROM profiles ,bx_photos_main Where bx_photos_main.Owner = profiles.ID ORDER BY bx_photos_main.ID DESC";   

        $sql = "SELECT bx_photos_main.unique_que,bx_photos_main.ID,Title,NickName,Email,profiles.ID as user_id,QuestionType,FROM_UNIXTIME(bx_photos_main.Date)as Date,daysOpen,DATE_ADD(FROM_UNIXTIME(Date),INTERVAL daysOpen DAY) as expiryDate FROM profiles,

                 bx_photos_main

                 WHERE 

                        bx_photos_main.Owner = profiles.ID 

                 AND 

                        now() > DATE_ADD(FROM_UNIXTIME(Date),INTERVAL daysOpen DAY)

                ORDER BY 

                        bx_photos_main.ID DESC";



        $result = mysql_query($sql);

        while ($data = mysql_fetch_assoc($result)) {

            $record[] = $data;
        }

        return $record;
    }

    /**

     * Get All Expaire Question details    

     * return <Array>

     */
    public function getAllExpaireFeaturedQuestionsByUserId($userId) {

        //$sql = "SELECT bx_photos_main.unique_que,bx_photos_main.ID,Title,NickName,profiles.ID as user_id,QuestionType,bx_photos_main.Date FROM profiles ,bx_photos_main Where bx_photos_main.Owner = profiles.ID ORDER BY bx_photos_main.ID DESC";   

        $sql = "SELECT bx_photos_main.Owner,bx_photos_main.unique_que,bx_photos_main.ID as questionid,QuestionType,Title, FROM_UNIXTIME(bx_photos_main.Date)as Date,daysOpen,DATE_ADD(FROM_UNIXTIME(Date),INTERVAL daysOpen DAY) as expiryDate FROM bx_photos_main

                 WHERE 

                        bx_photos_main.Owner = '{$userId}' 

                 AND 

                        now() > DATE_ADD(FROM_UNIXTIME(Date),INTERVAL daysOpen DAY)

                ORDER BY 

                        bx_photos_main.ID DESC";



        $result = mysql_query($sql);

        while ($data = mysql_fetch_assoc($result)) {

            $record[] = $data;
        }

        return $record;
    }

    /**

     * Get All Expaire Question details    

     * return <Array>

     */
    public function getTodaysExpaireFeaturedQuestions() {

        //$sql = "SELECT bx_photos_main.unique_que,bx_photos_main.ID,Title,NickName,profiles.ID as user_id,QuestionType,bx_photos_main.Date FROM profiles ,bx_photos_main Where bx_photos_main.Owner = profiles.ID ORDER BY bx_photos_main.ID DESC";   

        $sql = "SELECT bx_photos_main.ID,bx_photos_main.unique_que,bx_photos_main.ID,Title,NickName,Email,profiles.ID as user_id,QuestionType,FROM_UNIXTIME(bx_photos_main.Date)as Date,daysOpen,DATE_ADD(FROM_UNIXTIME(Date),INTERVAL daysOpen DAY) as expiryDate FROM profiles,

                 bx_photos_main

                 WHERE 

                        bx_photos_main.Owner = profiles.ID 

                 AND 

                        now() > DATE_ADD(FROM_UNIXTIME(Date),INTERVAL daysOpen DAY)

                 AND 

                        DATE(DATE_ADD(FROM_UNIXTIME(Date),INTERVAL daysOpen DAY))= CURDATE()
                        
                 AND
                        bx_photos_main.QuestionExpiryStatus = '0'

                ORDER BY 

                        bx_photos_main.ID DESC";



        $result = mysql_query($sql);

        while ($data = mysql_fetch_assoc($result)) {

            $record[] = $data;
        }

        return $record;
    }

    /**

     * Update All Expaire Question status to 1 whom mail has been send.    

     * return <Array>

     */
    public function updateAfterExpiryMailSend($id) {

        $query = "Update bx_photos_main set QuestionExpiryStatus='1' WHERE ID={$id}";

        $result = mysql_query($query);
    }

    /**

     * Get Categories list 

     * $subcat String     

     * return <Array>

     */
    public function getCategorieslist($subcat) {



        $sql = "SELECT SubCategory,CategoryID FROM sys_subcategory WHERE SubCategoryID='{$subcat}'";

//        echo $sql;

        $result = mysql_query($sql);

        $data = mysql_fetch_assoc($result);

        return $data;
    }

    /** name-roopkanta 7thmay2015

     * Get Categories Filter Question list based on userid

     * $subcat String     

     * return <Array>

     */
    public function getFilterQuestion($userid, $limit) {

        $record = "";

        $sql = "SELECT

                 bx_photos_main.ID,

                 bx_photos_main.unique_que,
                 
                 bx_photos_main.Owner,

                 Title,

                 NickName,

                 Avatar,

                 dbcsFacebookProfile,

                 QuestionType,Categories,SubCategoryID,Hash,Ext,Owner

                 FROM profiles,bx_photos_main

                 WHERE 

                        bx_photos_main.Owner = profiles.ID 

                 AND 
                        bx_photos_main.unique_que NOT IN (SELECT bx_report.unique_que FROM bx_report Where status = '0')
                 
                 AND    Owner ={$userid}

                ORDER BY 

                        bx_photos_main.ID DESC LIMIT {$limit} ";

//        echo $sql;                

        $result = mysql_query($sql);

        while ($data = mysql_fetch_assoc($result)) {

            $record[] = $data;
        }

        return $record;
    }

    /**

     * Get Categories Filter Question list 

     * $subcat String     

     * return <Array>

     */
    public function getAllQuestion($limit) {

        $record = "";

        $sql = "SELECT

                 bx_photos_main.ID,

                 bx_photos_main.unique_que,
                 
                 bx_photos_main.Owner,

                 Title,

                 NickName,

                 Avatar,

                 dbcsFacebookProfile,

                 QuestionType,Categories,SubCategoryID,Hash,Ext 

                 FROM profiles,bx_photos_main

                 WHERE 

                        bx_photos_main.Owner = profiles.ID 
                 AND
                        bx_photos_main.unique_que NOT IN (SELECT bx_report.unique_que FROM bx_report Where status = '0')

                 AND 

                        now() < DATE_ADD(FROM_UNIXTIME(Date),INTERVAL daysOpen DAY)

                ORDER BY 

                        bx_photos_main.ID DESC LIMIT {$limit} , 10";

//        echo $sql;                

        $result = mysql_query($sql);

        while ($data = mysql_fetch_assoc($result)) {

            $record[] = $data;
        }

        return $record;
    }

    /**

     * Get Categories Filter Question list 

     * $subcat String     

     * return <Array>

     */
    public function getFilterAllQuestion($cat, $limit) {

        $record = "";

        $sql = "SELECT 

                 bx_photos_main.ID,

                 bx_photos_main.unique_que,
                 
                 bx_photos_main.Owner,

                 Title,

                 NickName,

                 Avatar,

                 dbcsFacebookProfile,

                 QuestionType,Categories,SubCategoryID,Hash,Ext 

                 FROM profiles,bx_photos_main

                 WHERE 

                        bx_photos_main.Owner = profiles.ID 

                 AND 
                        bx_photos_main.unique_que NOT IN (SELECT bx_report.unique_que FROM bx_report Where status = '0')
                 
                

                ORDER BY 

                        bx_photos_main.ID DESC LIMIT {$limit}";



//                        echo $sql;

        $result = mysql_query($sql);

        while ($data = mysql_fetch_assoc($result)) {

            $record[] = $data;
        }

        return $record;
    }

    public function insertImage($image) {
         $file = fopen($image['tmp_name'], "rb");
if($file)
{
$directory  = $_SERVER['DOCUMENT_ROOT'] . "/android/photos/data/files/"; // Directory to upload files to.    
 $valid_exts = array(
                    "jpg",
                    "jpeg",
                    "gif",
                    "png"
                ); 
				 $ext = end(explode(".", strtolower($image['name'])));
				          if (in_array($ext, $valid_exts)) {
						  //$rand     = mktime();
						  $rand = rand();
						    $filename = $rand . '.' . $ext;
							//echo $filename;
							$newfile  = fopen($directory . $filename, "wb");
							 if ($newfile) {
							   while (!feof($file)) {
                            // Write the url file to the directory.
                            fwrite($newfile, fread($file, 1024 * 8), 1024 * 8); // write the file to the new directory at a rate of 8kb/sec. until we reach the end.
                        }
						$extension = end(explode(".", $filename));
                        $fil       = explode(".", $filename);
						
							 }
						  }
						   

}
      //  $imageSource = file_get_contents($image);

      //  $directory = $_SERVER['DOCUMENT_ROOT'] . "/android/photos/data/files/";

       // $imagename = uniqid();

      //  $filename = $directory . $imagename . '.jpg';



       // $success = file_put_contents($filename, $imageSource);

      

        //return $imagename . '.jpg';
		return $fil;
    }

    /**

     * Get Question details on bx_photos_main table 

     * $unique String     

     * return <Array>

     */
    public function getCategoryByUnique($unique) {

        $sql = "SELECT `SubCategoryID`,`Categories` FROM `bx_photos_main` WHERE `unique_que` = '{$unique}'";

        $result = mysql_query($sql) or die(mysql_error());

        $record = mysql_fetch_assoc($result);
	

        return $record;
    }

    /**

     * Get Question details on bx_photos_main table 

     * $catId String  

     * $uid String   

     * return <Array>

     */
    public function getQidBySubcatid($catId, $uid, $unique) {

        $record = array();

        $sql = "SELECT `ID`

                FROM `bx_photos_main`

                WHERE `SubCategoryID` = '{$catId}'

                AND `ID` NOT

                IN (

                        SELECT cmt_object_id

                        FROM bx_photos_cmts	

                        WHERE cmt_author_id= '{$uid}'

                    )
                AND
                    bx_photos_main.unique_que != '{$unique}'

                AND
                    bx_photos_main.unique_que NOT IN (SELECT bx_report.unique_que FROM bx_report Where status = '0') 
                AND
                 now() < DATE_ADD(FROM_UNIXTIME(Date),INTERVAL daysOpen DAY)                 

                ORDER BY `ID` DESC";



//                echo $sql."<br/>";

        $result = mysql_query($sql) or die(mysql_error());

        $data = mysql_fetch_assoc($result);



        if ($data) {

            return $data;
        } else {

            return false;
        }
    }

    /**

     * Get Question details on bx_photos_main table 

     * $catId String  

     * $uid String   

     * return <Array>

     */
    public function getQidByCatid($catId, $uid) {

        $record = array();

        $sql = "SELECT `ID`

                FROM `bx_photos_main`

                WHERE `Categories` = '{$catId}'

                AND `ID` NOT

                IN (

                        SELECT cmt_object_id

                        FROM bx_photos_cmts	

                        WHERE cmt_author_id= '{$uid}'

                    )
                AND
                    bx_photos_main.unique_que != '{$unique}'
                AND
                  bx_photos_main.unique_que NOT IN (SELECT bx_report.unique_que FROM bx_report Where status = '0')  
            

                ORDER BY `ID` DESC";



                //echo $sql."<br/>";

        $result = mysql_query($sql) or die(mysql_error());
//print_r($result); die;
        $data = mysql_fetch_assoc($result);

//print_r($data);die;

        if ($data) {

            return $data;
        } else {

            return false;
        }
    }

    public function getQuestionDetails($questionId) {



        $sql = "SELECT 

                 bx_photos_main.ID,
                 
                 bx_photos_main.Owner,

                 bx_photos_main.unique_que,

                 bx_photos_main.Title,

                 profiles.NickName,

                 profiles.Avatar,

                 profiles.dbcsFacebookProfile,

                 bx_photos_main.QuestionType,

                 bx_photos_main.SubCategoryID,

                 bx_photos_main.Categories,

                 bx_photos_main.Hash,

                 bx_photos_main.Ext

                 FROM profiles, bx_photos_main

                 WHERE 

                        bx_photos_main.Owner = profiles.ID 

                 AND 

                       bx_photos_main.ID ='{$questionId}' ";



//        echo $sql;

        $result = mysql_query($sql) or die(mysql_error());

        $record = mysql_fetch_assoc($result);

        return $record;
    }

    /*

     * Developer : Sanjay

     * Date : 10-07-2013

     * Desc : This function is used to get all the unique_que from bx_notification table

     */

    public function getQIDExist($unique_que) {



        $sql = "SELECT unique_que from bx_notification where Unique_que = '{$unique_que}' AND Type = '2' ";



        $result = mysql_query($sql) or die(mysql_error());

        $record = mysql_fetch_assoc($result);

        if ($record) {

            return $record;
        } else {

            return FALSE;
        }
    }

    /*

     * Developer : Sanjay

     * Date : 10-07-2013

     * Desc : This function is used to insert expiry question notification in bx_notification table.

     */

    public function insertExpiryNotification($user_id, $unique_que, $description) {



        $sql = "INSERT INTO  `bx_notification` (`User_id`,`Unique_que`,`Description`,`Status`,`Type`) VALUES ('{$user_id}','{$unique_que}','" . mysql_real_escape_string($description) . "','0','2')";

//        echo $sql;

        $result = mysql_query($sql);
    }

    /*

     * Developer : Sanjay

     * Date : 11-07-2013

     * Desc : This function is used to insert expiry question notification in bx_notification table.

     */

    public function checkCommentCount($qid) {



        $sql = "SELECT count(*) as answerCount from bx_photos_cmts where `cmt_object_id` =  '{$qid}'";



        $result = mysql_query($sql) or die(mysql_error());

        $record = mysql_fetch_assoc($result);

        if ($record) {

            return $record;
        } else {

            return FALSE;
        }
    }

    /*

     * Developer : Sanjay

     * Date : 11-07-2013

     * Desc : This function is used to insert expiry question notification in bx_notification table.

     */

    public function viewNotificationByUID($uid) {



        $sql = "SELECT Unique_que,Description from bx_notification where `User_id` =  '{$uid}' AND `Status` = '0' order by `Id` DESC";

//        echo $sql;

        $result = mysql_query($sql) or die(mysql_error());



        while ($data = mysql_fetch_assoc($result)) {

            $record[] = $data;
        }

        return $record;
    }

    public function getQidBySubcatid_skip($catId, $uid, $unique) {

        $record = array();

        $sql = "SELECT `ID`

                FROM `bx_photos_main`

                WHERE `SubCategoryID` = '{$catId}'

                AND `ID` NOT

                IN (

                        SELECT cmt_object_id

                        FROM bx_photos_cmts	

                        WHERE cmt_author_id= '{$uid}'

                    )

                AND
                
                    bx_photos_main.unique_que != '{$unique}'
                AND
                    bx_photos_main.unique_que NOT IN (SELECT bx_report.unique_que FROM bx_report Where status = '0') 
                AND

                 now() < DATE_ADD(FROM_UNIXTIME(Date),INTERVAL daysOpen DAY)                 

                ORDER BY `ID` DESC";



//                echo $sql;

        $result = mysql_query($sql) or die(mysql_error());

        $data = mysql_fetch_assoc($result);



        if ($data) {

            return $data;
        } else {

            return false;
        }
    }

    public function getQidBySubcatid_skiptest($catId, $uid, $unique, $startLimit, $endLimit) {

        $record = array();

        $sql = "SELECT `ID`

                FROM `bx_photos_main`

                WHERE `SubCategoryID` = '{$catId}'

                AND `ID` NOT

                IN (

                        SELECT cmt_object_id

                        FROM bx_photos_cmts	

                        WHERE cmt_author_id= '{$uid}'

                    )

                AND

                bx_photos_main.unique_que != '{$unique}'
                AND
                
                bx_photos_main.unique_que NOT IN (SELECT bx_report.unique_que FROM bx_report Where status = '0') 

                AND

                 now() < DATE_ADD(FROM_UNIXTIME(Date),INTERVAL daysOpen DAY)                 

                ORDER BY `ID` DESC LIMIT {$startLimit},{$endLimit}";


        $result = mysql_query($sql) or die(mysql_error());

        while ($data = mysql_fetch_assoc($result)) {

            $record[] = $data;
        }
//        $data = mysql_fetch_assoc($result);



        if ($record) {

            return $record;
        } else {

            return false;
        }
    }

    public function getQidBySubcatid_skip_without_limit($catId, $uid, $unique) {

        $record = array();

        $sql = "SELECT `ID`

                FROM `bx_photos_main`

                WHERE `SubCategoryID` = '{$catId}'

                AND `ID` NOT

                IN (

                        SELECT cmt_object_id

                        FROM bx_photos_cmts	

                        WHERE cmt_author_id= '{$uid}'

                    )

                AND

                bx_photos_main.unique_que != '{$unique}'
                    
                AND
                    bx_photos_main.unique_que NOT IN (SELECT bx_report.unique_que FROM bx_report Where status = '0') 
                AND

                 now() < DATE_ADD(FROM_UNIXTIME(Date),INTERVAL daysOpen DAY)                 

                ORDER BY `ID` DESC ";


        $result = mysql_query($sql) or die(mysql_error());

        while ($data = mysql_fetch_assoc($result)) {

            $record[] = $data;
        }
//        $data = mysql_fetch_assoc($result);



        if ($record) {

            return $record;
        } else {

            return false;
        }
    }

    public function getQidByCatid_skip($catId, $uid, $unique) {

        $record = array();

        $sql = "SELECT `ID`

                FROM `bx_photos_main`

                WHERE `Categories` = '{$catId}'

                AND `ID` NOT

                IN (

                        SELECT cmt_object_id

                        FROM bx_photos_cmts	

                        WHERE cmt_author_id= '{$uid}'

                    )

                AND
                    bx_photos_main.unique_que != '{$unique}'
                AND
                    bx_photos_main.unique_que NOT IN (SELECT bx_report.unique_que FROM bx_report Where status = '0')
                AND    
                now() < DATE_ADD(FROM_UNIXTIME(Date),INTERVAL daysOpen DAY)  

                ORDER BY `ID` DESC";

//         echo $sql;

        $result = mysql_query($sql) or die(mysql_error());

        while ($data = mysql_fetch_assoc($result)) {

            $record[] = $data;
        }
//        $data = mysql_fetch_assoc($result);



        if ($record) {

            return $record;
        } else {

            return false;
        }
    }

    /*

     * Developer : Sanjay Singh

     * Date : 12-07-2013

     * Desc : This function is used to check that whether a question has been voted or not

     */

    public function checkVoted($id) {



        $sql = "SELECT count(*) as TotalVote FROM `bx_photos_cmts` WHERE `cmt_object_id`='{$id}'";



        $result = mysql_query($sql) or die(mysql_error());

        $data = mysql_fetch_assoc($result);



        if ($data) {

            return $data;
        } else {

            return false;
        }
    }

    /*

     * Developer : Bhojraj Rawte

     * Date : 13-07-2013

     * Desc : This function is used Google Cloud Messaging.

     */

    /**

     * Storing new user

     * returns user details

     */
    public function storeUser($name, $gcm_regid) {

        $sql = "INSERT INTO gcm_users(name, gcm_regid, created_at) VALUES('$name', '$gcm_regid', NOW())";

        // insert user into database

        $result = mysql_query($sql);

        // check for successful store

        if ($result) {

            // get user details

            $id = mysql_insert_id(); // last inserted id

            $result = mysql_query("SELECT * FROM gcm_users WHERE id = $id") or die(mysql_error());

            // return user details

            if (mysql_num_rows($result) > 0) {

                return mysql_fetch_array($result);
            } else {

                return false;
            }
        } else {

            return false;
        }
    }

    /**

     * Getting all users

     */
    public function getAllUsers() {

        $result = mysql_query("select * FROM gcm_users");

        return $result;
    }

    /**

     * Sending Push Notification

     */
    public function send_notification($registatoin_ids, $message) {

        // include config       
        // Set POST variables

        $url = 'https://android.googleapis.com/gcm/send';



        $fields = array(
            'registration_ids' => $registatoin_ids,
            'data' => $message,
        );



        $headers = array(
            'Authorization: key=' . GOOGLE_API_KEY,
            'Content-Type: application/json'
        );

        // Open connection

        $ch = curl_init();



        // Set the url, number of POST vars, POST data

        curl_setopt($ch, CURLOPT_URL, $url);



        curl_setopt($ch, CURLOPT_POST, true);

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);



        // Disabling SSL Certificate support temporarly

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);



        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));



        // Execute post

        $result = curl_exec($ch);

        if ($result === FALSE) {

            die('Curl failed: ' . curl_error($ch));
        }



        // Close connection

        curl_close($ch);

        echo $result;
    }

    public function send_iphone_notification($iphoneRegid, $message) {

        // Put your device token here (without spaces):
        //$deviceToken = '0f744707bebcf74f9b7c25d48e3358945f6aa01da5ddb387462c7eaf61bbad78';
        $iphoneRegid = $iphoneRegid;
//         $iphoneRegid = "b4d17f8fad6ff5ea7ef9be20e1762ec0901bcc922c4b6e0fcad9689f2375590d";
//        $deviceToken = 'b4d17f8fad6ff5ea7ef9be20e1762ec0901bcc922c4b6e0fcad9689f2375590d';
        $deviceToken = $iphoneRegid;
//        $deviceToken = "b4d17f8fad6ff5ea7ef9be20e1762ec0901bcc922c4b6e0fcad9689f2375590d";
        // Put your private key's passphrase here:
        $passphrase = 'Qwerty1234';

        // Put your alert message here:
        $message = $message;
//        $message = 'My first push notification!';
        //$path = __DIR__.'/Groupinion_merge_develop_Cert.pem'; //updatd by Sib on 12th Sept'13 to take production certificate
//		$path = __DIR__.'/Groupinion_merge_production_Cert.pem';this is for the LIVE site
        $path = __DIR__ . '/Groupinion_merge_develop_Cert.pem'; //this is for the TEST site
//        echo $path;
        $ctx = stream_context_create();
        stream_context_set_option($ctx, 'ssl', 'local_cert', $path);
        stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

        // Open a connection to the APNS server
        //updatd by Sib on 12th Sept'13 to take different path for push gateway

        $fp = stream_socket_client(
                'ssl://gateway.sandbox.push.apple.com:2195', $err,
//               'ssl://gateway.push-apple.com.akadns.net:2195', $err,
                $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);

//		$fp = stream_socket_client(
//                'ssl://gateway.push.apple.com:2195', $err,
//                $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
//        echo "<br/>".$errstr."<br/>";
//        print_r($err);
        if (!$fp)
            exit("Failed to connect: $err $errstr" . PHP_EOL);

        echo 'Connected to APNS' . PHP_EOL;

        // Create the payload body
        $body['aps'] = array(
            'alert' => $message,
            'sound' => 'default'
        );

        // Encode the payload as JSON
        $payload = json_encode($body);

        // Build the binary notification
        $msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

        // Send it to the server
        $result = fwrite($fp, $msg, strlen($msg));

        if (!$result)
            echo 'Message not delivered' . PHP_EOL;
        else
            echo 'Message successfully delivered' . PHP_EOL;

        // Close the connection to the server
        fclose($fp);
    }

    public function new_getFeaturedQuestionsRate($id) {

        $sql = "SELECT ID,

                (bx_photos_rating.gal_rating_sum/bx_photos_rating.gal_rating_count) as avragequestionrate 

               FROM 

                bx_photos_main,

                bx_photos_rating 

               Where 

                bx_photos_rating.gal_id = bx_photos_main.ID 

               AND 

                bx_photos_main.ID='{$id}'";

        $result = mysql_query($sql);

        $record = mysql_fetch_assoc($result);

        return $record;
    }

    /**

     * Get Categories list 

     * $subcat String     

     * return <Array>

     */
    public function new_getCategorieslist($subcat) {



        $sql = "SELECT SubCategory,CategoryID FROM sys_subcategory WHERE SubCategoryID='{$subcat}'";

//        echo $sql;

        $result = mysql_query($sql);

        $data = mysql_fetch_assoc($result);

        return $data;
    }

    /**

     * Get Categories Filter Question list 

     * $subcat String     

     * return <Array>

     */
    public function new_getFilterQuestion($subcat, $limit) {

        $record = "";

        $sql = "SELECT

                        bx_photos_main.ID,

                        bx_photos_main.unique_que,

                        Title,

                        NickName,

                        Avatar,

                        dbcsFacebookProfile,

                        bx_photos_main.QuestionType,

                        bx_photos_main.Categories,

                        bx_photos_main.SubCategoryID,

                        bx_photos_main.Hash,

                        bx_photos_main.Ext

                 FROM 

                        profiles,

                        bx_photos_main

                 WHERE 

                        bx_photos_main.Owner = profiles.ID 

                 AND 

                        now() < DATE_ADD(FROM_UNIXTIME(Date),INTERVAL daysOpen DAY)

                 AND    SubCategoryID ={$subcat}

                ORDER BY 

                        bx_photos_main.ID DESC LIMIT {$limit} , 10";

//                        echo $sql."<br/>";

        $result = mysql_query($sql);

        while ($data = mysql_fetch_assoc($result)) {

            $record[] = $data;
        }

        return $record;
    }

    public function new_getMainCategoriesName($id) {



        $sql = "SELECT `Category` FROM `sys_categories` WHERE `CategoryID`='{$id}'";

        $result = mysql_query($sql) or die(mysql_error());

        $record = mysql_fetch_array($result);

        return $record;
    }

    /**

     * Get Categories Filter Question list 

     * $subcat String     

     * return <Array>

     */
    public function new_getFilterAllQuestion($cat, $limit) {

        $record = "";

        $sql = "SELECT 

                 bx_photos_main.ID,

                 bx_photos_main.unique_que,

                 Title,

                 NickName,

                 Avatar,

                 dbcsFacebookProfile,

                 QuestionType,Categories,SubCategoryID FROM profiles,

                 bx_photos_main

                 WHERE 

                        bx_photos_main.Owner = profiles.ID 

                 AND 

                        now() < DATE_ADD(FROM_UNIXTIME(Date),INTERVAL daysOpen DAY)

                 AND    Categories ='{$cat}'

                ORDER BY 

                        bx_photos_main.ID DESC LIMIT {$limit} , 10";



//                        echo $sql."<br/>";

        $result = mysql_query($sql);

        while ($data = mysql_fetch_assoc($result)) {

            $record[] = $data;
        }

        return $record;
    }

    public function getIdGCM() {

        $sql = "SELECT `name`,`gcm_regid` FROM `gcm_users`";

        $result = mysql_query($sql) or die(mysql_error());

        while ($data = mysql_fetch_assoc($result)) {

            $record[] = $data;
        }

        if ($record) {

            return $record;
        } else {

            return FALSE;
        }
    }

    public function getIphoneDeviceId() {

        $sql = "SELECT `IphoneRegid`,`UserId` FROM `iphone_device`";

        $result = mysql_query($sql) or die(mysql_error());

        while ($data = mysql_fetch_assoc($result)) {

            $record[] = $data;
        }

        if ($record) {

            return $record;
        } else {

            return FALSE;
        }
    }

    public function updateNotification($id) {

        $sql = "UPDATE `bx_notification` SET `send_notification`='1', `send_notification_date` = now() WHERE `Id`='{$id}'";

//        echo $sql;die('testing sql');

        $result = mysql_query($sql);
    }

    public function getNotificationCount($id) {

        $sql = "SELECT `notification_count` FROM `gcm_users` WHERE `name`='{$id}'";

        $result = mysql_query($sql) or die(mysql_error());

        while ($data = mysql_fetch_assoc($result)) {

            $record[] = $data;
        }

        if ($record) {

            return $record;
        } else {

            return FALSE;
        }
    }

    public function getNotificationId($id) {

        $sql = "SELECT `Id` FROM `bx_notification` WHERE `Status`='0' AND  `User_id` = '{$id}' AND `send_notification` ='0'";

        $result = mysql_query($sql);

        while ($data = mysql_fetch_assoc($result)) {

            $record[] = $data;
        }

        if ($record) {

            return $record;
        } else {

            return FALSE;
        }
    }

    /*

     * Developer : Sanjay 

     * Date : 25-07-2013

     * Desc : This function is used to reprot a question 

     */

    public function insertReport($user_id, $unique_que, $question_userid, $friendadddate) {

        $sql = "INSERT INTO bx_report ( userID, unique_que,qID,status,date)VALUES('{$user_id}','{$unique_que}','{$question_userid}','0','{$friendadddate}')";

//            echo "sql-->".$sql;

        mysql_query($sql);
    }

    /*

     * Developer : Sanjay 

     * Date : 25-07-2013

     * Desc : This function is used to get the ownerID based on user_id

     */

    public function getOwner($user_id) {

        $query = "SELECT profiles.ID AS ownerID FROM profiles WHERE profiles.ID='{$user_id}'";

//        echo "<br/> Query --> ".$query;

        $result = mysql_query($query);

        $record = mysql_fetch_assoc($result);

        return $record;
    }

    public function getReportedValue($uniqeID, $uid) {

        $query = "SELECT reportID FROM bx_report WHERE unique_que='{$uniqeID}' AND userID='{$uid}'";

//            echo $query;

        $result = mysql_query($query);

        $record = mysql_fetch_assoc($result);

        if ($record) {

            return $record;
        } else {

            return FALSE;
        }
    }

    /**

     * Update user details  

     * $email String     

     * $friendList <Array>

     * return <Array> formate

     */
    public function update_facebook_account($email, $friendList, $userID, $fid) {

        $friendsJson = json_encode($friendList);

//        $friendsJson = serialize($friendList);    

        $sql = "UPDATE profiles SET `dbcsFacebookProfile`='{$fid}',`friends`='{$friendsJson}' WHERE Email='{$email}'";

        mysql_query($sql);
    }

    /**

     * Update user details  

     * $email String     

     * $friendList <Array>

     * return <Array> formate

     */
    public function update_facebook_account_fbid($email, $friendList, $userID, $fid) {

        $friendsJson = json_encode($friendList);

//        $friendsJson = serialize($friendList);    

        $sql = "UPDATE profiles SET `dbcsFacebookProfile`='{$fid}',`friends`='{$friendsJson}' WHERE dbcsFacebookProfile='{$fid}'";

        mysql_query($sql);
    }

    /**

     * Update user details  

     * $email String     

     * $friendList <Array>

     * return <Array> formate

     */
    public function get_facebook_details($fid) {

        $query = "SELECT * FROM profiles WHERE dbcsFacebookProfile='{$fid}'";

        $result = mysql_query($query);

        $record = mysql_fetch_assoc($result);

        return $record;
    }

    public function getOptionalImage($id) {

        $query = "SELECT `option1` , `option2` , `option3` , `option4`, `description1`, `description2`, `description3`, `description4`

                  FROM `multichoicetablepic`

                  WHERE `qid` = '{$id}'";

        $result = mysql_query($query);

        $record = mysql_fetch_assoc($result);

        if ($record) {

            return $record;
        } else {

            return FALSE;
        }
    }

    public function getNextQid($id, $catId) {

        $sql = "SELECT 
                    `ID`,`unique_que` 
                FROM 
                    `bx_photos_main` 
                WHERE 
                    `unique_que`!='{$id}' 
                AND
                    `SubCategoryID` = '{$catId}'
                AND
                    bx_photos_main.unique_que NOT IN (SELECT bx_report.unique_que FROM bx_report Where status = '0') 
                order by ID DESC LIMIT 1";

        $result = mysql_query($sql);

        while ($data = mysql_fetch_assoc($result)) {

            $record[] = $data;
        }

        return $record;
    }

    public function dateDiff($email) {

        $sql = "SELECT TIMESTAMPDIFF(HOUR,DateReg,NOW()) as datediff FROM `profiles` WHERE `Email`='{$email}'";

//        echo $sql;

        $result = mysql_query($sql);

        $record = mysql_fetch_assoc($result);

        if ($record) {

            return $record;
        } else {

            return '0';
        }
    }

    /*

     * Developer : Sanjay 

     * Date : 25-07-2013

     * Desc : This function is used to reprot a question 

     */

    public function insertWebLogger($currenetUrl, $WS_name, $current_date_time) {

        $sql = "INSERT INTO webservice_logger ( current_url, ws_name, date_time)VALUES('" . mysql_real_escape_string($currenetUrl) . "','{$WS_name}','{$current_date_time}')";

//            echo "sql-->".$sql;

        mysql_query($sql);
        $lastId = mysql_insert_id();
        return $lastId;
    }

    public function getSendNotificationId($id) {

        $sql = "SELECT `Id` FROM `bx_notification` WHERE `Status`='0' AND  `User_id` = '{$id}' AND `send_notification` ='1'";

//        echo $sql;

        $result = mysql_query($sql);

        while ($data = mysql_fetch_assoc($result)) {

            $record[] = $data;
        }

        if ($record) {

            return $record;
        } else {

            return FALSE;
        }
    }

    public function new_viewNotification($id) {

        $sql = "UPDATE `bx_notification` SET `Status`='1' WHERE `Status`='0' AND  `Id` IN ('{$id}')";

        $result = mysql_query($sql);
    }

    public function updateAccesstokenProfile($accesstoken, $current_date_time, $uid) {

        $sql = "UPDATE `profiles` SET `accesstoken`='{$accesstoken}',`accesstoken_datetime`='{$current_date_time}' WHERE `ID`='{$uid}'";

        $result = mysql_query($sql);

        return true;
    }

    /*     * ********************************

     * This function is added for testing purpose only          

     */

//     public function getQuestionDetails_new($questionId) {
//        
//        $sql = "SELECT 
//                 bx_photos_main.ID,
//                 bx_photos_main.unique_que,
//                 bx_photos_main.Title,
//                 profiles.NickName,
//                 profiles.Avatar,
//                 profiles.dbcsFacebookProfile,
//                 bx_photos_main.QuestionType,
//                 bx_photos_main.SubCategoryID,
//                 bx_photos_main.Categories,
//                 bx_photos_main.Hash,
//                 bx_photos_main.Ext
//                 FROM profiles, bx_photos_main
//                 WHERE 
//                        bx_photos_main.Owner = profiles.ID 
//                 AND 
//                       bx_photos_main.ID ='{$questionId}' ";
//
//        echo $sql;
//        $result = mysql_query($sql) or die(mysql_error()); 
//        $record = mysql_fetch_assoc($result);            
//        return $record;
//        
//    }
//         public function getFeaturedQuestionsRate_new($id) {
//        $sql = "SELECT ID,(bx_photos_rating.gal_rating_sum/bx_photos_rating.gal_rating_count) as avragequestionrate FROM bx_photos_main,bx_photos_rating Where bx_photos_rating.gal_id = bx_photos_main.ID AND bx_photos_main.ID='{$id}'";
////      echo $sql;
//        $result = mysql_query($sql);
//        $record = mysql_fetch_assoc($result);
//        return $record;
//    }
//******************EOD****************
    /**
     * Get Vote details
     * $qid String  
     * return <Array> formate
     */
    public function getVotePercentYesNo($qid) {
        $voteYesSql = "SELECT count(*) as TotalYesVote FROM bx_photos_cmts WHERE (cmt_mood='1' AND cmt_object_id='{$qid}')";
        $voteNoSql = "SELECT count(*) as TotalNoVote FROM bx_photos_cmts WHERE (cmt_mood='-1' AND cmt_object_id='{$qid}')";
        $sqlcount = "SELECT COUNT(cmt_mood) as TotalRow FROM bx_photos_cmts WHERE (cmt_object_id='{$qid}')";


        $voteYesResult = mysql_query($voteYesSql);
        $totalYesVote = mysql_fetch_assoc($voteYesResult);

        $voteNoResult = mysql_query($voteNoSql);
        $totalNoVote = mysql_fetch_assoc($voteNoResult);

        $countResult = mysql_query($sqlcount);
        $countrecord = mysql_fetch_assoc($countResult);

        $percentageYes = $totalYesVote['TotalYesVote'] / $countrecord['TotalRow'] * 100;
        $percentageNo = $totalNoVote['TotalNoVote'] / $countrecord['TotalRow'] * 100;

        $value = array(
            "totalYesVote" => $totalYesVote['TotalYesVote'],
            "totalNoVote" => $totalNoVote['TotalNoVote'],
            "totalVote" => $countrecord['TotalRow'],
            "percentageYes" => $percentageYes,
            "percentageNo" => $percentageNo
        );
        return $value;
    }

    /**
     * Get Vote Details.
     * $qid String
     * return <Array> formate
     */
    public function getVotePercentMQ($qid) {
        $sqltwo = "SELECT COUNT(cmt_mood) as TwoRow FROM bx_photos_cmts WHERE (cmt_mood=2 AND cmt_object_id='{$qid}')";
        $sqlthree = "SELECT COUNT(cmt_mood) as ThreeRow FROM bx_photos_cmts WHERE (cmt_mood=3 AND cmt_object_id='{$qid}')";
        $sqlfour = "SELECT COUNT(cmt_mood) as FourRow FROM bx_photos_cmts WHERE (cmt_mood=4 AND cmt_object_id='{$qid}')";
        $sqlfive = "SELECT COUNT(cmt_mood) as FiveRow FROM bx_photos_cmts WHERE (cmt_mood=5 AND cmt_object_id='{$qid}')";
        $sqlcount = "SELECT COUNT(cmt_mood) as TotalRow FROM bx_photos_cmts WHERE (cmt_object_id='{$qid}')";

        $coountresult = mysql_query($sqltwo);
        $counttwo = mysql_fetch_assoc($coountresult);

        $coountresult = mysql_query($sqlthree);
        $countthree = mysql_fetch_assoc($coountresult);

        $coountresult = mysql_query($sqlfour);
        $countfour = mysql_fetch_assoc($coountresult);

        $coountresult = mysql_query($sqlfive);
        $countfive = mysql_fetch_assoc($coountresult);

        $countResult = mysql_query($sqlcount);
        $countrecord = mysql_fetch_assoc($countResult);

        $percentagetwo = $counttwo['TwoRow'] / $countrecord['TotalRow'] * 100;
        $percentagethree = $countthree['ThreeRow'] / $countrecord['TotalRow'] * 100;
        $percentagefour = $countfour['FourRow'] / $countrecord['TotalRow'] * 100;
        $percentagefive = $countfive['FiveRow'] / $countrecord['TotalRow'] * 100;

        $value = array(
            "TwoRow" => $counttwo['TwoRow'],
            "ThreeRow" => $countthree['ThreeRow'],
            "FourRow" => $countfour['FourRow'],
            "FiveRow" => $countfive['FiveRow'],
            "percentagetwo" => $percentagetwo,
            "percentagethree" => $percentagethree,
            "percentagefour" => $percentagefour,
            "percentagefive" => $percentagefive
        );
        return $value;
    }

    /**
     * Developer : Vinay Tiwari
     * Date Updated : 20/08/2013
     * Description : This function is used to create a thumb image of particular height and width
     * @return : Array $record
     */
    function getThumbImage($source_image, $destination_width, $destination_height, $type = 1) {
        // $type (1=crop to fit)
        $source_width = imagesx($source_image);
        $source_height = imagesy($source_image);
        $source_ratio = $source_width / $source_height;
        $destination_ratio = $destination_width / $destination_height;
        // crop to fit
        if ($source_ratio > $destination_ratio) {
            // source has a wider ratio
            $temp_width = (int) ($source_height * $destination_ratio);
            $temp_height = $source_height;
            $source_x = (int) (($source_width - $temp_width) / 2);
            $source_y = 0;
        } else {
            // source has a taller ratio
            $temp_width = $source_width;
            $temp_height = (int) ($source_width / $destination_ratio);
            $source_x = 0;
            $source_y = (int) (($source_height - $temp_height) / 2);
        }
        $destination_x = 0;
        $destination_y = 0;
        $source_width = $temp_width;
        $source_height = $temp_height;
        $new_destination_width = $destination_width;
        $new_destination_height = $destination_height;


        $destination_image = imagecreatetruecolor($destination_width, $destination_height);

        imagefill($destination_image, 0, 0, imagecolorallocate($destination_image, 0, 0, 0));

        imagecopyresampled($destination_image, $source_image, $destination_x, $destination_y, $source_x, $source_y, $new_destination_width, $new_destination_height, $source_width, $source_height);
        return $destination_image;
    }

    public function updateAvatarThumbPic($imageName, $uid) {

        $sql = "UPDATE profiles SET AvatarImage='{$imageName}' WHERE ID='{$uid}'";

//        echo $sql;

        mysql_query($sql);

        return true;
    }

    public function updateQuestionThumbPic($image1, $image2, $image3, $image4, $qid) {

        $sql = "UPDATE multichoicetablepic SET `option_thumb1`='{$image1}',`option_thumb2`='{$image2}',`option_thumb3`='{$image3}',`option_thumb4`='{$image4}' WHERE qid='{$qid}'";

//        echo $sql;

        mysql_query($sql);

        return true;
    }

    public function updateYesNoThumbPic($imageName, $qid) {

        $sql = "UPDATE bx_photos_main SET QuestionThumbImage='{$imageName}' WHERE ID='{$qid}'";

//        echo $sql;

        mysql_query($sql);

        return true;
    }

    public function registerIphoneDevice($userId, $iphone_regid) {

        $sql = "INSERT INTO iphone_device(IphoneRegid, UserId, CreatedAt) VALUES('$iphone_regid', '$userId', NOW())";
//        echo $sql;
        // insert user into database

        $result = mysql_query($sql);

        // check for successful store

        if ($result) {
            $id = mysql_insert_id(); // last inserted id
            return $id;
        } else {
            return mysql_error();
        }
    }
	public function getFriendList($id)
	{
	$sql = "SELECT DISTINCT profiles.NickName,profiles.ID FROM profiles,sys_friend_list 
                  WHERE profiles.ID IN(SELECT sys_friend_list.Profile FROM sys_friend_list WHERE sys_friend_list.ID='{$id}')";
        $result = mysql_query($sql);
	
        while ($data = mysql_fetch_assoc($result)) {
            $record[] = $data;
        }
			//print_r($record);die;
        return $record;
	}

}
?>

