<?php

/**
 * Class to handle all db operations
 * This class will have CRUD methods for database tables
 *
 * @author Ravi Tamada
 * @link URL Tutorial link
 */
class DbHandler {

    private $conn;

    function __construct() {
        require_once dirname(__FILE__) . '/DbConnect.php';
        // opening db connection
        $db = new DbConnect();
        $this->conn = $db->connect();
    }

    /* ------------- `Strudent user` table method ------------------ */

    /**
     * Creating new student user
     */
    public function createStudentUser($email, $full_name, $password, $subject, $year, $section) {
        require_once 'PassHash.php';
        $response = array();

        // First check if user already existed in db
        if (!$this->isUserExists($email)) {
            // Generating password hash
            $password_hash = PassHash::hash($password);

            // Generating API key
            $api_key = $this->generateApiKey();
            $unique=$this->generateUniqueKey();
            $profile_pic = "https://gurungmanish.com.np/postPictures/defaultuser.jpg";

            // insert query
            $stmt = $this->conn->prepare("INSERT INTO student_user(email, full_name, password, subject, year, section, api_key, profile_pic, unique_id) values(?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssssss", $email, $full_name, $password_hash, $subject, $year, $section, $api_key, $profile_pic, $unique);

            $result = $stmt->execute();

            $stmt->close();

            // Check for successful insertion
            if ($result) {
                // User successfully inserted
                return USER_CREATED_SUCCESSFULLY;
            } else {
                // Failed to create user
                return USER_CREATE_FAILED;
            }
        } else {
            // User with same email already existed in the db
            return USER_ALREADY_EXISTED;
        }

        return $response;
    }

