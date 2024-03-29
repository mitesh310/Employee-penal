<?php
$pageName = "Task";
include ("../include/header.php");
include("../include/notification.php");

?>
<?php

$curl = curl_init();

curl_setopt_array(
  $curl,
  array(
    CURLOPT_URL => 'http://localhost:8080/gettasksbyempid/' . $_SESSION['employeeId'],
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
  )
);

$response = curl_exec($curl);
$resultArray = json_decode($response, true);
curl_close($curl);


if(isset($_GET['taskId']))
{
  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => 'http://localhost:8080/edittaskstatus',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => array('taskId' => $_GET['taskId'],'projectId' => $_GET['projectId'],'status' => 'done'),
  ));
  
  $response = curl_exec($curl);
  addnotification($_SESSION['employeeId'],$_GET['taskName'],$_GET['ProjectName'],'done');

  curl_close($curl);
  header("location:index.php");

}

?>
<style>
  .dataTables_wrapper .dataTables_length {
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
        <h2>View All Task</h2>
        <!-- <div class="col-md-2 col-xl-2">
          <button type="button" class="btn btn-success"><a href="addtask.php"
              style="color:white;text-decoration:none">Add Task</a></button>
        </div> -->
      </div>
      <div class="card-body">
        <table id="example" class="table table-product" style="width:100%">
          <thead>
            <tr>
              <th>Task Name</th>
              <th>Task Description</th>
              <th>Project Name</th>
              <th>Start Date</th>
              <th>Due Date</th>
              <th>Priority</th>
              <th>Report To</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            foreach ($resultArray['data'] as $task) {
              ?>
              <tr>
                <td>
                  <?php echo $task['taskName'] ?>
                </td>
                <td>
                  <?php echo $task['taskDescription'] ?>
                </td>
                <td>
                  <?php echo $task['taskDetails']['ProjectName'] ?>
                </td>
                <td>
                  <?php echo date('d-m-Y', strtotime($task['startDate'])); ?>
                </td>
                <td>
                  <?php echo date('d-m-Y', strtotime($task['endDate'])); ?>
                </td>
                <td style="color:<?php
                if ($task['priority'] == "High") {
                  echo "red";
                } elseif ($task['priority'] == "Medium") {
                  echo "orange";
                } elseif ($task['priority'] == "Low") {
                  echo "green";
                } else {
                  echo "black"; // Default color if priority is not recognized
                }
                ?>">
                  <?php echo $task['priority'] ?>
                </td>
                <td>
                  <?php echo $task['mentorDetails'][0]['name'] ?>
                </td>
                <td>
                  <?php
                  if($task['status']!='done')
                  {
                  ?>
                  <a href="?taskId=<?php echo $task['taskId']; ?>&projectId=<?php echo $task['projectId']; ?>&taskName=<?php echo $task['taskName']; ?>&ProjectName=<?php echo $task['taskDetails']['ProjectName']; ?>" onclick="return confirm('Are you sure you want to Complete Task.')" rel="noopener"
                    style='color:white' class="btn mb-1 btn-success">Complete</a>
                  <!-- <a href="" onclick="return confirm('Are you sure you want to In Process Task.')" rel="noopener" style='color:white' class="btn mb-1 btn-warning">In Process</a> -->
                 <?php
                  }
                  else{
                   ?>
                  <h5 style="color:green"><?php echo ucwords($task['status']); ?></h5>
                 <?php   
                  }
                 ?>     
                </td>
              </tr>
              <?php
            }
            ?>
          </tbody>
        </table>

      </div>
    </div>
  </div>
</div>


<?php
include ("../include/footer.php");
?>
<script>
  $(document).ready(function () {
    $('#example').DataTable({

    });
  });
</script>