<?php
$pageName = "Leave";

include("../include/header.php");
include("../include/notification.php");

if(isset($_POST['submit']))
{
    $leaveType = $_POST['leaveType'];
    $no_days = $_POST['no_days'];
    $from_date = $_POST['from_date'];
    $to_date =$_POST['to_date'];
    $reason = $_POST['reason'];


    
    $curl = curl_init();


    curl_setopt_array($curl, array(
      CURLOPT_URL => 'http://localhost:8080/addleave',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => array('empId' => $_SESSION['employeeId'],'leaveType' => $leaveType,'noOfDays' => $no_days,
      'startDate' => $from_date,'endDate' =>$to_date,'reason' => $reason,'leave_doc'=> new CURLFILE('../images/favicon.png')),
    ));
    
    $response = curl_exec($curl);
    addnotification($_SESSION['employeeId'],"Leave",$leaveType,$reason);
    curl_close($curl);
    $resultArray = json_decode($response, true);
    header("location:../leave/");
}
?>
<style>
    .error{
        color:red;
    }
    </style>
<div class="content-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-xl-3">
            </div>
            <div class="col-xl-6">
                <div class="card card-default">
                    <div class="card-header">
                        <h2>Request For Leave</h2>
                    </div>
                    <div class="card-body">
                        <form method ="post" id="leave_form">
                            <div class="form-group">
                                <label for="exampleFormControlSelect14">Leave Type <span class="error">*</span></label>
                                <select class="form-control rounded-0" name="leaveType" id="exampleFormControlSelect14">
                                    <option value=""></option>
                                    <option value="Full Day">Full Day</option>
                                    <option value="1st Half">1st Half</option>
                                    <option value="2nd Half">2nd Half</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlInput44">No. Of Days <span class="error">*</span></label>
                                <input type="text" name="no_days" class="form-control rounded-0" >
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlInput44">Select Date(From)  <span class="error">*</span></label>
                                <input type="date" name="from_date" class="form-control rounded-0" >
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlInput44">Select Date(To) <span class="error">*</span></label>
                                <input type="date" name="to_date" class="form-control rounded-0" >
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlInput44">Reason  <span class="error">*</span></label>
                                <textarea class="form-control rounded-0" name="reason"></textarea>
                            </div>

                            <input type = "submit"  class="btn btn-secondary " name = "submit" value = "Submit"> 
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    include("../include/footer.php");
    ?>
    <script src=
"https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js">
      </script>
<script>
$(document).ready(function(){
    $("#leave_form").validate({
        rules: {
            leaveType :{
            required: true
           },
           from_date:{
            required: true
           },
           to_date:{
            required:true
           },
           no_days:{
            required: true
           },
           reason:{
            required: true
           }
        },
        errorPlacement: function (error, element) {
            if(element.attr("name") == "degreeCertificate")
            {
              error.appendTo("#file_error");
            }
             else {
                error.insertAfter(element)
            }
        },
     
});
  });
        </script>