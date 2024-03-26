
<?php
$pageName = "Profile";

include("../include/header.php");
?>


<style>
  .btn {
    background-color: rgb(9, 175, 244);
    border-color: transparent;
  }

  .btn:hover {
    background-color: rgb(9, 175, 244);
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
                <a class="nav-link" href="../profile/index.php">
                  <i class="mdi mdi-account-outline mr-1"></i> Personal
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="../profile/eduction.php">
                  <i class="mdi mdi-school mr-1"></i> Education
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" href="../profile/document.php">
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
            <h2 class="mb-5">Bank Details</h2>
          </div>
          <div class="card-body">
            <form>
              <div class="col-lg-12">
                <div class="form-group">
                  <label for="bankPassbook">Bank Passbook</label>
                  <input type="file" class="form-control">
                </div>
              </div>
              <div class="card-header">
                <h2 class="mb-5">Document Details</h2>
              </div>
              <div class="row mb-2">
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="aadharcard">Aadhar Card</label>
                    <input type="file" class="form-control">
                  </div>
                </div>

                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="pancard">Pan Card</label>
                    <input type="file" class="form-control">
                  </div>
                </div>
              </div>
              <div class="row mb-2">
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="voterid">Voter Id</label>
                    <input type="file" class="form-control">
                  </div>
                </div>

                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="drivinglicence">Driving Licence</label>
                    <input type="file" class="form-control">
                  </div>
                </div>
              </div>

              <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary mb-2 btn-pill">Update Profile</button>
              </div>

            </form>
          </div>
        </div>

        <!-- <div class="card card-default">

                  <div class="card-header">
                    <h2>Social Networks</h2>

                  </div>

                  <div class="card-body">
                    <div class="media media-sm">
                      <div class="media-body">
                        <div class="row">

                          <div class="col-lg-6">

                            <div class="d-flex mb-5">
                              <button type="button" class="btn btn-icon facebook mr-2">
                                <i class="mdi mdi-facebook"></i>
                              </button>
                              <input type="text" class="form-control" placeholder="Facebook username">
                            </div>

                            <div class="d-flex mb-5">
                              <button type="button" class="btn btn-icon google-plus mr-2">
                                <i class="mdi mdi-google-plus"></i>
                              </button>
                              <input type="text" class="form-control" placeholder="Google plus username">
                            </div>

                            <div class="d-flex mb-5">
                              <button type="button" class="btn btn-icon vimeo mr-2">
                                <i class="mdi mdi-vimeo"></i>
                              </button>
                              <input type="text" class="form-control" placeholder="Vimeo username">
                            </div>

                          </div>

                          <div class="col-lg-6">

                            <div class="d-flex mb-5">
                              <button type="button" class="btn btn-icon twitter mr-2">
                                <i class="mdi mdi-twitter"></i>
                              </button>
                              <input type="text" class="form-control" placeholder="Twitter username">
                            </div>

                            <div class="d-flex mb-5">
                              <button type="button" class="btn btn-icon linkedin mr-2">
                                <i class="mdi mdi-linkedin"></i>
                              </button>
                              <input type="text" class="form-control" placeholder="Linkedin username">
                            </div>

                            <div class="d-flex mb-5">
                              <button type="button" class="btn btn-icon pinterest mr-2">
                                <i class="mdi mdi-pinterest"></i>
                              </button>
                              <input type="text" class="form-control" placeholder="Pinterest username">
                            </div>


                          </div>
                        </div>
                      </div>
                    </div>

                  </div>
                </div> -->



      </div>

    </div>
  </div>
</div>

<?php
include("../include/footer.php");
?>