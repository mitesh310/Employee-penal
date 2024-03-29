<?php
$pageName = "Dashboard";
include ("../include/header.php");
include ("../include/notification.php");

$curl = curl_init();

curl_setopt_array(
  $curl,
  array(
    CURLOPT_URL => 'http://localhost:8080/getallholidays',
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

?>

<?php
$absentarray = [];
$presentarray = [];
$curl = curl_init();

$currentMonth = date('m');
$currentYear = date('Y');

curl_setopt_array($curl, array(
  CURLOPT_URL => 'http://localhost:8080/getattendencebyempid',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array(
    'month' => $currentMonth,
    'year' => $currentYear,
    "employeeId" => $_SESSION['employeeId']
  ),
)
);

$response = curl_exec($curl);
$resultpresentarray = json_decode($response, true);
foreach ($resultpresentarray['data'] as $attend) {
  if ($attend['attendenceStatus'] == 'present') {
    $presentarray[] = "1";
  } else {
    $absentarray[] = "1";
  }
}
curl_close($curl);

?>


<?php


if (isset($_POST['reqSubmit'])) {
  $fromTime = $_POST['fromTime'];
  $toTime = $_POST['toTime'];
  $reason = $_POST['reason'];
  $fromDate = $_POST['fromDate'];



  $curl = curl_init();

  curl_setopt_array(
    $curl,
    array(
      CURLOPT_URL => 'http://localhost:8080/createrequest',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => array(
        'employeeId' => $_SESSION['employeeId'],
        'type' => 'clocktime',
        'description' => $reason,
        'Date' => $fromDate,
        'keyname' => $fromTime == "" ? 'clockOut' : 'clockIn',
        'value' => $fromTime == "" ? $toTime : $fromTime
      ),
    )
  );

  $response = curl_exec($curl);
  addnotification($_SESSION['employeeId'], "clocktime", $fromTime, $reason);
  curl_close($curl);
  // echo $response;
}
?>
<?php

$curl = curl_init();

curl_setopt_array(
  $curl,
  array(
    CURLOPT_URL => 'http://localhost:8080/getprojectsbyempid/' . $_SESSION['employeeId'],
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
$projectdeatils = json_decode($response, true);
curl_close($curl);
// echo $response;
?>
<?php
if (isset($_GET['clockId'])) {
  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => 'http://localhost:8080/clockout',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => '{
    "employeeId":"' . $_SESSION['employeeId'] . '"   
  }',
    CURLOPT_HTTPHEADER => array(
      'Content-Type: application/json'
    ),
  )
  );

  $response = curl_exec($curl);

  curl_close($curl);
  echo $response;

  setcookie('clockin', '', time() - 3600, '/');
  unset($_COOKIE['clockin']);
  header("location:../dashboard/");
}

?>


<?php
if (isset($_GET['breakId'])) {
  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => 'http://localhost:8080/breakend',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => '{
    "employeeId":"' . $_SESSION['employeeId'] . '"
}',
    CURLOPT_HTTPHEADER => array(
      'Content-Type: application/json'
    ),
  )
  );

  $response = curl_exec($curl);

  curl_close($curl);
  echo $response;
  setcookie('breakin', '', time() - 3600, '/');
  unset($_COOKIE['breakin']);
  header("location:../dashboard/");
}
?>
<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'http://localhost:8080/getleavesbyempid/' . $_SESSION['employeeId'],
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
$leave = json_decode($response, true);
curl_close($curl);

?>

<style>
  .imgg {
    display: block;
    margin-left: auto;
    margin-right: auto;
  }

  .error {
    color: #FF0000 !important;
  }
</style>

