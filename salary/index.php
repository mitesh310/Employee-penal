<?php
$pageName = "Salary";
include("../include/header.php");
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

<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'http://localhost:8080/getworkinghours',
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
$workingHours = $resultarray['data'][0]['workingHours'];
curl_close($curl);

?>

<?php
$currentMonth = date('n'); 
$currentYear = date('Y'); 

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'http://localhost:8080/createsalarybyempid',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array(
    'employeeId' => $_SESSION['employeeId'],
    'month' =>  $currentMonth,
    'year' => $currentYear,
    'workinghours' => $workingHours,
    'status' => 'pending'
),
));

$response = curl_exec($curl);

curl_close($curl);
$resultsalary = json_decode($response,true);
?>


<div class="content-wrapper">
    <div class="content">
        <div class="card card-default">
            <div class="card-header">
                <h2>View All Salary</h2>
            </div>
            <div class="card-body">
                <table id="example" class="table table-product" style="width:100%">
                    <thead>
                        <tr>
                            <th>Sr. No</th>
                            <th>Month</th>
                            <th>Current Salary</th>
                            <th>Net Salary</th>
                            <th>Download Salary Slip</th>
                            <!-- <th>Status</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>January</td>
                            <td><?php echo number_format($resultsalary['data']['currentSalary']); ?></td>
                            <td><?php echo number_format($resultsalary['data']['netSalary']); ?></td>
                            <td>
                            <a target="_blank" href="pdf_maker.php?salary=<?php echo $resultsalary['data']['currentSalary']; ?>&name=<?php echo $_SESSION['name']; ?>&deducation=<?php echo $resultsalary['data']['leavesDeducation']; ?>&extra=<?php echo $resultsalary['data']['bonus']; ?>&netSalary=<?php echo $resultsalary['data']['netSalary']; ?>&ACTION=VIEW" class="btn btn-success"><i class="fa fa-file-pdf-o"></i> View Salary Slip</a> &nbsp;&nbsp; 
				 		        <a href="pdf_maker.php?salary=<?php echo $resultsalary['data']['currentSalary']; ?>&name=<?php echo $_SESSION['name']; ?>&deducation=<?php echo $resultsalary['data']['leavesDeducation']; ?>&extra=<?php echo $resultsalary['data']['bonus']; ?>&netSalary=<?php echo $resultsalary['data']['netSalary']; ?>&ACTION=DOWNLOAD" class="btn btn-danger"><i class="fa fa-download"></i> Download Salary Slip</a>
                            </td>
                            <!-- <td>Pending</td> -->
                        </tr>
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