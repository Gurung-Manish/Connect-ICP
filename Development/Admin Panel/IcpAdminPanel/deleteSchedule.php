


<?php

    $conn = mysqli_connect("localhost", "pokharab_manish", "iamkingmg007","pokharab_connectICP");
   if($conn-> connect_error){
        die("Connection failed:".$conn-> connection_error);
    }

    $id=$_POST['record'];
    $query="DELETE FROM schedule where id='$id'";

    $data=mysqli_query($conn,$query);

    if($data){
        echo"Schedule deleted successfully";
    }
    else{
        echo"Not able to delete Schedule";
    }
    
?>