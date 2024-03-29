<?php
$pageName = "Leave";
include("../include/header.php");

?>

<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'http://localhost:8080/getleavesbyempid/'.$_SESSION['employeeId'],
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
));

$response = curl_exec($curl);
$resultarray = json_decode($response,true);
curl_close($curl);
// echo $response;
?>
<style>
  .dataTables_wrapper .dataTables_length{
    margin-top: 11px;
    margin-right: 2px;
  }
  .dataTables_wrapper .dataTables_filter label {
    margin-left: 10px;
  }
  .dataTables_wrapper .dataTables_filter {
    float: inline-end
  }
</style>
<div class="content-wrapper">
  <div class="content">
    
    <div class="card card-default">
      <div class="card-header">
        <h2>View All Leaves</h2>
        <div class="col-md-2 col-xl-2">
        <button type="button" class="btn btn-success"><a href="addleave.php"
            style="color:white;text-decoration:none">Add Leave</a></button>
      </div>
      </div>
      <div class="card-body">
        <table id="example" class="table table-product" style="width:100%">
          <thead>
            <tr>
              <th>Sr. No</th>
              <th>Leave Type</th>
              <th>From Date</th>
              <th>To Date</th>
              <th>Reason</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
          <?php
          $i=1;
             foreach ($resultarray['data'] as $leave)
               {
             ?>
            <tr>
              <td><?php echo $i; ?></td>
              <td><?php echo $leave['leaveType']; ?></td>
              <td> <?php echo date("d-m-Y", strtotime($leave['startDate'])); ?></td>
              <td> <?php echo date("d-m-Y", strtotime($leave['endDate'])); ?></td>
              <td><?php echo $leave['reason']; ?></td>
              <td style='color:<?php if($leave['status']=='pending') { echo "red"; } else { echo "green"; } ?>'><b><?php echo ucwords($leave['status']); ?></b></td>
            </tr> 
            <?php
            $i++;
              }
             ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<?php
include("../include/footer.php");
?>
<script>
  $(document).ready(function () {
    $('#example').DataTable({
    });
  });
</script>