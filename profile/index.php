<?php
$pageName = "Profile";
include("../include/header.php");
include("../include/notification.php");

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'http://localhost:8080/getemployeebyid/'.$_SESSION['employeeId'],
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
$name = $resultArray['data'][0]['name'];
$email = $resultArray['data'][0]['email'];
$mobileNumber = $resultArray['data'][0]['mobileNumber'];
$gender = $resultArray['data'][0]['gender'];
$date_of_birth = $resultArray['data'][0]['date_of_birth'];
$marital_status = $resultArray['data'][0]['marital_status'];
$address = $resultArray['data'][0]['address'];
$designation = $resultArray['data'][0]['designation'];
$salary = $resultArray['data'][0]['salary'];
$companyEmail = $resultArray['data'][0]['companyEmail'];
$password = $resultArray['data'][0]['password'];
$date_of_joining = $resultArray['data'][0]['date_of_joining'];
$ExperienceType = $resultArray['data'][0]['ExperienceType'];
?>
<?php
if(isset($_POST['submit']))
{
  $fullName = $_POST['fullName'];
  $postemail = $_POST['postemail'];
  $postmobileNumber = $_POST['postmobileNumber'];
  $postgender = $_POST['postgender'];
  $postdateofbirth = $_POST['postdateofbirth'];
  $postmartialstatus = $_POST['postmartialstatus'];
  $postaddress = $_POST['postaddress'];
  $postdateofjoining = $_POST['postdateofjoining'];
  $postdesignation = $_POST['postdesignation'];
  $postexperience = $_POST['postexperience'];


  if($fullName!=$name)
  {
     changevalue("Changes Names","name",$fullName);
  }
  if($postemail!=$email)
  {
    changevalue("Change in Email","email",$postemail);
  }
  if($postmobileNumber!=$mobileNumber)
  {
    changevalue("Change in Mobile Number","mobileNumber",$postmobileNumber);
  }
  if($postgender!=$gender)
  {
    changevalue("Change in Gender","gender",$postgender);
  }
  if($postdateofbirth!=$date_of_birth)
  {
    changevalue("Change in Date Of Birth","date_of_birth",$postdateofbirth);
  }
  if($postmartialstatus!=$marital_status)
  {
    changevalue("Change in Martial Status","marital_status",$postmartialstatus);
  }
  if($postaddress!=$address)
  {
    changevalue("Change in Address","address",$postaddress);
  }
  if($postdateofjoining!=$date_of_joining)
  {
    changevalue("Change in Date of Joining","date_of_joining",$postdateofjoining);
  }
  if($postdesignation!=$designation)
  {
    changevalue("Change in Designation","designation",$postdesignation);
  }
  if($postexperience!=$ExperienceType)
  {
    changevalue("Change in ExperienceType","ExperienceType",$postexperience);
  }

  header("location:../profile/");
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
  CURLOPT_POSTFIELDS => array('employeeId' => $_SESSION['employeeId'],'type' => 'update_employee','description' =>$desc,'keyname' => $desc,'value' => $value),
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
          <div class="content">
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
                <div class="card card-default">
                  <div class="card-header">
                    <h2>Settings</h2>
                  </div>

                  <div class="card-body pt-0">
                    <ul class="nav nav-settings">
                      <li class="nav-item">
                        <a class="nav-link active" href="../profile/index.php">
                          <i class="mdi mdi-account-outline mr-1"></i> Personal
                        </a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="../profile/eduction.php">
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
                    <h2 class="mb-5">Personal Information</h2>

                  </div>

                  <div class="card-body">
                  <form method="post">
                    <div class="row mb-2">
                        <div class="col-lg-6">
                          <div class="form-group">
                            <label for="firstName">Full name</label>
                            <input type="text" class="form-control" name="fullName" value="<?php echo $name; ?>">
                          </div>
                        </div>

                        <div class="col-lg-6">
                          <div class="form-group">
                              <label for="email">Email</label>
                              <input type="email" class="form-control" name="postemail" value="<?php echo $email; ?>">
                          </div>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-lg-6">
                          <div class="form-group mb-4">
                            <label for="mobileNo">Mobile Number</label>
                            <input type="text" class="form-control" name="postmobileNumber" value="<?php echo $mobileNumber; ?>">
                          </div>
                        </div>

                        <div class="col-lg-6">
                          <div class="form-group mb-4">
                            <label for="gender">Gender</label>
                              <select  class="form-control" name="postgender">
                                  <option value="">Select Gender</option>
                                  <option value="Male" <?php if($gender=="Male") { echo "selected"; } ?>>Male</option>
                                  <option value="Female" <?php if($gender=="Female") { echo "selected"; } ?>>Female</option>
                              </select>
                          </div>
                        </div>
                    </div>
                    
                    <div class="row mb-2">
                        <div class="col-lg-6">
                          <div class="form-group mb-4">
                            <label for="dateOfBirth">Date Of Birth</label>
                            <input type="date" class="form-control" name="postdateofbirth" value="<?php echo date('Y-m-d',strtotime($date_of_birth)); ?>">
                          </div>
                        </div>

                        <div class="col-lg-6">
                          <div class="form-group mb-4">
                            <label for="maritalStatus">Marital Status</label>
                              <select  class="form-control" name="postmartialstatus">
                                  <option value="">Select Status</option>
                                  <option value="Married"  <?php if($marital_status=="Married") { echo "selected"; } ?>>Married</option>
                                <option value="Unmarried" <?php if($marital_status=="Unmarried") { echo "selected"; } ?>>Unmarried</option>
                              </select>
                          </div>
                        </div>
                    </div> 

                    <div class="row mb-2">
                        <div class="col-lg-6">
                          <div class="form-group">
                            <label for="image">Cover Image</label>
                            <input type="file" class="form-control" >
                          </div>
                        </div>

                        <div class="col-lg-6">
                          <div class="form-group">
                              <label for="address">Address</label>
                              <textarea rows="1" class="form-control" name="postaddress"><?php echo $address; ?></textarea>
                          </div>
                        </div>
                    </div>


                  <div class="card-header">
                    <h2 class="mb-5">Company Information</h2>
                  </div>

                  <div class="row mb-2">
                        <div class="col-lg-6">
                          <div class="form-group mb-4">
                            <label for="dateOfJoin">Date Of Joining</label>
                            <input type="date" class="form-control" name="postdateofjoining" value="<?php echo date('Y-m-d',strtotime($date_of_joining)); ?>">
                          </div>
                        </div>

                        <div class="col-lg-6">
                          <div class="form-group mb-4">
                            <label for="designation">Designation</label>
                            <input type="text" class="form-control" name="postdesignation" value="<?php echo $designation; ?>">
                          </div>
                        </div>
                    </div> 

                    <div class="row mb-2">
                        <div class="col-lg-6">
                          <div class="form-group mb-4">
                            <label for="salary">Current Salary</label>
                            <input type="text" class="form-control" value="<?php echo $salary; ?>" readonly="true">
                          </div>
                        </div>

                        <div class="col-lg-6">
                          <div class="form-group mb-4">
                            <label for="designation">Company Email</label>
                            <input type="email" class="form-control" value="<?php echo $companyEmail; ?>" readonly="true"> 
                          </div>
                        </div>
                    </div> 

                    <div class="col-lg-6">
                      <div class="form-group mb-4">
                        <label for="experience">Experience</label>
                          <select  class="form-control" name="postexperience">
                              <option value="">Select Experience</option>
                              <option value="Fresher"<?php if($ExperienceType=="Fresher") { echo "selected"; } ?>>Fresher</option>
                              <option value="Experience"<?php if($ExperienceType=="Experience") { echo "selected"; } ?>>Experience</option>
                          </select>
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