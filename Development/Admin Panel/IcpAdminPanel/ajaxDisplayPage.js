function studentBtn(){
    $.ajax({
    	url:"student.php",
    	method:"post",
    	data:{record:1},
    	success:function(data){
    		$('.allContent-section').html(data);
    	}
	});
}

function staffBtn(){
    $.ajax({
        url:"staff.php",
        method:"post",
        data:{record:1},
        success:function(data){
            $('.allContent-section').html(data);
        }
    });
}

function postBtn(){
    $.ajax({
        url:"post.php",
        method:"post",
        data:{record:1},
        success:function(data){
            $('.allContent-section').html(data);
        }
    });
}

function scheduleBtn(){
    $.ajax({
        url:"schedule.php",
        method:"post",
        data:{record:1},
        success:function(data){
            $('.allContent-section').html(data);
        }
    });
}

function postDelete(id){
    $.ajax({
        url:"deletePost.php",
        method:"post",
        data:{record:id},
        success:function(data){
            alert('Post Successfully deleted');
            $('form').trigger('reset');
            postBtn();
        }
    });
}


function staffdelete(id){
    $.ajax({
        url:"deleteStaff.php",
        method:"post",
        data:{record:id},
        success:function(data){
            alert('Staff Successfully deleted');
            $('form').trigger('reset');
            staffBtn();
        }
    });
}

function studentDelete(id){
    $.ajax({
        url:"deleteStudent.php",
        method:"post",
        data:{record:id},
        success:function(data){
            alert('Student Successfully deleted');
            $('form').trigger('reset');
            studentBtn();
        }
    });
}

function scheduleDelete(id){
    $.ajax({
        url:"deleteSchedule.php",
        method:"post",
        data:{record:id},
        success:function(data){
            alert('Schedule Successfully deleted');
            $('form').trigger('reset');
            scheduleBtn();
        }
    });
}

// function scheduleAdd(id){
//     $.ajax({
//         url:"addSchedule.php",
//         method:"post",
//         //data:{record:id},
//         success:function(data){
//             $('.schedule-form').html(data);
//             alert('Schedule Successfully added');
//             $('form').trigger('reset');
//             scheduleBtn();
//         }
//     });
// }



function scheduleAdd(){
    var id=$('#id').val();
    var subject=$('#subject').val();
    var day=$('#day').val();
    var time=$('#time').val();
    var class_type=$('#class_type').val();
    var module_code=$('#module_code').val();
    var module_title=$('#module_title').val();
    var lecturer=$('#lecturer').val();
    var year=$('#year').val();
    var section=$('#section').val();
    var fd = new FormData();
    fd.append('id', id);
    fd.append('subject', subject);
    fd.append('day', day);
    fd.append('time', time);
    fd.append('class_type', class_type);
    fd.append('module_code', module_code);
    fd.append('module_title', module_title);
    fd.append('lecturer', lecturer);
    fd.append('year', year);
    fd.append('section', section);
    $.ajax({
      url:'addSchedule.php',
      method:'post',
      data:fd,
      processData: false,
      contentType: false,
      success: function(data){
        alert('Schedule added Successfully.');
        $('schedule-form').trigger('reset');
        scheduleBtn();
      }
    });
}



function editSchedle(id){
    $.ajax({
        url:"editScheduleForm.php",
        method:"post",
        data:{record:id},
        success:function(data){
            $('.allContent-section').html(data);
        }
    });
}


function updateSchedule(){
    var id=$('#id').val();
    var subject=$('#subject').val();
    var day=$('#day').val();
    var time=$('#time').val();
    var class_type=$('#class_type').val();
    var module_code=$('#module_code').val();
    var module_title=$('#module_title').val();
    var lecturer=$('#lecturer').val();
    var year=$('#year').val();
    var section=$('#section').val();
    var fd = new FormData();
    fd.append('id', id);
    fd.append('subject', subject);
    fd.append('day', day);
    fd.append('time', time);
    fd.append('class_type', class_type);
    fd.append('module_code', module_code);
    fd.append('module_title', module_title);
    fd.append('lecturer', lecturer);
    fd.append('year', year);
    fd.append('section', section);
    $.ajax({
      url:'updateSchedule.php',
      method:'post',
      data:fd,
      processData: false,
      contentType: false,
      success: function(data){
        alert('Schedule updated Successfully.');
        $('form').trigger('reset');
        scheduleBtn();
      }
    });
}

