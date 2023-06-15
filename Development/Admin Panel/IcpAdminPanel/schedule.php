<div id="schedule">
    <h1 style="margin-left:5px;">Schedule</h1>

   <a class='w3-button w3-red openPopup' data-href='./ScheduleForm.php' href='javascript:void(0);'>Add Schedule</a>

        <br></br>


        <div class="modal fade" id="viewModal" role="dialog">
            <div class="modal-dialog">
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Add Schedule</h4>
                </div>
                <div class="schedule-view-modal modal-body">
                 
                </div>
              </div>
            </div>
      </div>



        <div class="table-responsive">
        
            <table class="table">
                <tr>
                    <th>ID</th>
                    <th>Subject</th>
                    <th>Day</th>
                    <th>Time</th>
                    <th>Class Type</th>
                    <th>Module Code</th>
                    <th>Module Title</th>
                    <th>Lecturer</th>
                    <th>Year</th>
                    <th>Section</th>
                    <th colspan="2">Action</th>
                </tr>     
                <?php
                    $conn = mysqli_connect("localhost", "pokharab_manish", "iamkingmg007","pokharab_connectICP");
                    if($conn-> connect_error){
                        die("Connection failed:".$conn-> connection_error);
                    }

                    $sql="SELECT id, subject, day, time, class_type, module_code, module_title, lecturer, year, section from schedule";
                    $result = $conn-> query($sql);

                    if ($result-> num_rows > 0){
                        while($row = $result-> fetch_assoc()){
                            echo "<tr>
                            <td>".$row["id"] ."</td>
                            <td>".$row["subject"] ."</td>
                            <td>".$row["day"] ."</td>
                            <td>".$row["time"] ."</td>
                            <td>".$row["class_type"] ."</td>
                            <td>".$row["module_code"] ."</td>
                            <td>".$row["module_title"] ."</td>
                            <td>".$row["lecturer"] ."</td>
                            <td>".$row["year"] ."</td>
                            <td>".$row["section"] ."</td>";
                             ?>
                                <td><button class="w3-button w3-red" onclick="scheduleDelete('<?=$row['id']?>')">Delete</button>
                                <td><button class="w3-button w3-red" onclick="editSchedle('<?=$row['id']?>')">Edit</button>
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

<script>
     //for view schedule modal  
    $(document).ready(function(){
      $('.openPopup').on('click',function(){
        var dataURL = $(this).attr('data-href');
    
        $('.schedule-view-modal').load(dataURL,function(){
          $('#viewModal').modal({show:true});
        });
      });
    });
 </script>