<?php
$pageName = "Projects";
include("../include/header.php");
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'http://localhost:8080/getprojectsbyempid/'.$_SESSION['employeeId'],
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
));

$response = curl_exec($curl);
$resultArray = json_decode($response, true);
curl_close($curl);

?>
<style>
  .calendar {
  background-color: white;
  border-radius: 10px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  z-index: 1;
  margin-top: 20px;
  display: none;
}
.header {
  background-color: #3498db;
  color: white;
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 10px;
  border-top-left-radius: 10px;
  border-top-right-radius: 10px;
}
.progress-bar{
  background-color: #09aff4;
}
#prevBtn,
#nextBtn {
  background: none;
  border: none;
  color: white;
  cursor: pointer;
  font-size: 16px;
}

#monthYear {
  font-size: 18px;
  font-weight: bold;
}

.days {
  display: grid;
  grid-template-columns: repeat(7, 1fr);
  gap: 5px;
  padding: 10px;
}

.day {
  padding: 10px;
  text-align: center;
  border-radius: 5px;
  cursor: pointer;
}

.day.current {
  background-color: #3498db;
  color: white;
}

.day.selected {
  background-color: #2ecc71;
  color: white;
}

#dateInput {
  width: 100%;
  padding: 10px;
  /* border: 1px solid #ccc; */
  /* border-radius: 5px; */
  font-size: 14px;
  outline: none;
  cursor: pointer;
}

.btn-down{
  color: white;
  background: #09aff4;
  text-transform: capitalize;
  text-align: left;
  padding: 8px 20px;
  border-radius: 6px;
  margin-top: 10px;
}
.btn-down:hover{
  color: white;
}

.p{
  color: black;
}

</style>
<div class="content-wrapper">
  <div class="content">
    <div class="row">
      <?php
      foreach($resultArray['data'] as $project)
      {

        $process = (100/$project['projectDetails']['totalTasks']);
        $fProcess = round($process * $project['projectDetails']['completedTasks']);
      ?>
    <div class="col-lg-6 col-xl-4 col-xxl-3">
        <div class="card card-default mt-7">
          <div class="card-body text-center">
            <a class="d-block mb-2" href="javascript:void(0)" data-toggle="modal" data-target="#modal-contact">
              <h5 class="card-title"><?php echo ucwords($project['projectDetails']['ProjectName']); ?> </h5>
            </a>
            <div class="progress">
              <div class="progress-bar" role="progressbar" style="width: <?php echo $fProcess; ?>%;" aria-valuenow="25" aria-valuemin="0"
                aria-valuemax="100"><?php echo $fProcess; ?>%
              </div>
            </div>
            <!-- <div class="mt-2 calendar-box">
              <input type="text" id="dateInput" placeholder="Select Due date">
              <div class="calendar" id="calendar">
                <div class="header">
                  <button id="prevBtn">&lt;</button>
                  <h2 id="monthYear">Month Year</h2>
                  <button id="nextBtn">&gt;</button>
                </div>
                <div class="days" id="daysContainer"></div>
              </div>
            </div> -->
            <div class="mt-2 download">
              <span class="p">Start Date :</span>
              <span class="p"><?php echo date("d-m-Y", strtotime($project['projectDetails']['startDate']));  ?></span>
            </div>
            <div class="mt-2 download">
              <span class="p" style="color:red;">Due Date :</span>
              <span class="p" style="color:red;font-weight: bold;font-size:20px"><?php echo date("d-m-Y", strtotime($project['projectDetails']['endDate']));  ?></span>
            </div>
            <div class="mt-2 download">
              <span class="p">Tasks : <?php echo $project['projectDetails']['completedTasks']; ?>/</span>
              <span class="p"><?php echo $project['projectDetails']['totalTasks']; ?></span>
            </div>
            <div class="mt-2 download">
              <!-- <button class="btn-down">Show Document</button>  -->
              <a href="../images/elements/cc1.jpg" target="_blank" class="btn-down">Show Document</a>
            </div>
          </div>
        </div>
      </div>
     <?php
      }
     ?>
    </div>

    <!-- Contact Modal -->
    <!-- <div class="modal fade" id="modal-contact" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
      aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header justify-content-end border-bottom-0">
            <button type="button" class="btn-edit-icon" data-dismiss="modal" aria-label="Close">
              <i class="mdi mdi-pencil"></i>
            </button>

            <div class="dropdown">
              <button class="btn-dots-icon" type="button" id="dropdownMenuButton" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="mdi mdi-dots-vertical"></i>
              </button>

              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="javascript:void(0)">Action</a>
                <a class="dropdown-item" href="javascript:void(0)">Another action</a>
                <a class="dropdown-item" href="javascript:void(0)">Something else here</a>
              </div>
            </div>

            <button type="button" class="btn-close-icon" data-dismiss="modal" aria-label="Close">
              <i class="mdi mdi-close"></i>
            </button>
          </div>

          <div class="modal-body pt-0">
            <div class="row no-gutters">
              <div class="col-md-6">
                <div class="profile-content-left px-4">
                  <div class="card text-center px-0 border-0">
                    <div class="card-img mx-auto">
                      <img class="rounded-circle" src="images/user/u6.jpg" alt="user image">
                    </div>

                    <div class="card-body">
                      <h4 class="py-2">Albrecht Straub</h4>
                      <p>Albrecht.straub@gmail.com</p>
                      <a class="btn btn-primary btn-pill btn-lg my-4" href="javascript:void(0)">Follow</a>
                    </div>
                  </div>

                  <div class="d-flex justify-content-between ">
                    <div class="text-center pb-4">
                      <h6 class="pb-2">1503</h6>
                      <p>Friends</p>
                    </div>

                    <div class="text-center pb-4">
                      <h6 class="pb-2">2905</h6>
                      <p>Followers</p>
                    </div>

                    <div class="text-center pb-4">
                      <h6 class="pb-2">1200</h6>
                      <p>Following</p>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="contact-info px-4">
                  <h4 class="mb-1">Contact Details</h4>
                  <p class="text-dark font-weight-medium pt-4 mb-2">Email address</p>
                  <p>Albrecht.straub@gmail.com</p>
                  <p class="text-dark font-weight-medium pt-4 mb-2">Phone Number</p>
                  <p>+99 9539 2641 31</p>
                  <p class="text-dark font-weight-medium pt-4 mb-2">Birthday</p>
                  <p>Nov 15, 1990</p>
                  <p class="text-dark font-weight-medium pt-4 mb-2">Event</p>
                  <p>Lorem, ipsum dolor</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div> -->
  </div>

