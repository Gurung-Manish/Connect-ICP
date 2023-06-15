    <?php

    require_once '../include/DbHandler.php';
    require_once '../include/PassHash.php';
    require '.././libs/Slim/Slim.php';

    \Slim\Slim::registerAutoloader();

    $app = new \Slim\Slim();

    // User id from db - Global Variable
    $unique_id = NULL;

    /**
     * Adding Middle Layer to authenticate every request
     * Checking if the request has valid api key in the 'Authorization' header
     */
    function authenticate(\Slim\Route $route) {
        // Getting request headers
        $headers = apache_request_headers();
        $response = array();
        $app = \Slim\Slim::getInstance();

        // Verifying Authorization Header
        if (isset($headers['Authorization'])) {
            $db = new DbHandler();

            // get the api key
            $api_key = $headers['Authorization'];
            // validating api key
            if (!$db->isValidApiKey($api_key)) {
                if(!$db->isValidApiKeyStaff($api_key)){
                    // api key is not present in users table
                    $response["error"] = true;
                    $response["message"] = "Access Denied. Invalid Api key";
                    echoRespnse(401, $response);
                    $app->stop();
                }
                else{
                    global $unique_id;
                    // get user primary key id
                    $unique_id = $db->getStaffId($api_key);
                }
            } else {
                global $unique_id;
                // get user primary key id
                $unique_id = $db->getUserId($api_key);
            }
        } else {
            // api key is missing in header
            $response["error"] = true;
            $response["message"] = "Api key is misssing";
            echoRespnse(400, $response);
            $app->stop();
        }
    }

    /**
     * ----------- METHODS WITHOUT AUTHENTICATION ---------------------------------
     */
    /**
     * User Registration
     * url - /register_student
     * method - POST
     * params - 'email', 'full_name', 'password','subject','year','section'
     */
    $app->post('/register_student', function() use ($app) {
                // check for required params
                verifyRequiredParams(array('email', 'full_name', 'password','subject','year','section'));

                $response = array();

                // reading post params
                $full_name = $app->request->post('full_name');
                $email = $app->request->post('email');
                $password = $app->request->post('password');

                $subject = $app->request->post('subject');

                $year = $app->request->post('year');
                $section = $app->request->post('section');

                // validating email address
                validateEmail($email);

                $db = new DbHandler();
                $res = $db->createStudentUser($email, $full_name, $password, $subject, $year, $section);

                if ($res == USER_CREATED_SUCCESSFULLY) {
                    $response["error"] = false;
                    $response["message"] = "You are successfully registered";
                } else if ($res == USER_CREATE_FAILED) {
                    $response["error"] = true;
                    $response["message"] = "Oops! An error occurred while registereing";
                } else if ($res == USER_ALREADY_EXISTED) {
                    $response["error"] = true;
                    $response["message"] = "Sorry, this email already existed";
                }
                // echo json response
                echoRespnse(201, $response);
            });


    /**
     * User Registration
     * url - /register_staff
     * method - POST
     * params - name, email, password
     */
    $app->post('/register_staff', function() use ($app) {
                // check for required params
                verifyRequiredParams(array('email', 'full_name', 'password'));

                $response = array();

                // reading post params
                $full_name = $app->request->post('full_name');
                $email = $app->request->post('email');
                $password = $app->request->post('password');
                $subject1 = null;
                if(isset($_POST['subject1'])){
                    $subject1 = $app->request->post('subject1');
                }
                $subject2 = null;
                if(isset($_POST['subject2'])){
                    $subject2 = $app->request->post('subject2');
                }
                $subject3 = null;
                if(isset($_POST['subject3'])){
                    $subject3 = $app->request->post('subject3');
                }

                // validating email address
                validateEmail($email);

                $db = new DbHandler();
                $res = $db->createStaffUser($email, $full_name, $password, $subject1, $subject2, $subject3);

                if ($res == USER_CREATED_SUCCESSFULLY) {
                    $response["error"] = false;
                    $response["message"] = "You are successfully registered";
                } else if ($res == USER_CREATE_FAILED) {
                    $response["error"] = true;
                    $response["message"] = "Oops! An error occurred while registereing";
                } else if ($res == USER_ALREADY_EXISTED) {
                    $response["error"] = true;
                    $response["message"] = "Sorry, this email already existed";
                }
                // echo json response
                echoRespnse(201, $response);
            });



    //-----without authentication-------
    /**
    *make_post
    */

    $app->post('/make_post','authenticate', function() use ($app) {
        global $unique_id;
        // verifyRequiredParams(array('has_file'));
        // reading post params
        $uploadDirectoryLink = 'https://www.gurungmanish.com.np/postPictures/';
        $response=array();
        $post_desc = null;
        $has_file = false;
        
        if(isset($_FILES['file'])){
         $has_file = true;
        }
        
         if($has_file || isset($_POST['post_desc'])){
            
             $fileName ;
             $fileSize =null;
             $fileTmpName = null;
             $fileType = null;
             $fileExtension = null ;
             $filename = null ;
             $imageLink = null;
             
            if($has_file){
            $fileName = $_FILES['file']['name'];
            $fileSize = $_FILES['file']['size'];
            $fileTmpName = $_FILES['file']['tmp_name'];
            $fileType = $_FILES['file']['type'];
        
            $tmpo = explode('.', $fileName);
            $fileExtension = end($tmpo);
            $path_parts = pathinfo($_FILES["file"]["name"]);
            $filename = $path_parts['filename'] . '_' . time() . '_'.$unique_id. '.' . $path_parts['extension']  ;
        
            $year = date("Y");
            $month = date("m");
            $short_dir = $year . "/" . $month;
            $imageLink =$uploadDirectoryLink . $short_dir . "/" . $filename;
        
            $post_image = $imageLink;
                
            }
         
             $post_desc = $app->request->post('post_desc');
             
            
            
             $db = new DbHandler();

            if($db->upload($unique_id,$post_desc,$fileSize, $fileTmpName, $fileType, $fileExtension , $filename ,$imageLink, $has_file))
            {
                $response["error"] = false;
                $response["message"] = "Post successfully created";
                     echoRespnse(201, $response);
              
                
            }else
            {
                $response["error"] = true;
                $response["message"] = "Post creation failed! Try again!";
                     echoRespnse(300, $response);
              
        
            } 
                
         }
         
         else{
             $response["error"] = true;
             $response["message"] = "Please profile image or a post description to post!";
             echoRespnse(400, $response);
             
         }
      
        
        });
        
        
        
        
    
    
    
    $app->post('/edit_profile', 'authenticate', function() use ($app) {
        
        global $unique_id;
        verifyRequiredParams(array('is_staff'));
        $is_staff = $app->request()->post('is_staff');
        
        $uploadDirectoryLink = 'https://www.gurungmanish.com.np/postPictures/';
        $response=array();
        $has_pp = false;
        
        if(isset($_FILES['file'])){
            $has_pp = true;
        }
        
        if($is_staff=='1'){
            if($has_pp || isset($_POST['full_name']) || isset($_POST['password']) || isset($_POST['subject1']) || isset($_POST['subject2']) || isset($_POST['subject3']) || isset($_POST['oldProfileLink'])){
            $fileName ;
            $fileSize =null;
            $fileTmpName = null;
            $fileType = null;
            $fileExtension = null ;
            $filename = null ;
            $imageLink = null;
            
            
             
            if($has_pp){
                $fileName = $_FILES['file']['name'];
                $fileSize = $_FILES['file']['size'];
                $fileTmpName = $_FILES['file']['tmp_name'];
                $fileType = $_FILES['file']['type'];
            
                $tmpo = explode('.', $fileName);
                $fileExtension = end($tmpo);
                $path_parts = pathinfo($_FILES["file"]["name"]);
                $filename = $path_parts['filename'] . '_' . time() . '_'.$unique_id. '.' . $path_parts['extension']  ;
            
                $year = date("Y");
                $month = date("m");
                $short_dir = $year . "/" . $month;
                $imageLink =$uploadDirectoryLink . $short_dir . "/" . $filename;
            
            }
         
            $full_name = $app->request->post('full_name');
            $password = $app->request->post('password');
            $subject1 = $app->request->post('subject1');
            $subject2 = $app->request->post('subject2');
            $subejct3 = $app->request->post('subject3');
            $oldProfileLink = $app->request->post('oldProfileLink');
            
            if(is_null($imageLink)){
                $finalImageLink=$oldProfileLink;
            }else{
                $finalImageLink=$imageLink;
            }

            
            $db = new DbHandler();
            
            if($db->editStaffUser($unique_id, $full_name, $password, $subject1, $subject2, $subejct3, $fileSize, $fileTmpName, $fileType, $fileExtension , $filename ,$finalImageLink, $has_pp))
            {
                
                $user=$db->getStaffById($unique_id);
                if ($user != NULL) {
                    $response["error"] = false;
                    $response['full_name'] = $user['full_name'];
                    $response['email'] = $user['email'];
                    $response['is_staff'] = $user['is_staff'];
                    $response["profile_pic"] = $user['profile_pic'];
                    $response["subject1"] = $user['subject1'];
                    $response["subject2"] = $user['subject2'];
                    $response["subject3"] = $user['subject3'];
                    $response["message"]="Staff info changed successfully";
                    echoRespnse(200, $response);
                }else{
                    $response['error'] = true;
                    $response['message'] = "An error occurred. Please try again";
                    echoRespnse(200, $response);    
                }
              
                
            }else
            {
                $response["error"] = true;
                $response["message"] = "Staff info changed unsuccessfully";
                echoRespnse(300, $response);
              
        
            } 
            
            }
            else{
                $response["message"] = "Nothing to be changed";
                echoRespnse(300, $response);
            }
            
            
            
        }else{
            if($has_pp || isset($_POST['full_name']) || isset($_POST['password']) || isset($_POST['subject']) || isset($_POST['year']) || isset($_POST['section']) || isset($_POST['oldProfileLink'])){
            $fileName ;
            $fileSize =null;
            $fileTmpName = null;
            $fileType = null;
            $fileExtension = null ;
            $filename = null ;
            $imageLink = null;
             
            if($has_pp){
                $fileName = $_FILES['file']['name'];
                $fileSize = $_FILES['file']['size'];
                $fileTmpName = $_FILES['file']['tmp_name'];
                $fileType = $_FILES['file']['type'];
            
                $tmpo = explode('.', $fileName);
                $fileExtension = end($tmpo);
                $path_parts = pathinfo($_FILES["file"]["name"]);
                $filename = $path_parts['filename'] . '_' . time() . '_'.$unique_id. '.' . $path_parts['extension']  ;
            
                $year = date("Y");
                $month = date("m");
                $short_dir = $year . "/" . $month;
                $imageLink =$uploadDirectoryLink . $short_dir . "/" . $filename;
            
            }
         
            $full_name = $app->request->post('full_name');
            $password = $app->request->post('password');
            $subject = $app->request->post('subject');
            $year = $app->request->post('year');
            $section = $app->request->post('section');
            $oldProfileLink = $app->request->post('oldProfileLink');
            
            if(is_null($imageLink)){
                $finalImageLink=$oldProfileLink;
            }else{
                $finalImageLink=$imageLink;
            }
            
            $db = new DbHandler();
            
            if($db->editStudentUser($unique_id, $full_name, $password, $subject, $year, $section, $fileSize, $fileTmpName, $fileType, $fileExtension , $filename ,$finalImageLink, $has_pp))
            {
                $user=$db->getStudentById($unique_id);
                if ($user != NULL) {
                    $response["error"] = false;
                    $response['full_name'] = $user['full_name'];
                    $response['email'] = $user['email'];
                    $response['is_staff'] = $user['is_staff'];
                    $response["profile_pic"] = $user['profile_pic'];
                    $response["subject"] = $user['subject'];
                    $response["year"] = $user['year'];
                    $response["section"] = $user['section'];
                    $response["message"]="Student info changed successfully";
                    echoRespnse(200, $response);
                }else{
                    $response['error'] = true;
                    $response['message'] = "An error occurred. Please try again";
                    echoRespnse(200, $response);    
                }
              
                
            }else
            {
                $response["error"] = true;
                $response["message"] = "Student info changed unsuccessfully";
                echoRespnse(300, $response);
              
        
            } 
            
            }
            else{
                $response["message"] = "Nothing to be changed";
                echoRespnse(300, $response);
            }
        }
        
    });

    /**
     * User Login
     * url - /login
     * method - POST
     * params - email, password
     */
    $app->post('/login', function() use ($app) {
                // check for required params
                verifyRequiredParams(array('email', 'password'));
                
                // reading post params
                $email = $app->request()->post('email');
                $password = $app->request()->post('password');
                $response = array();

                $db = new DbHandler();
                // check for correct email and password
                if ($db->checkLogin($email, $password)) {
                    // get the user by email
                    $user = $db->getUserByEmail($email);

                    if ($user != NULL) {
                        if($user['is_staff']=='1'){
                            $response["error"] = false;
                            $response['full_name'] = $user['full_name'];
                            $response['email'] = $user['email'];
                            $response['apiKey'] = $user['api_key'];
                            $response['createdAt'] = $user['created_at'];
                            $response['is_staff'] = $user['is_staff'];
                            $response['unique_id'] = $user['unique_id'];
                            $response["profile_pic"] = $user['profile_pic'];
                            $response["subject1"] = $user['subject1'];
                            $response["subject2"] = $user['subject2'];
                            $response["subject3"] = $user['subject3'];
                        }
                        else{
                            $response["error"] = false;
                            $response['full_name'] = $user['full_name'];
                            $response['email'] = $user['email'];
                            $response['apiKey'] = $user['api_key'];
                            $response['createdAt'] = $user['created_at'];
                            $response['subject'] = $user['subject'];
                            $response['year'] = $user['year'];
                            $response['section'] = $user['section'];
                            $response['unique_id'] = $user['unique_id'];
                            $response['is_staff'] = $user['is_staff'];
                            $response["profile_pic"] = $user['profile_pic'];
                        }
                    } else {
                        // unknown error occurred
                        $response['error'] = true;
                        $response['message'] = "An error occurred. Please try again";
                    }
                } else {
                    // user credentials are wrong
                    $response['error'] = true;
                    $response['message'] = 'Login failed. Incorrect credentials';
                }

                echoRespnse(200, $response);
            });


    /**
     * Check Routine
     * url - /check_routine
     * method - POST
     * params - 'subject','year','section'
     */
    $app->post('/check_routine','authenticate', function() use ($app) {
        // check for required params
        verifyRequiredParams(array('subject','year','section'));
        global $unique_id;

        $response = array();

        // reading post params
        $subject = $app->request->post('subject');
        $year = $app->request->post('year');
        $section = $app->request->post('section');

        $db = new DbHandler();
        $res = $db->checkRoutine($subject, $year, $section);
        if ($res != NULL) {
            $response["error"] = false;
            $response['data'] = $res;
             $response['message'] ="successfully done";
        }
        else if($res == 0){
            // unknown error occurred
            $response['error'] = false;
            $response['message'] = "Your classes has not been started yet.";
            $response['data'] = NULL; 
        }
        else {
            // unknown error occurred
            $response['error'] = true;
            $response['message'] = "There is some error selecting class.";
            $response['data'] = NULL; 
        }
        echoRespnse(200, $response);
        });
        
        
        
    /**
     * Get all feed
     * url - /get_all_feed
     * method - POST
     * params - 'subject','year','section'
     */

    $app -> post('/get_all_feed', 'authenticate', function () use ($app){
    global $unique_id;
    $response = array();

    $db = new DbHandler();
    $res= $db->getAllPost($unique_id);
    if($res != NULL){
        $response["post"] = $res;
        $response["error"] = false;
        $response["message"] = "Success";
        echoRespnse(200, $response);
        
    }else {
        $response['error'] = true;
        $response['message'] = 'Failed';
    }

    });
    
    
    
    
    
    $app -> post('/get_my_feed', 'authenticate', function () use ($app){
    global $unique_id;
    $response = array();

    $db = new DbHandler();
    $response["post"] = $db->getMyPost($unique_id);
    $response["error"] = false;
    $response["message"] = "SuccessFull";
    echoRespnse(200, $response);

    });



    /**
     * Check Routine
     * url - /check_routine
     * method - POST
     * params - 'subject','year','section'
     */
    $app->post('/display_staff','authenticate', function() use ($app) {
        global $unique_id;

        $response = array();

        $db = new DbHandler();
        $res = $db->showStaff();
        if ($res != NULL) {
            $response["error"] = false;
            $response['data'] = $res;
            $response['message'] ="successfully done";
        }
        else if($res == 0){
            // unknown error occurred
            $response['error'] = false;
            $response['message'] = "There are no staff registered yet.";
            $response['data'] = NULL; 
        }
        else {
            // unknown error occurred
            $response['error'] = true;
            $response['message'] = "Some error viewing from table";
            $response['data'] = NULL; 
        }
        echoRespnse(200, $response);
        });


    
    
    
    
    /**
    *like_post
    */

    $app->post('/like_post','authenticate', function() use ($app) {
        global $unique_id;
        verifyRequiredParams(array('post_id'));

        $response = array();

        // reading post params
        $post_id = $app->request->post('post_id');


        $db = new DbHandler();
        $res = $db->likePost($post_id, $unique_id);

        if ($res) {
            $response["error"] = false;
        } else{
            $response["error"] = true;
        } 
        // echo json response
        echoRespnse(201, $response);
        
    });
    
    
    
    
    
    /**
    *like_post
    */

    $app->post('/dislike_post','authenticate', function() use ($app) {
        global $unique_id;
        verifyRequiredParams(array('post_id'));

        $response = array();

        // reading post params
        $post_id = $app->request->post('post_id');

        $db = new DbHandler();
        $res = $db->dislikePost($post_id, $unique_id);

        if ($res) {
            $response["error"] = false;
        } else{
            $response["error"] = true;
        } 
        // echo json response
        echoRespnse(201, $response);
        
    });
    
    
  
  
  
    /**
     * Following and unfollowing users
     */
     
    
    $app -> post('/follow_count', 'authenticate', function () use ($app){
        global $unique_id;
        $response = array();
        $db = new DbHandler();
        $result=$db->followCount($unique_id);
        $response['followers']=$result['followers'];
        $response['following']=$result['following'];
        echoRespnse(201, $response);
    
    });
    

    $app -> post('/follow', 'authenticate', function () use ($app){
        global $unique_id;
        $response = array();
        verifyRequiredParams(array('following_id'));
    
        $following_id = $app->request->post('following_id');
        $db = new DbHandler();
         $res =   $db->followUser($unique_id, $following_id);
         if($res == USER_CREATED_SUCCESSFULLY){
            $response["error"] = false;
            $response["message"] = "Followed successfully";
            echoRespnse(201, $response);
         }
         else if($res == 9){
            $response["error"] = true;
            $response["message"] = "Already following";
            echoRespnse(400, $response);
         }
    
    });
    
    $app -> post('/unfollow', 'authenticate', function () use ($app){
        global $unique_id;
        $response = array();
        verifyRequiredParams(array('following_id'));
    
        $following_id = $app->request->post('following_id');
        $db = new DbHandler();
         $res =   $db->unFollowUser($unique_id, $following_id);
         if($res == USER_CREATED_SUCCESSFULLY){
            $response["error"] = false;
            $response["message"] = "Unfollow successfully";
            echoRespnse(201, $response);
         }
         else if($res == 9){
            $response["error"] = true;
            $response["message"] = "Not following following";
            echoRespnse(400, $response);
         }
        
    });



    $app->post('/donate','authenticate', function() use ($app) {
        
    global $unique_id;
          verifyRequiredParams(array('donation_amount','remarks','payment_method'));
         $response = array();
         $donation_amount= $app->request->post('donation_amount');
         $remarks= $app->request->post('remarks');
         $payment_method= $app->request->post('payment_method');
         $db = new DbHandler();
         $res = $db->donate($unique_id, $donation_amount, $remarks, $payment_method);
         if ($res ==1) {
            $response["error"] = false;
            $response["message"] = "donation success";
        }
        else  {
            $response["error"] = true;
            $response["message"] = "Donation unsuccessful";
        } 
        
        
        echoRespnse(200, $response);

    });





    
    /**
     * Verifying required params posted or not
     */
    function verifyRequiredParams($required_fields) {
        $error = false;
        $error_fields = "";
        $request_params = array();
        $request_params = $_REQUEST;
        // Handling PUT request params
        if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
            $app = \Slim\Slim::getInstance();
            parse_str($app->request()->getBody(), $request_params);
        }
        foreach ($required_fields as $field) {
            if (!isset($request_params[$field]) || strlen(trim($request_params[$field])) <= 0) {
                $error = true;
                $error_fields .= $field . ', ';
            }
        }

        if ($error) {
            // Required field(s) are missing or empty
            // echo error json and stop the app
            $response = array();
            $app = \Slim\Slim::getInstance();
            $response["error"] = true;
            $response["message"] = 'Required field(s) ' . substr($error_fields, 0, -2) . ' is missing or empty';
            echoRespnse(400, $response);
            $app->stop();
        }
    }


    /**
     * Validating email address
     */
    function validateEmail($email) {
        $app = \Slim\Slim::getInstance();
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $response["error"] = true;
            $response["message"] = 'Email address is not valid';
            echoRespnse(400, $response);
            $app->stop();
        }
    }

    /**
     * Echoing json response to client
     * @param String $status_code Http response code
     * @param Int $response Json response
     */
    function echoRespnse($status_code, $response) {
        $app = \Slim\Slim::getInstance();
        // Http response code
        $app->status($status_code);

        // setting response content type to json
        $app->contentType('application/json');

        echo json_encode($response);
    }

    $app->run();
    ?>