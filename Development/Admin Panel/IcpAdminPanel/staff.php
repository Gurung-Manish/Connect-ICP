
<div id="student">
    <h1 style="margin-left:5px;">Staff List</h1>
        <div class="table-responsive">
        
            <table class="table">
                <tr>
                    <th>Staff Id</th>
                    <th>Email ID</th>
                    <th>Full Name</th>
                    <th>Subject 1</th>
                    <th>Subjec 2</th>
                    <th>Subject 3</th>
                    <th>Action</th>
                </tr>     
                <?php
                    $conn = mysqli_connect("localhost", "pokharab_manish", "iamkingmg007","pokharab_connectICP");
                    if($conn-> connect_error){
                        die("Connection failed:".$conn-> connection_error);
                    }

                    $sql="SELECT staff_id, email, full_name, subject1, subject2, subject3 from staff_user";
                    $result = $conn-> query($sql);

                    if ($result-> num_rows > 0){
                        while($row = $result-> fetch_assoc()){
                            echo "<tr>
                            <td>".$row["staff_id"] ."</td>
                            <td>".$row["email"] ."</td>
                            <td>".$row["full_name"] ."</td>
                            <td>".$row["subject1"] ."</td>
                            <td>".$row["subject2"] ."</td>
                            <td>".$row["subject3"] ."</td>";
                            ?>
                                <td><button class="w3-button w3-red" onclick="staffdelete('<?=$row['staff_id']?>')">Delete</button>
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