  /**
     * Creating new staff user
     */
    public function createStaffUser($email, $full_name, $password, $subject1, $subject2, $subject3) {
        require_once 'PassHash.php';
        $response = array();

        // First check if user already existed in db
        if (!$this->staffExists($email)) {
            // Generating password hash
            $password_hash = PassHash::hash($password);

            // Generating API key
            $api_key = $this->generateApiKey();
            $unique=$this->generateUniqueKey();
            $profile_pic = "https://gurungmanish.com.np/postPictures/defaultuser.jpg";


            // insert query
            $stmt = $this->conn->prepare("INSERT INTO staff_user(email, full_name, password, subject1, subject2, subject3, api_key, profile_pic, unique_id) values(?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssssss", $email, $full_name, $password_hash, $subject1,  $subject2, $subject3, $api_key, $profile_pic, $unique);

            $result = $stmt->execute();

            $stmt->close();

            // Check for successful insertion
            if ($result) {
                // User successfully inserted
                return USER_CREATED_SUCCESSFULLY;
            } else {
                // Failed to create user
                return USER_CREATE_FAILED;
            }
        } else {
            // User with same email already existed in the db
            return USER_ALREADY_EXISTED;
        }

        return $response;
    }
    /**
     * Checking user login
     * @param String $email User login email id
     * @param String $password User login password
     * @return boolean User login status success/fail
     */
     public function checkLogin($email, $password) {
        if ($this->isUserExists($email)){
            $stmt = $this->conn->prepare("SELECT password FROM student_user WHERE email = ?");

            $stmt->bind_param("s", $email);

            $stmt->execute();

            $stmt->bind_result($password_hash);

            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                // Found user with the email
                // Now verify the password

                $stmt->fetch();

                $stmt->close();

                if (PassHash::check_password($password_hash, $password)) {
                    // User password is correct
                    return TRUE;
                } else {
                    // user password is incorrect
                    return FALSE;
                }
            } else {
                $stmt->close();

                // user not existed with the email
                return FALSE;
            }
        }else{
            $stmt = $this->conn->prepare("SELECT password FROM staff_user WHERE email = ?");

            $stmt->bind_param("s", $email);

            $stmt->execute();

            $stmt->bind_result($password_hash);

            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                // Found user with the email
                // Now verify the password

                $stmt->fetch();

                $stmt->close();

                if (PassHash::check_password($password_hash, $password)) {
                    // User password is correct
                    return TRUE;
                } else {
                    // user password is incorrect
                    return FALSE;
                }
            } else {
                $stmt->close();

                // user not existed with the email
                return FALSE;
            }
        }
    }

    /**
     * Check Routine
     */
    public function checkRoutine($subject, $year, $section) {
        // fetching user by email
        $stmt = $this->conn->prepare("SELECT * FROM schedule WHERE subject = ? AND year = ? AND section = ?");

        $stmt->bind_param("sss", $subject, $year, $section);

        $stmt->execute();   

        $result = $stmt->get_result();
        $full_rows = array();
    

        if ($result->num_rows > 0) {
            $stmt->close();
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            $stmt->close();
            return 0;
        }
    }



    /**
     * Show All Staff
     */
    public function showStaff(){
        $stmt = $this->conn->prepare("SELECT * from staff_user");
        $stmt->execute();   
        $result = $stmt->get_result();
        $full_rows = array();
    

        if ($result->num_rows > 0) {
            $stmt->close();
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            $stmt->close();
            return 0;
        }
    }


    /**
     * Make post
     */
    public function upload($unique_id,$post_desc, $fileSize, $fileTmpName, $fileType, $fileExtension ,$filename , $imageLink, $has_file)
    {
        if($has_file){
        $currentDir = getcwd();
        $errors = [];
        $uploadDirectory ="/". $this->getDirectory();
        $uploadPath = $currentDir . $uploadDirectory . basename($filename);
        $fileExtensions = ['jpeg', 'jpg', 'png', 'JPG', 'PNG', 'JPEG'];
    
        if (!in_array($fileExtension, $fileExtensions)) {
            return 2;
        } elseif ($fileSize > 14256000) {
            return 3;
        } else {
    
            if (file_exists($uploadPath)) {
    
                unlink($uploadPath);
    
    
            }
    
            $didUpload = move_uploaded_file($fileTmpName, $uploadPath);
            if ($didUpload) {
                $this->createPost( $post_desc,$imageLink,  $unique_id);
                return 1;
            } else {
                return 4;
            }
    
    
        }
        
        }
        else{
             $this->createPost( $post_desc,"",  $unique_id);
                return 1;
        }
        
        
    
    
    }

    function getDirectory()
    {
        $dir = "../../../postPictures/";
    
        $year = date("Y");
        $month = date("m");
        $yearDirectory = $dir . $year;
        $folderDirectory = $dir . $year . "/" . $month ."/";
        if (file_exists($yearDirectory)) {
            if (file_exists($folderDirectory) == false) {
                mkdir($folderDirectory, 0777);
                return $folderDirectory ;
            }
        } else {
            mkdir($yearDirectory, 0777);
            mkdir($folderDirectory, 0777);
            return $folderDirectory ;
        }
        return $folderDirectory ;
    }


    public function createPost($post_detail, $picture, $unique_id){
        $stmt = $this->conn->prepare("INSERT INTO post(post_description, post_image, unique_id) values(?, ?, ?)");
        $stmt->bind_param("sss", $post_detail, $picture, $unique_id );
        $result = $stmt->execute();
        $stmt->close();   
            return $result;   
    }

    public function getAllPost($user_id)
    {
        $data = array();
        $data_full = array();
       
        $stmt = $this->conn->prepare("SELECT * FROM `post` ORDER BY `post_date` DESC");
        if ($stmt->execute()) {
            $stmt->bind_result($id,$post_desc, $post_image, $post_last_updated, $post_date,$unique_id);
        
            while ($stmt->fetch()) { 
                $feed = array();
                $feed["id"] = $id;
                $feed["post_desc"] = $post_desc;
                $feed["post_image"] = $post_image;
                $feed["post_last_updated"] = $post_last_updated;
                $feed["post_date"] = $post_date;
                $feed["unique_id"] = $unique_id;
                array_push($data, $feed);
            } 

            $stmt->close();
         
        } else {
            return NULL;
        }

        foreach($data as $d){
                $feed = array();
                $feed["id"]=    $d["id"] ;
                $feed["post_desc"]=   $d["post_desc"];
                $feed["post_image"]  =    $d["post_image"];
                $feed["post_last_updated"] =   $d["post_last_updated"]; 
                $feed["post_date"] =   $d["post_date"]; 
                $feed["unique_id"] =   $d["unique_id"]; 
                $user_profile = $this -> getUserImageNameFromID($d["unique_id"]);
                $feed["profile_image"] =  $user_profile["profile_pic"];
                $feed["full_name"] = $user_profile["full_name"];
                $feed["unique_id"] = $user_profile["unique_id"];
                $feed["isLiked"] = $this -> isLiked($d["id"],$user_id);
                $feed["likeCount"] = $this -> likeCount($d["id"]);
                $feed["following"] = $this -> isFollowing($user_id,$d["unique_id"]);
                array_push($data_full, $feed);
        }
        return $data_full;
    }
    
    
    
    
    public function getMyPost($user_id){
        $data = array();
        $data_full = array();
       
        $stmt = $this->conn->prepare("SELECT * FROM `post` WHERE unique_id = ? ORDER BY `post_date` DESC");
        $stmt->bind_param("i", $user_id);
        if ($stmt->execute()) {
            $stmt->bind_result($id,$post_desc, $post_image, $post_last_updated, $post_date,$unique_id);
         
            while ($stmt->fetch()) { 
                $feed = array();
                $feed["id"] = $id;
                $feed["post_desc"] = $post_desc;
                $feed["post_image"] = $post_image;
                $feed["post_last_updated"] = $post_last_updated;
                $feed["post_date"] = $post_date;
                $feed["unique_id"] = $unique_id;
                array_push($data, $feed);
            } 

            $stmt->close();
         
        } else {
            return NULL;
        }
        foreach($data as $d){
                $feed = array();
                $feed["id"]=    $d["id"] ;
                $feed["post_desc"]=   $d["post_desc"];
                $feed["post_image"]  =    $d["post_image"];
                $feed["post_last_updated"] =   $d["post_last_updated"]; 
                $feed["post_date"] =   $d["post_date"]; 
                $feed["unique_id"] =   $d["unique_id"]; 
                $user_profile = $this -> getUserImageNameFromID($d["unique_id"]);
                $feed["profile_image"] =  $user_profile["profile_pic"];
                $feed["full_name"] = $user_profile["full_name"];
                $feed["unique_id"] = $user_profile["unique_id"];
                $feed["isLiked"] = $this -> isLiked($d["id"],$user_id);
                $feed["likeCount"] = $this -> likeCount($d["id"]);
                array_push($data_full, $feed);
        }
        
        return $data_full;

    }



    public function isLiked($post_id, $unique_id) {
        // insert query
        $stmt = $this->conn->prepare("SELECT like_id FROM likes where post_id=? AND unique_id=?");
        $stmt->bind_param("is", $post_id, $unique_id);
        if ($stmt->execute()) {
            $stmt->bind_result($id);
            $stmt->fetch();
            $stmt->close();
            if($id == null)
            return false;
            else
            return true;
        } 
    }
    


    public function likeCount($post_id) {
        // insert query
        $stmt = $this->conn->prepare("SELECT * FROM likes where post_id=?");
        $stmt->bind_param("i", $post_id);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows;
    }




    public function followCount($unique_id) {
        $user = array();
        
        $stmt2 = $this->conn->prepare("SELECT follow_id FROM followTable where following_id=?");
        $stmt2->bind_param("s", $unique_id);
        $stmt2->execute();
        $stmt2->store_result();
        $user['followers'] = $stmt2->num_rows;
        $stmt2->close();
        
        
        // insert query
        $stmt = $this->conn->prepare("SELECT follow_id FROM followTable where user_id=?");
        $stmt->bind_param("s", $unique_id);
        $stmt->execute();
        $stmt->store_result();
        $user['following'] = $stmt->num_rows;
        $stmt->close();
        
        
        
        return $user;
        
    }

    public function isFollowing($unique_id, $following_id) {
        
        $stmt = $this->conn->prepare("SELECT follow_id FROM followTable WHERE user_id = ? and following_id = ?");
        $stmt->bind_param("ss", $unique_id, $following_id);
        if ($stmt->execute()) {
            $stmt->bind_result($id);
            $stmt->fetch();
            $stmt->close();
            if($id == null)
                return false;
            else
                return true;
        } 
    }

    public function followUser($user_id , $following_id){
         // insert query
        
         if(!$this-> isFollowing($user_id , $following_id)){
            $stmt = $this->conn->prepare("INSERT INTO `followTable` ( `user_id`, `following_id`) VALUES (?, ?)");
            $stmt->bind_param("ss",$user_id , $following_id); 
            $result = $stmt->execute();
        
            $stmt->close();
            // Check for successful insertion
            if ($result) {
                // User successfully inserted
                return USER_CREATED_SUCCESSFULLY;
            } else {
                // Failed to create user
                return $this->conn->error();
            }
        
        
         }
         else{
            return 9;
         }
  
    }

    public function unFollowUser($user_id , $following_id){
        // insert query

        if($this-> isFollowing($user_id , $following_id)){

           $stmt = $this->conn->prepare("DELETE FROM `followTable` WHERE  `user_id` = ? AND  `following_id` = ?");
           $stmt->bind_param("ss",$user_id , $following_id); 
           $result = $stmt->execute();
       
           $stmt->close();
           // Check for successful insertion
           if ($result) {
               // User successfully inserted
               return USER_CREATED_SUCCESSFULLY;
           } else {
               // Failed to create user
               return $this->conn->error();
           }
       

        }
        else{
           return 9;
        }

    }
    
    
    public function editStaffUser($unique_id, $full_name, $password, $subject1, $subject2, $subejct3, $fileSize, $fileTmpName, $fileType, $fileExtension , $filename ,$finalImageLink, $has_file){
        if($has_file){
        $currentDir = getcwd();
        $errors = [];
        $uploadDirectory ="/". $this->getDirectory();
        $uploadPath = $currentDir . $uploadDirectory . basename($filename);
        $fileExtensions = ['jpeg', 'jpg', 'png', 'JPG', 'PNG', 'JPEG'];
    
        if (!in_array($fileExtension, $fileExtensions)) {
            return 2;
        } elseif ($fileSize > 14256000) {
            return 3;
        } else {
    
            if (file_exists($uploadPath)) {
    
                unlink($uploadPath);
    
    
            }
    
            $didUpload = move_uploaded_file($fileTmpName, $uploadPath);
            if ($didUpload) {
                $success=$this->updateStaffInfo($unique_id, $full_name, $password, $subject1, $subject2, $subejct3, $finalImageLink);
                if($success){
                    return 1;
                    
                }else{
                    return 2;
                    
                }
            } else {
                return 4;
            }
    
    
        }
        
        }
        else{
            $success=$this->updateStaffInfo($unique_id, $full_name, $password, $subject1, $subject2, $subejct3, $finalImageLink);
            if($success){
                return 1;
                    
            }else{
                return 2;
                    
            }
        }
        
    }
    
    public function updateStaffInfo($unique_id, $full_name, $password, $subject1, $subject2, $subejct3, $imageLink){
        require_once 'PassHash.php';
        $finalPassword=null;
        if(empty($password)){
            $stmt = $this->conn->prepare("SELECT password FROM staff_user WHERE unique_id = ?");

            $stmt->bind_param("s", $unique_id);

            $stmt->execute();

            $stmt->bind_result($password_hash);

            $stmt->store_result();
            $stmt->fetch();

            $stmt->close();
            
            $finalPassword=$password_hash;

        }else{
            $finalPassword = PassHash::hash($password);
        }
        
        $stmt = $this->conn->prepare( "UPDATE staff_user set full_name=?,  password=?, subject1=?, subject2=?, subject3=?, profile_pic=? where unique_id=?");
        $stmt->bind_param("sssssss", $full_name, $finalPassword, $subject1, $subject2, $subejct3, $imageLink, $unique_id);
        $result = $stmt->execute();
        $stmt->close();      
    
        if ($result) {
                return TRUE;
            } else {
                return FALSE;
            }
        
    }
    
    
    
    
    public function editStudentUser($unique_id, $full_name, $password, $subject, $year, $section, $fileSize, $fileTmpName, $fileType, $fileExtension , $filename ,$finalImageLink, $has_file){
        if($has_file){
        $currentDir = getcwd();
        $errors = [];
        $uploadDirectory ="/". $this->getDirectory();
        $uploadPath = $currentDir . $uploadDirectory . basename($filename);
        $fileExtensions = ['jpeg', 'jpg', 'png', 'JPG', 'PNG', 'JPEG'];
    
        if (!in_array($fileExtension, $fileExtensions)) {
            return 2;
        } elseif ($fileSize > 14256000) {
            return 3;
        } else {
    
            if (file_exists($uploadPath)) {
    
                unlink($uploadPath);
    
    
            }
    
            $didUpload = move_uploaded_file($fileTmpName, $uploadPath);
            if ($didUpload) {
                $success=$this->updateStudentInfo($unique_id, $full_name, $password, $subject, $year, $section, $finalImageLink);
                if($success){
                    return 1;
                    
                }else{
                    return 2;
                    
                }
            } else {
                return 4;
            }
    
    
        }
        
        }
        else{
            $success=$this->updateStudentInfo($unique_id, $full_name, $password, $subject, $year, $section, $finalImageLink);
            if($success){
                return 1;
                    
            }else{
                return 2;
                    
            }
        }
        
    }
    
    public function updateStudentInfo($unique_id, $full_name, $password, $subject, $year, $section, $finalImageLink){
        
        require_once 'PassHash.php';
        $finalPassword=null;
        if(empty($password)){
            $stmt = $this->conn->prepare("SELECT password FROM student_user WHERE unique_id = ?");

            $stmt->bind_param("s", $unique_id);

            $stmt->execute();

            $stmt->bind_result($password_hash);

            $stmt->store_result();
            $stmt->fetch();

            $stmt->close();
            
            $finalPassword=$password_hash;

        }else{
            $finalPassword = PassHash::hash($password);
        }
        
        $stmt = $this->conn->prepare( "UPDATE student_user set full_name=?,  password=?, subject=?, year=?, section=?, profile_pic=? where unique_id=?");
        $stmt->bind_param("sssssss", $full_name, $finalPassword, $subject, $year, $section, $finalImageLink, $unique_id);
        $result = $stmt->execute();
        $stmt->close();      
    
        if ($result) {
                return TRUE;
            } else {
                return FALSE;
            }
        
    }
    
    
    
    
    

    public function getUserImageNameFromID($unique_id){
        if ($this->checkUnique($unique_id)){
            $stmt = $this->conn->prepare("SELECT full_name, unique_id, profile_pic FROM student_user WHERE unique_id = ?");
            $stmt->bind_param("s", $unique_id);
            if ($stmt->execute()) {
                // $user = $stmt->get_result()->fetch_assoc();
                $stmt->bind_result($full_name, $unique_id, $profile_pic);
                $stmt->fetch();
                $user = array();
                $user["full_name"] = $full_name;
                $user["unique_id"] = $unique_id;
                $user["profile_pic"] = $profile_pic;
                $stmt->close();
                return $user;
            } else {
                return NULL;
            }
        }else{
            $stmt = $this->conn->prepare("SELECT full_name, unique_id, profile_pic FROM staff_user WHERE unique_id = ?");
            $stmt->bind_param("s", $unique_id);
            if ($stmt->execute()) {
                // $user = $stmt->get_result()->fetch_assoc();
                $stmt->bind_result($full_name, $unique_id, $profile_pic);
                $stmt->fetch();
                $user = array();
                $user["full_name"] = $full_name;
                $user["unique_id"] = $unique_id;
                $user["profile_pic"] = $profile_pic;
                $stmt->close();
                return $user;
            } else {
                return NULL;
            }
        } 

    }
    
    
    
    
    
    public function likePost($post_id, $unique_id) {
        if(!$this->isLiked($post_id, $unique_id)){
            // insert query
            $stmt = $this->conn->prepare("INSERT INTO likes(post_id, unique_id) values(?, ?)");
            $stmt->bind_param("is", $post_id, $unique_id);
        
            $result = $stmt->execute();
        
            $stmt->close();
        
            // Check for successful insertion
            if ($result) {
                // User successfully inserted
                return 1;
            } else {
                // Failed to create user
                return 0;
            }
        }else{
            return 9;
        }
    }
       
    
    
    
    public function dislikePost($post_id, $unique_id) {
        if($this->isLiked($post_id, $unique_id)){
            // insert query
            $stmt = $this->conn->prepare("DELETE FROM likes where post_id=? AND unique_id=?");
            $stmt->bind_param("is", $post_id, $unique_id);
        
            $result = $stmt->execute();
        
            $stmt->close();
        
            // Check for successful insertion
            if ($result) {
                // User successfully inserted
                return 1;
            } else {
                // Failed to create user
                return 0;
            }
        }
    }
    
    

    /**
     * Checking for duplicate user by email address
     * @param String $email email to check in db
     * @return boolean
     */
     
     
    private function checkUnique($unique_id) {
        $stmt = $this->conn->prepare("SELECT unique_id from student_user WHERE unique_id = ?");
        $stmt->bind_param("s", $unique_id);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }
    
    
    private function isUserExists($email) {
        $stmt = $this->conn->prepare("SELECT student_id from student_user WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }

    private function staffExists($email) {
        $stmt = $this->conn->prepare("SELECT staff_id from staff_user WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }

    /**
     * Fetching user by email
     * @param String $email User email id
     */
    public function getUserByEmail($email) {
        if ($this->isUserExists($email)){
            $stmt = $this->conn->prepare("SELECT full_name, email, api_key, created_at, subject, year, section, unique_id, is_staff, profile_pic FROM student_user WHERE email = ?");
            $stmt->bind_param("s", $email);
            if ($stmt->execute()) {
                // $user = $stmt->get_result()->fetch_assoc();
                $stmt->bind_result($full_name, $email, $api_key, $created_at, $subject, $year, $section, $unique_id, $is_staff, $profile_pic);
                $stmt->fetch();
                $user = array();
                $user["full_name"] = $full_name;
                $user["email"] = $email;
                $user["api_key"] = $api_key;
                $user["created_at"] = $created_at;
                $user["subject"] = $subject;
                $user["year"] = $year;
                $user["section"] = $section;
                $user["unique_id"] = $unique_id;
                $user["is_staff"] = $is_staff;
                $user["profile_pic"] = $profile_pic;
                $stmt->close();
                return $user;
            } else {
                return NULL;
            }
        }else{
            $stmt = $this->conn->prepare("SELECT full_name, email, api_key, created_at, unique_id, is_staff, profile_pic, subject1, subject2, subject3 FROM staff_user WHERE email = ?");
            $stmt->bind_param("s", $email);
            if ($stmt->execute()) {
                // $user = $stmt->get_result()->fetch_assoc();
                $stmt->bind_result($full_name, $email, $api_key, $created_at, $unique_id, $is_staff, $profile_pic,  $subject1, $subject2, $subject3);
                $stmt->fetch();
                $user = array();
                $user["full_name"] = $full_name;
                $user["email"] = $email;
                $user["api_key"] = $api_key;
                $user["created_at"] = $created_at;
                $user["unique_id"] = $unique_id;
                $user["is_staff"] = $is_staff;
                $user["profile_pic"] = $profile_pic;
                $user["subject1"] = $subject1;
                $user["subject2"] = $subject2;
                $user["subject3"] = $subject3;
                $stmt->close();
                return $user;
            } else {
                return NULL;
            }
        }    
    }








    public function donate($unique_id, $donation_amount, $remarks, $payment_method){
        
            $stmt = $this->conn->prepare("INSERT INTO donation (unique_id, donation_amount, remarks, payment_method) values(?,?,?,?)");
            $stmt->bind_param("sdss", $unique_id, $donation_amount, $remarks, $payment_method);
            $result = $stmt->execute();
            $stmt->close();
            if($result){
                return 1;
            }else{
                return 10;
            }
          
    }
    
    
    
    
      /**
     * Fetching user by unique_id
     * @param String $unique_id User unique_id
     */
    public function getStaffById($unique_id) {
         $stmt = $this->conn->prepare("SELECT full_name, email, is_staff, profile_pic, subject1, subject2, subject3 FROM staff_user WHERE unique_id = ?");
            $stmt->bind_param("s", $unique_id);
            if ($stmt->execute()) {
                // $user = $stmt->get_result()->fetch_assoc();
                $stmt->bind_result($full_name, $email, $is_staff, $profile_pic,  $subject1, $subject2, $subject3);
                $stmt->fetch();
                $user = array();
                $user["full_name"] = $full_name;
                $user["email"] = $email;
                $user["is_staff"] = $is_staff;
                $user["profile_pic"] = $profile_pic;
                $user["subject1"] = $subject1;
                $user["subject2"] = $subject2;
                $user["subject3"] = $subject3;
                $stmt->close();
                return $user;
            } else {
                return NULL;
            }
        
    }
    
    
    
    
      /**
     * Fetching user by unique_id
     * @param String $unique_id User unique_id
     */
    public function getStudentById($unique_id) {
         $stmt = $this->conn->prepare("SELECT full_name, email, is_staff, profile_pic, subject, year, section FROM student_user WHERE unique_id = ?");
            $stmt->bind_param("s", $unique_id);
            if ($stmt->execute()) {
                // $user = $stmt->get_result()->fetch_assoc();
                $stmt->bind_result($full_name, $email, $is_staff, $profile_pic,  $subject, $year, $section);
                $stmt->fetch();
                $user = array();
                $user["full_name"] = $full_name;
                $user["email"] = $email;
                $user["is_staff"] = $is_staff;
                $user["profile_pic"] = $profile_pic;
                $user["subject"] = $subject;
                $user["year"] = $year;
                $user["section"] = $section;
                $stmt->close();
                return $user;
            } else {
                return NULL;
            }
        
    }
    
    
    
    

    /**
     * Fetching user api key
     * @param String $user_id user id primary key in user table
     */
    public function getApiKeyById($student_id) {
        $stmt = $this->conn->prepare("SELECT api_key FROM student_user WHERE student_id = ?");
        $stmt->bind_param("i", $student_id);
        if ($stmt->execute()) {
            // $api_key = $stmt->get_result()->fetch_assoc();
            // TODO
            $stmt->bind_result($api_key);
            $stmt->close();
            return $api_key;
        } else {
            return NULL;
        }
    }



    /**
     * Fetching isStaff  by using user id
     * @param String $user_id user id primary key in user table
     */
    public function getUserIsStaffById($student_id) {
        $stmt = $this->conn->prepare("SELECT is_staff FROM student_user WHERE student_id = ?");
        $stmt->bind_param("i", $student_id);
        if ($stmt->execute()) {
            $stmt->bind_result($is_staff);
            $stmt->fetch();
            // TODO
            // $user_id = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            return $is_staff;
        } else {
            return NULL;
        }
    }


    /**
     * Fetching user id by api key
     * @param String $api_key user api key
     */
    public function getUserId($api_key) {
        $stmt = $this->conn->prepare("SELECT unique_id FROM student_user WHERE api_key = ?");
        $stmt->bind_param("s", $api_key);
        if ($stmt->execute()) {
            $stmt->bind_result($student_id);
            $stmt->fetch();
            // TODO
            // $user_id = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            return $student_id;
        } else {
            return NULL;
        }
    }


    /**
     * Fetching user id by api key
     * @param String $api_key user api key
     */
    public function getStaffId($api_key) {
        $stmt = $this->conn->prepare("SELECT unique_id FROM staff_user WHERE api_key = ?");
        $stmt->bind_param("s", $api_key);
        if ($stmt->execute()) {
            $stmt->bind_result($staff_id);
            $stmt->fetch();
            // TODO
            // $user_id = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            return $staff_id;
        } else {
            return NULL;
        }
    }

    /**
     * Validating user api key
     * If the api key is there in db, it is a valid key
     * @param String $api_key user api key
     * @return boolean
     */
    public function isValidApiKey($api_key) {
        $stmt = $this->conn->prepare("SELECT student_id from student_user WHERE api_key = ?");
        $stmt->bind_param("s", $api_key);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }

    public function isValidApiKeyStaff($api_key) {
        $stmt = $this->conn->prepare("SELECT staff_id from staff_user WHERE api_key = ?");
        $stmt->bind_param("s", $api_key);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }
    /**
     * Generating random Unique MD5 String for user Api key
     */
    private function generateApiKey() {
        return md5(uniqid(rand(), true));
    }


    private function generateUniqueKey() {
        return md5(uniqid(rand(), true));
    }
    

}

?>
