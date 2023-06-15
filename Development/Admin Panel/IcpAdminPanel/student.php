
<div id="student">
    <h1 style="margin-left:5px;">Student List</h1>
        <div class="table-responsive">
        
            <table class="table">
                <tr>
                    <th>Student Id</th>
                    <th>Email ID</th>
                    <th>Full Name</th>
                    <th>Subject</th>
                    <th>Year</th>
                    <th>Section</th>
                    <th>Action</th>
                </tr>     
                <?php
                    $conn = mysqli_connect("localhost", "pokharab_manish", "iamkingmg007","pokharab_connectICP");
                    if($conn-> connect_error){
                        die("Connection failed:".$conn-> connection_error);
                    }

                    $sql="SELECT student_id, email, full_name, subject, year, section from student_user";
                    $result = $conn-> query($sql);

                    if ($result-> num_rows > 0){
                        while($row = $result-> fetch_assoc()){
                            echo "<tr>
                            <td>".$row["student_id"] ."</td>
                            <td>".$row["email"] ."</td>
                            <td>".$row["full_name"] ."</td>
                            <td>".$row["subject"] ."</td>
                            <td>".$row["year"] ."</td>
                            <td>".$row["section"] ."</td>";
                            ?>
                                <td><button class="w3-button w3-red" onclick="studentDelete('<?=$row['student_id']?>')">Delete</button>
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