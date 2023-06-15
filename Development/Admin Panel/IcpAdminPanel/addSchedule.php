<?php
    $conn = mysqli_connect("localhost", "pokharab_manish", "iamkingmg007","pokharab_connectICP");
    if($conn-> connect_error){
        die("Connection failed:".$conn-> connection_error);
    }
	
    $id = $_POST['id'];
    $subject = $_POST['subject'];
    $day = $_POST['day'];
    $time = $_POST['time'];
    $class_type = $_POST['class_type'];
    $module_code = $_POST['module_code'];
    $module_title = $_POST['module_title'];
    $lecturer = $_POST['lecturer'];
    $year = $_POST['year'];
    $section = $_POST['section'];

    $insert =mysqli_query($conn, "INSERT INTO schedule(id,subject,day,time,class_type,module_code,module_title,lecturer,year, section) VALUES 
            ('$id', '$subject', '$day', '$time', '$class_type', '$module_code', '$module_title', '$lecturer', '$year', '$section')") ;

    if($insert)
    {
        echo"Schedule added successfully";
    }
    else
    {
        echo"Not able to add Schedule";
    }
?>



