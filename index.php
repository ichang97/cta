<?php 

include 'sql/connect.php';
include 'header.php';

?>


<body>


<!-- time -->
<?

date_default_timezone_set('Asia/Bangkok');

function datethai($strDate)
{
    $strYear = date("Y",strtotime($strDate))+543;
    $strMonth= date("n",strtotime($strDate));
    $strDay= date("j",strtotime($strDate));
    $strHour= date("H",strtotime($strDate));
    $strMinute= date("i",strtotime($strDate));
    $strSeconds= date("s",strtotime($strDate));
    $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
    $strMonthThai=$strMonthCut[$strMonth];
return "$strDay $strMonthThai $strYear";
}
?>


<script type="text/javascript">
 $(function () {
 $("#btnstamp").click(function () {
 $.ajax({
 url: "stamp.php",
 type: "post",
 data: {txt_rfid: $("#txt_rfid").val()},
 success: function (data) {
 $("#result").html(data);

window.setTimeout(function(){
window.location.href = "https://cta.dekcom-chamnong.com";
}, 3000);

 }
 });
 });
 
$('#txt_rfid').keypress(function(event){
    if (event.keycode == 13 || event.which == 13){
        $("#btnstamp").click();
        return false;
    }
});


 });

 $(document).ready(function() {
    setInterval(timestamp, 1000);
});

function timestamp() {
    $.ajax({
        url: 'https://cta.dekcom-chamnong.com/timestamp.php',
        success: function(data) {
            $('#timestamp').html(data);
        },
    });
}
</script>
<br>
  <div class="container">
<div class="card card-cascade narrower">
<div class="view view-cascade overlay">
<div class="card peach-gradient">
<div class="card-body text-center">
<img src="chamnong.png" width="150" height="150" style="display: block;margin-left: auto;margin-right: auto;">
  <h2>ระบบลงเวลาทำงานครู โรงเรียนจำนงค์วิทยา</h2>
  <h2><div id="timestamp"></div></h2>
</div>
</div>

</div>

<div class="card-body card-body-cascade">
<div class="container">
<form name="frm_stamp" id="frm_stamp">
  <div class="form-group">
  <input type="password" name="txt_rfid" id="txt_rfid" class="form-control text-center" autofocus>
</div>
<div class="form-group">
<button class="btn btn-primary btn-rounded btn-block" type="button" id="btnstamp">stamp</button>
</div>
</form>
</div> 
<br>
<div class="container" id="result">
</div>

</div>
</div>







  </div>



<br>



<?php include("footer.php") ?>