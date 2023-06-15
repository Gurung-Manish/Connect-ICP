<?php
  $conn = mysqli_connect("localhost", "pokharab_manish", "iamkingmg007","pokharab_connectICP");
  $ID= $_POST['record'];
  $sql=mysqli_query($conn,"SELECT * FROM schedule WHERE id='$ID'");
  $numberOfRow=mysqli_num_rows($sql);
  if($numberOfRow>0){
    while($row=mysqli_fetch_array($sql)){
?>
<form id="update-Schedule" >
 
  <div class="form-group">
     <input type="text" class="form-control" id="id" name="id" value="<?=$row['id']?>">
    <label for="subject">Subject:</label>
    <input type="text" class="form-control" id="subject" name="subject" value="<?=$row['subject']?>">
  </div>

  <div class="form-group">
    <label for="day">Day:</label>
    <input type="text" class="form-control" id="day" name="day" value="<?=$row['day']?>">
  </div>

  <div class="form-group">
    <label for="class_time">Class Time:</label>
    <input type="text" class="form-control" id="time" name="time" value="<?=$row['time']?>">
  </div>

  <div class="form-group">
    <label for="class_type">Class Type:</label>
    <input type="text" class="form-control" id="class_type" name="class_type" value="<?=$row['class_type']?>">
  </div>

  <div class="form-group">
    <label for="module_code">Module Code:</label>
    <input type="text" class="form-control" id="module_code" name="module_code" value="<?=$row['module_code']?>">
  </div>

  <div class="form-group">
    <label for="module_title">Subject:</label>
    <input type="text" class="form-control" id="module_title" name="module_title" value="<?=$row['module_title']?>">
  </div>

  <div class="form-group">
    <label for="lecturer">Lecturer:</label>
    <input type="text" class="form-control" id="lecturer" name="lecturer" value="<?=$row['lecturer']?>">
  </div>

  <div class="form-group">
    <label for="year">Year:</label>
    <input type="text" class="form-control" id="year" name="year" value="<?=$row['year']?>">
  </div>

  <div class="form-group">
    <label for="section">Section:</label>
    <input type="text" class="form-control" id="section" name="section" value="<?=$row['section']?>">
  </div>

    <?php
      }
      }
    ?>
 
  <div class="form-group">
    <button type="submit" name="submit" class="w3-button w3-red" onclick="updateSchedule()">Update</button>
  </div>
</form>