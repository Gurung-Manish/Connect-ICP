<?php

    $conn = mysqli_connect("localhost", "pokharab_manish", "iamkingmg007","pokharab_connectICP");
   if($conn-> connect_error){
        die("Connection failed:".$conn-> connection_error);
    }

    $staff_id=$_POST['record'];
    $query="DELETE FROM staff_user where staff_id='$staff_id'";

    $data=mysqli_query($conn,$query);

    if($data){
        echo"Staff deleted successfully";
    }
    else{
        echo"Not able to delete Staff";
    }
    
?>