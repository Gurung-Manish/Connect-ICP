
<div id="student">
    <h1 style="margin-left:5px;">Post List</h1>
        <div class="table-responsive">
        
            <table class="table">
                <tr>
                    <th>Post Id</th>
                    <th>Unique Id</th>
                    <th>Details</th>
                    <th>Post Image</th>
                    <th>Post Date</th>
                    <th>Last Updated</th>
                    <th>Action</th>
                </tr>     
                <?php
                    $conn = mysqli_connect("localhost", "pokharab_manish", "iamkingmg007","pokharab_connectICP");
                    if($conn-> connect_error){
                        die("Connection failed:".$conn-> connection_error);
                    }

                    $sql="SELECT id, post_description, post_image, post_last_updated, post_date, unique_id from post";
                    $result = $conn-> query($sql);

                    if ($result-> num_rows > 0){
                        while($row = $result-> fetch_assoc()){
                            echo "<tr>
                            <td>".$row["id"] ."</td>
                            <td>".$row["unique_id"] ."</td>
                            <td>".$row["post_description"] ."</td>
                             <td> <img height='50px' width ='50px' src='" .$row["post_image"] ."'></td>
                            <td>".$row["post_date"] ."</td>
                            <td>".$row["post_last_updated"] ."</td>";
                            ?>
                                <td><button class="w3-button w3-red" onclick="postDelete('<?=$row['id']?>')">Delete</button>
                            <?php
                        }
                        echo "</table>";
                    }
                    else{
                        echo"0 results";
                    }
                    $conn-> close();
                ?>
            
            </table>
        </div>
    </div>

</div>