</div>


<script>const daysContainer = document.getElementById("daysContainer");
const prevBtn = document.getElementById("prevBtn");
const nextBtn = document.getElementById("nextBtn");
const monthYear = document.getElementById("monthYear");
const dateInput = document.getElementById("dateInput");
const calendar = document.getElementById("calendar");

let currentDate = new Date();
let selectedDate = null;

function handleDayClick(day) {
  selectedDate = new Date(
    currentDate.getFullYear(),
    currentDate.getMonth(),
    day
  );
  dateInput.value = selectedDate.toLocaleDateString("en-US");
  calendar.style.display = "none";
  renderCalendar();
}

function createDayElement(day) {
  const date = new Date(currentDate.getFullYear(), currentDate.getMonth(), day);
  const dayElement = document.createElement("div");
  dayElement.classList.add("day");

  if (date.toDateString() === new Date().toDateString()) {
    dayElement.classList.add("current");
  }
  if (selectedDate && date.toDateString() === selectedDate.toDateString()) {
    dayElement.classList.add("selected");
  }

  dayElement.textContent = day;
  dayElement.addEventListener("click", () => {
    handleDayClick(day);
  });
  daysContainer.appendChild(dayElement);
}

function renderCalendar() {
  daysContainer.innerHTML = "";
  const firstDay = new Date(
    currentDate.getFullYear(),
    currentDate.getMonth(),
    1
  );
  const lastDay = new Date(
    currentDate.getFullYear(),
    currentDate.getMonth() + 1,
    0
  );

  monthYear.textContent = `${currentDate.toLocaleString("default", {
    month: "long"
  })} ${currentDate.getFullYear()}`;

  for (let day = 1; day <= lastDay.getDate(); day++) {
    createDayElement(day);
  }
}

prevBtn.addEventListener("click", () => {
  currentDate.setMonth(currentDate.getMonth() - 1);
  renderCalendar();
});

nextBtn.addEventListener("click", () => {
  currentDate.setMonth(currentDate.getMonth() + 1);
  renderCalendar();
});

dateInput.addEventListener("click", () => {
  calendar.style.display = "block";
  positionCalendar();
});

document.addEventListener("click", (event) => {
  if (!dateInput.contains(event.target) && !calendar.contains(event.target)) {
    calendar.style.display = "none";
  }
});

function positionCalendar() {
  const inputRect = dateInput.getBoundingClientRect();
  calendar.style.top = inputRect.bottom + "px";
  calendar.style.left = inputRect.left + "px";
}

window.addEventListener("resize", positionCalendar);

renderCalendar();
</script>

<?php
include("../include/footer.php");
?>