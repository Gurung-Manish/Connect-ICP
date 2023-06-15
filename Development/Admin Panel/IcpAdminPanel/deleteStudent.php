
<?php

    $conn = mysqli_connect("localhost", "pokharab_manish", "iamkingmg007","pokharab_connectICP");
   if($conn-> connect_error){
        die("Connection failed:".$conn-> connection_error);
    }

    $student_id=$_POST['record'];
    $query="DELETE FROM student_user where student_id='$student_id'";

    $data=mysqli_query($conn,$query);

    if($data){
        echo"Student deleted successfully";
    }
    else{
        echo"Not able to delete Student";
    }
    
?>