<?php
$pageName = "Policy";
include("../include/header.php");
?>

<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'http://localhost:8080/getallpolicies',
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
                <h2>View All Salary</h2>
            </div>
            <div class="card-body">
                <table id="example" class="table table-product" style="width:100%">
                    <thead>
                        <tr>
                            <th>Policy Name</th>
                            <th>Policy Description</th>
                            <th>Policy Violation</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php   
                            foreach ($resultarray['data'] as $emp) {
                        ?>
                                            
                        <tr>
                            <td><?php echo $emp['policyName']; ?></td>
                            <td><?php echo $emp['policyDescription']; ?></td>
                            <td><?php echo $emp['policyViolation']; ?></td>
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
include("../include/footer.php");
?>
<script>
    $(document).ready(function () {
        $('#example').DataTable({

        });
    });
</script>