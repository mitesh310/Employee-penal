<?php
$pageName = "Attendance";
include ("../include/header.php");
$workingHours = "";
?>

<!-- get working hours api -->
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
)
);

$response = curl_exec($curl);
$resultarray = json_decode($response, true);
$workingHours = $resultarray['data'][0]['workingHours'];
curl_close($curl);
?>

<?php

$currentMonth = date('n');
$currentYear = date('Y');

if ($_GET['year'] > $currentYear || ($_GET['year'] == $currentYear && $_GET['month'] > $currentMonth)) {
    $_GET['year'] = $currentYear;
    $_GET['month'] = $currentMonth;
}

$res = getSalary($_GET['month'], $_GET['year'], $workingHours);
$resultsalary = json_decode($res, true);

function getSalary($month, $year, $workingHours)
{
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
            'month' => $month,
            'year' => $year,
            'workinghours' => $workingHours,
            'status' => 'pending'
        ),
    )
    );

    $response = curl_exec($curl);
    curl_close($curl);

    return $response;
}
?>

<link rel="stylesheet" href="../css/bootstrap.min.css">
<link rel="stylesheet" href="../fullcalendar/lib/main.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="../js/jquery-3.6.0.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../fullcalendar/lib/main.min.js"></script>
<style>
    :root {
        --bs-success-rgb: 71, 222, 152 !important;
    }

    html,
    body {
        height: 100%;
        width: 100%;
        /* font-family: Apple Chancery, cursive; */
    }

    a {
        text-decoration: none;
    }

    .btn-info.text-light:hover,
    .btn-info.text-light:focus {
        background: #000;
    }

    table,
    tbody,
    td,
    tfoot,
    th,
    thead,
    tr {
        border-color: #DEDEDE !important;
        border-style: solid;
        border-width: 1px !important;
    }

    .btn {
        background-color: #09aff4;
        border-color: #09aff4;
    }

    .btn:hover {
        border-color: #09aff4;
        background-color: #09aff4;
    }

    .btn-primary:disabled {
        background-color: #09aff4;
        border-color: #09aff4;
    }

    .btn-primary:not(:disabled):not(.disabled).active {
        background-color: #4495EC;
        border-color: #4495EC;
    }

    .fc-h-event .fc-event-title-container {
        padding: 10px;
        text-align: center;
    }

    .btn-group,
    .btn-group-vertical {
        display: none;
    }

    .fc-direction-ltr .fc-toolbar>*>:not(:first-child) {
        display: none;
    }
