<?php include("sql/connect.php") ?>
<style>
.middle{
    margin: 0;
  position: relative;
  top: 50%;
  left: 50%;
  -ms-transform: translate(-50%, -50%);
  transform: translate(-50%, -50%);
}
</style>
<?
function timethai($strDate)
	{
		
		$strHour= date("H",strtotime($strDate));
		$strMinute= date("i",strtotime($strDate));
		$strSeconds= date("s",strtotime($strDate));
    return "$strHour:$strMinute:$strSeconds น.";
  }

//rfid (post from ajax)
$txt_rfid = $_POST['txt_rfid'];

//current time
date_default_timezone_set('Asia/Bangkok');
$current_time = date("H:i:s");
$current_date = date("Y-m-d");

//check user
$sql_name = "SELECT * FROM users WHERE rfid = '$txt_rfid'";
$qry_name = mysqli_query($con,$sql_name);
$show_name = mysqli_fetch_array($qry_name);

//employee id
$emp_id = $show_name['id'];

//check status
$sql_status = "SELECT * FROM timesheet WHERE id = '$emp_id' AND stamp_date = '$current_date'";
$qry_status = mysqli_query($con,$sql_status);
$show_status = mysqli_fetch_array($qry_status);

//check current year and semester
$sql_semester = "SELECT * FROM semester ORDER BY id DESC LIMIT 0,1";
$qry_semester = mysqli_query($con,$sql_semester);
$row_semester = mysqli_fetch_array($qry_semester);

$s_year = $row_semester['semester_year'];
$s_part = $row_semester['semester_part'];

//check current default time
$sql_set = "select default_start,default_end from settings"; $qry_set = mysqli_query($con,$sql_set);
$show_set = mysqli_fetch_array($qry_set);

$default_start = $show_set['default_start']; $default_end = $show_set['default_end'];

if ($show_name){
    if ($show_status['id'] == "" && $show_status['chk_status'] == ""){
        
        $sql_stamp = "INSERT INTO timesheet(id,default_start,default_end,stamp_date,time_start,time_end,chk_status,year,part)
        VALUES('$emp_id','$default_start','$default_end','$current_date','$current_time','$current_time','1','$s_year','$s_part') ";
        $add_stamp = mysqli_query($con,$sql_stamp);
    
    
        if($add_stamp){
        echo '<div class="row">';
        echo '<div class="col-md text-center">';
        echo '<h2 class="text-center text-primary">';
        echo  '<div class="text-center"><img src="https://employee.dekcom-chamnong.com/admin/profile/' . $show_name['img'] . '" width="150" height="150"></div>' . $show_name['t_name'] . ' ' . $show_name['t_surname'] . '<br>เข้างานแล้ว เวลา ' . timethai($current_time);
        echo '</h2>';
        echo '</div></div>';
        }
        else{
            echo '<h1 class="text-center text-danger">';
            //echo 'ERROR';
            echo 'Error : ' . mysqli_error($con);
            echo '</h1>';
        }
    
        
    }
    else{
    
    $sql_upstamp = "UPDATE timesheet set time_end = '$current_time' WHERE id = '$emp_id' and stamp_date = '$current_date' ";
    $qry_upstamp = mysqli_query($con,$sql_upstamp);

    if($qry_upstamp){
    echo '<div class="row">';
    echo '<div class="col-md text-center">';
    echo '<h2 class="text-center text-success">';
    echo '<div class="text-center"><img src="https://employee.dekcom-chamnong.com/admin/profile/' . $show_name['img'] . '" width="150" height="150"></div>' . $show_name['t_name'] . ' ' . $show_name['t_surname'] . '<br>ออกงานแล้ว เวลา ' . timethai($current_time);
    echo '</h2>';
    echo '</div></div>';
    }
    else{
        echo '<h1 class="text-center text-danger">';
        //echo 'ERROR';
        echo 'Error : ' . mysqli_error($con);
        echo '</h1>';
    }

    }
    
}
else{
    echo '<h1 class="text-center text-danger">';
        echo 'ไม่พบผู้ใช้งาน';
        echo '</h1>';

}

mysqli_close($con);
?>



