<?php
        $conn = mysqli_connect("localhost", "pokharab_manish", "iamkingmg007","pokharab_connectICP");
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
        $updateSchedule = mysqli_query($conn,"UPDATE schedule SET subject='$subject', day='$day', time='$time', class_type= '$class_type', module_code='$module_code', module_title='$module_title', lecturer='$lecturer',  year='$year', section='$section' WHERE id='$id'");
     if($updateSchedule){
        echo"schedule updated";
    }
    else{
        echo"Not able to update";
    }
    

?>