<?php
$pageName = "Profile";

include("../include/header.php");
include("../include/notification.php");

?>
<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'http://localhost:8080/getemployeeeducationbyid/'.$_SESSION['employeeId'],
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
));

$response = curl_exec($curl);

curl_close($curl);
$resultArray = json_decode($response, true);
$degreeName = $resultArray['data'][0]['degreeName'];
$passingYear = $resultArray['data'][0]['passingYear'];
$percentage = $resultArray['data'][0]['percentage'];
$degreeCertificate = $resultArray['data'][0]['degreeCertificate'];

?>
<?php
if(isset($_POST['submit']))
{
  $dName = $_POST['dName'];
  $pYear = $_POST['pYear'];
  $Percentage = $_POST['Percentage'];
  $dCertification = $_POST['dCertification'];
  

  if($dName!=$degreeName)
  {
     changevalue("Changes Names","degreeName",$dName);
  }
  if($pYear!=$passingYear)
  {
     changevalue("Changes Names","passingYear",$pYear);
  }
  if($Percentage!=$percentage)
  {
     changevalue("Changes Names","percentage",$Percentage);
  }
  if($dCertification!=$degreeCertificate)
  {
     changevalue("Changes Names","degreeCertificate",$dCertification);
  }
  

  header("location:../profile/eduction.php");
}
function changevalue($desc,$key,$value) {
  $curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'http://localhost:8080/createrequest',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array('employeeId' => $_SESSION['employeeId'],'type' => 'update_employee','description' =>$desc,'keyname' => $key,'value' => $value),
));

$response = curl_exec($curl);
addnotification($_SESSION['employeeId'],"update_employee",$desc,$value);
curl_close($curl);
echo $response;
}

?>
<style>
  .btn{
      background-color: rgb(9,175,244);
      border-color: transparent;
    }
    .btn:hover{
      background-color: rgb(9,175,244);
      border-color: transparent;
    }
    .nav-settings .nav-link:hover{
    color: #09aff4;
  }
    .nav-settings .nav-link.active{
      color: #09aff4;
    }
</style>

        <div class="content-wrapper">
          <div class="content"><!-- Card Profile -->
            <div class="card card-default card-profile">

              <div class="card-header-bg" style="background-image:url(../assets/img/user/user-bg-01.jpg)"></div>

              <div class="card-body card-profile-body">
                <div class="profile-avata">
                  <img class="rounded-circle" src="../images/user/user-md-01.jpg" alt="Avata Image">
                  <a class="h5 d-block mt-3 mb-2" href="#"><?php echo $_SESSION['name']; ?></a>
                </div>
              </div>

              

            </div>
            <div class="row">
              <div class="col-xl-3">
                <!--  -->
                <div class="card card-default">
                  <div class="card-header">
                    <h2>Settings</h2>
                  </div>

                  <div class="card-body pt-0">
                    <ul class="nav nav-settings">
                      <li class="nav-item">
                        <a class="nav-link" href="../profile">
                          <i class="mdi mdi-account-outline mr-1"></i> Personal
                        </a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link active" href="../profile/eduction.php">
                          <i class="mdi mdi-school mr-1"></i> Education
                        </a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="../profile/document.php">
                          <i class="mdi mdi-file-document-outline mr-1"></i> Documents
                        </a>
                      </li>
                      
                    </ul>
                  </div>
                </div>
              </div>
              <div class="col-xl-9">
                <div class="card card-default">
                  <div class="card-header">
                    <h2 class="mb-5">Education Information</h2>
                  </div>
                  <div class="card-body">
                    <form method="post">
                    <div class="row mb-2">
                        <div class="col-lg-6">
                          <div class="form-group">
                            <label for="degreeName">Degree Name</label>
                            <input type="text" class="form-control" name="dName" value="<?php echo $degreeName; ?>">
                          </div>
                        </div>

                        <div class="col-lg-6">
                          <div class="form-group">
                            <label for="passingYear">Passing Year</label>
                            <input type="text" class="form-control"  name="pYear" value="<?php echo $passingYear; ?>">
                          </div>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-lg-6">
                          <div class="form-group">
                            <label for="percentage">Percentage</label>
                            <input type="text" class="form-control"  name="Percentage" value="<?php echo $percentage; ?>">
                          </div>
                        </div>

                        <div class="col-lg-6">
                          <div class="form-group">
                              <label for="degreeCertificate">Degree Certificate</label>
                              <input type="file" class="form-control"  name="dCertification" value="<?php echo $degreeCertificate; ?>">
                          </div>
                        </div>
                    </div>

                    

                    <div class="d-flex justify-content-end mt-6">
                        <button type="submit" class="btn btn-primary mb-2 btn-pill" name="submit">Update Profile</button>
                    </div>

                    </form>
                </div>      
                </div>
              </div>
            </div>
          </div>
        </div>






<?php
    include("../include/footer.php");
?>