<div class="content-wrapper">
  <div class="content">
    <div class="row">
      <div class="col-md-4 col-xl-4">
        <div class="card py-3 mb-4">
          <div class="card-body">
            <h5 class="card-title ">My Attendance</h5>
            <hr>
            <div class="row">
              <div class="col-md-4 col-xl-4">
                <h5 class="text-success text-center">Present</h5>
                <h1 class="text-success text-center"><b>
                    <?php echo count($presentarray); ?>
                  </b></h1>
              </div>
              <div class="col-md-4 col-xl-4">
                <h5 class="text-danger text-center">Absent</h5>
                <h1 class="text-danger text-center"><b>
                    <?php echo count($absentarray); ?>
                  </b></h1>
              </div>
            </div>
          </div>
        </div>

        <div class="card card-default" id="page-views">
          <div class="card-header">
            <h2>Upcoming Holidays</h2>
          </div>
          <div class="card-body py-0" data-simplebar style="height: 392px;">
            <table class="table table-borderless table-thead-border">
              <thead>
                <tr>
                  <th>Holiday Name</th>
                  <th class="text-right px-3">Date</th>
                </tr>
              </thead>
              <tbody>
                <?php
                foreach ($resultArray['data'] as $holiday) {
                  ?>
                  <tr>
                    <td>
                      <?php echo $holiday['holidayName']; ?>
                    </td>
                    <td class="text-right">
                      <?php echo date("d-m-Y", strtotime($holiday['holidayDate'])); ?>
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
      <div class="col-md-4 col-xl-4">
        <div class="card py-3 mb-4">
          <div class="card-body">
            <h5 class="card-title ">Monthly Leave</h5>
            <hr>
            <div class="row">
              <div class="col-md-4 col-xl-4">
                <h5 class="text-success text-center">No. Of Leave</h5>
                <h1 class="text-success text-center"><b>
                    <?php echo count($leave['data']); ?>
                  </b></h1>
              </div>

            </div>

          </div>
        </div>
        <div class="card card-default" id="page-views">
          <div class="card-header">
            <h2>Project Details</h2>
          </div>
          <div class="card-body py-0" data-simplebar style="height: 392px;">
            <table class="table table-borderless table-thead-border">
              <thead>
                <tr>
                  <th>Project Name</th>
                  <th>Start Date</th>
                  <th>End Date</th>
                  <th>Description</th>
                </tr>
              </thead>
              <tbody>
                <?php
                foreach ($projectdeatils['data'] as $project) {
                  ?>
                  <tr>
                    <td>
                      <?php echo $project['projectDetails']['ProjectName']; ?>
                    </td>
                    <td>
                      <?php echo date("d-m-Y", strtotime($project['projectDetails']['startDate'])); ?>
                    </td>
                    <td>
                      <?php echo date("d-m-Y", strtotime($project['projectDetails']['endDate'])); ?>
                    </td>
                    <td>
                      <?php echo $project['projectDetails']['projectDescription']; ?>
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
      <div class="col-md-4 col-xl-4">
        <div class="card py-3 mb-4">
          <div class="card-body">
            <img class="rounded-circle imgg" src="../images/user/u8.jpg" alt="Italian Trulli">

            <h5 class="card-title  text-center">
              <?php echo $_SESSION['name']; ?>
            </h5>
            <hr>

            <div class="row">

              <div class="col-md-6 col-xl-6 text-center">
                <button type="button" id="clock_in" class="btn btn-lg btn-success" <?php
                if (isset($_COOKIE['clockin'])) {
                  echo "disabled";
                }
                ?>>Clock In</button>
              </div>

              <div class="col-md-6 col-xl-6 text-center">
                <a href="?clockId=1" onclick="return confirm('Are you sure you want to Clock_Out.')"> <button
                    type="button" id="clock_out" class="btn btn-lg btn-danger">Clock Out</button></a>
              </div>
            </div>
            <div class="row mt-4">
              <div class="col-md-6 col-xl-6 text-center">
                <button type="button" id="break_in" class="btn btn-lg btn-success" <?php
                if (isset($_COOKIE['breakin'])) {
                  echo "disabled";
                }
                ?>>Break in</button>
              </div>
              <div class="col-md-6 col-xl-6 text-center">
                <a href="?breakId=1" onclick="return confirm('Are you sure you want to Break_Out.')"> <button
                    type="button" class="btn btn-lg btn-danger">Break out</button></a>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 col-xl-12 mt-2 text-center">
                <a class="d-block mb-2" href="javascript:void(0)" data-toggle="modal" data-target="#modal-contact">
                  <!-- <h5 class="card-title">Project Name</h5> -->
                  <button type="button" class="btn btn-lg btn-warning">Attendance Request</button>
                </a>
              </div>
              <!-- Contact Modal -->
              <div class="modal fade" id="modal-contact" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                  <div class="modal-content">
                    <div class="modal-header justify-content-end border-bottom-0">
                      <button type="button" class="btn-close-icon" data-dismiss="modal" aria-label="Close">
                        <i class="mdi mdi-close"></i>
                      </button>
                    </div>

                    <div class="modal-body pt-0">
                      <form method="post" id="project_form" enctype="multipart/form-data">
                        <div class="form-group">
                          <label for="exampleFormControlInput44">Select Date</label>
                          <input type="date" name="fromDate" class="form-control rounded-0">
                        </div>
                        <div class="form-group">
                          <label for="exampleFormControlInput44">Select In Time</label>
                          <input type="time" name="fromTime" class="form-control rounded-0">
                        </div>
                        <div class="form-group">
                          <label for="exampleFormControlInput44">Select Out Time</label>
                          <input type="time" name="toTime" class="form-control rounded-0">
                        </div>
                        <div class="form-group">
                          <label for="exampleFormControlInput44">Reason</label>
                          <textarea class="form-control rounded-0" name="reason"></textarea>
                        </div>
                        <div class="form-footer">
                          <button type="submit" name="reqSubmit" class="btn btn-secondary btn-pill">Submit</button>
                        </div>

                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
include ("../include/footer.php");
?>
<script>
  $(document).ready(function () {
    $("#clock_in").click(function () {
      $.ajax({
        url: "../ajax/clockin.php", success: function (result) {
          $("#clock_in").hide();
        }
      });
    });

    $("#break_in").click(function () {
      $.ajax({
        url: "../ajax/breakin.php", success: function (result) {
          $("#break_in").prop("disabled", true);
        }
      });
    });
    $("#break_out").click(function () {
      $.ajax({
        url: "../ajax/breakout.php", success: function (result) {
          $("#break_in").prop("disabled", false);
        }
      });
    });

  });
</script>


<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script>
  $(document).ready(function () {
    $("#project_form").validate({
      rules: {
        reason: {
          required: true,
        },
        fromDate: {
          required: true,
        },


      },
    });
  });
</script>