</style>
<div class="content-body">

    <div class="container py-5" id="page-container">
        <div class="row mb-5">
            <div class="col-md-6">
                <select id="mySelect" class="form-control" onchange="yearFunction()">
                    <option value="">Select Year</option>
                    <?php
                    for ($i = 2022; $i <= 2090; $i++) {
                        ?>
                        <option value="<?php echo $i; ?>" <?php
                           if ($i == $_GET['year']) {
                               echo "selected";
                           }
                           ?>><?php echo $i; ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-6">
                <select class="form-control" id="monthSelect" onchange="monthFunction()">
                    <option value="">Select Month</option>
                    <?php
                    for ($i = 1; $i <= 12; $i++) {
                        $formattedMonth = sprintf('%02d', $i);
                        ?>
                        <option value="<?php echo $formattedMonth; ?>" <?php
                           if ($formattedMonth == $_GET['month']) {
                               echo "selected";
                           }
                           ?>><?php echo $formattedMonth; ?>
                        </option>
                        <?php
                    }
                    ?>
                </select>
            </div>

        </div>
        <div class="row">
            <div class="col-md-12">

                <div id="calendar"></div>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-4">
                <h5>Current Salary</h5>
            </div>
            <div class="col-md-6">
            </div>
            <div class="col-md-2">
                <h4>
                    <?php echo number_format($resultsalary['data']['currentSalary']); ?>
                </h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <h5>Deducation</h5>
            </div>
            <div class="col-md-6">
            </div>
            <div class="col-md-2">
                <h4>
                    <?php echo number_format(round($resultsalary['data']['leavesDeducation'])); ?>
                </h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <h5>Extra</h5>
            </div>
            <div class="col-md-6">
            </div>
            <div class="col-md-2">
                <h4>
                    <?php echo number_format(round($resultsalary['data']['bonus'])); ?>
                </h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <h5>Net Salary</h5>
            </div>
            <div class="col-md-6">
            </div>
            <div class="col-md-2">
                <h4>
                    <?php echo number_format(round($resultsalary['data']['netSalary'])); ?>
                </h4>
            </div>
        </div>
    </div>
</div>
<!-- Event Details Modal -->
<div class="modal fade" tabindex="-1" data-bs-backdrop="static" id="event-details-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-0">
            <div class="modal-header rounded-0">
                <h5 class="modal-title">Attendance Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body rounded-0">
                <div class="container-fluid">
                    <dl>
                        <h3 id="title" class="fw-bold fs-4"></h3>
                        <h5 id="clock_in" class="fw-bold fs-5"></h5>
                        <h5 id="clock_out" class="fw-bold fs-5"></h5>
                        <br>
                        <?php
                        for ($i = 0; $i < 10; $i++) {
                            ?>
                            <h5 id="break_in<?php echo $i; ?>" class="fw-bold fs-5"></h5>
                            <h5 id="break_out<?php echo $i; ?>" class="fw-bold fs-5"></h5>
                            <br>
                            <?php
                        }
                        ?>
                    </dl>
                </div>
            </div>
            <div class="modal-footer rounded-0">
                <div class="text-end">
                    <button type="button" class="btn btn-secondary btn-sm rounded-0"
                        data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Event Details Modal -->


<?php
include ("../include/footer.php");
?>
<?php
// $sched_res = [];
attendanceshow();
function attendanceshow()
{
    $curl = curl_init();


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
                'year' => $_GET['year'],
                'month' => $_GET['month'],
                "employeeId" => $_SESSION['employeeId']
            ),
    )
    );

    $response = curl_exec($curl);

    $resultarray = json_decode($response, true);
    curl_close($curl);

    $i = 0;
    foreach ($resultarray['data'] as $attendance) {

        $date = date('Y-m-d');
        if ($attendance['date'] > $date) {
            break;
        }
        $array = [];
        $array["id"] = $i;
        $array["start_datetime"] = $attendance['date'];
        $array['title'] = ucwords($attendance['attendenceStatus']);
        if ($attendance['attendenceStatus'] == 'present') {
            $array['clockin'] = $attendance['attendeDetails']['clockIn'];
            $array['clockout'] = $attendance['attendeDetails']['clockOut'];
            if (isset($attendance['breakDetails'])) {
                $result = $attendance['breakDetails'];
                $array['breakcount'] = count($result);
                for ($j = 0; $j < count($result); $j++) {
                    $array['breakin' . $j] = $result[$j]['breakStart'];
                    $array['breakout' . $j] = $result[$j]['breakEnd'];
                }
            }
        } else {
            $array['clockin'] = "00:00";
            $array['clockout'] = "00:00";
            $array['breakcount'] = 0;

        }
        $sched_res[] = $array;
        $i++;
    }

    ?>

    <script>
        var scheds = $.parseJSON('<?= json_encode($sched_res) ?>')
    </script>
    <?php
}
?>

<script src="../js/script.js"></script>
<script>
    function yearFunction() {
        var month = "<?php echo $_GET['month']; ?>";
        var selectedValue = document.getElementById("mySelect").value;
        var params = "?year=" + selectedValue + "&month=" + month;
        window.location.href = window.location.pathname + params;
    }

    function monthFunction() {
        var year = "<?php echo $_GET['year']; ?>";
        var selectedValue = document.getElementById("monthSelect").value;
        var params = "?year=" + year + "&month=" + selectedValue;
        window.location.href = window.location.pathname + params;
    }
</script>

<script>
    $(document).ready(function () {
        var year = <?php echo $_GET['year']; ?>;
        var month = "<?php echo $_GET['month']; ?>";
        calendar.gotoDate(year + '-' + month + '-01');
    });
</script>

</html>