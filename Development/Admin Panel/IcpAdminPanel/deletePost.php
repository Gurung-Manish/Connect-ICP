<?php

    $conn = mysqli_connect("localhost", "pokharab_manish", "iamkingmg007","pokharab_connectICP");
   if($conn-> connect_error){
        die("Connection failed:".$conn-> connection_error);
    }

    $post_id=$_POST['record'];
    $query="DELETE FROM post where id='$post_id'";

    $data=mysqli_query($conn,$query);

    if($data){
        echo"Post deleted successfully";
    }
    else{
        echo"Not able to delete Post";
    }
    
?>