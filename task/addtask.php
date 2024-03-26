<?php
$pageName = "Task";

include("../include/header.php");
?>
<div class="content-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-xl-3">
            </div>
            <div class="col-xl-6">
                <div class="card card-default">
                    <div class="card-header">
                        <h2>Add Leave</h2>
                    </div>
                    <div class="card-body">
                        <form action="index.php">
                            <div class="form-group">
                                <label for="exampleFormControlSelect14">Project Name</label>
                                <select class="form-control rounded-0" id="exampleFormControlSelect14">
                                    <option>Select Section</option>
                                    <option>ERP panal</option>
                                    <option>Emolyoee panal</option>
                                    <option>Jagdish Farsan</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlSelect14">Section</label>
                                <select class="form-control rounded-0" id="exampleFormControlSelect14">
                                    <option>Select Section</option>
                                    <option>In Process</option>
                                    <option>Pending</option>
                                    <option>Done</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlInput44">Task</label>
                                <input type="text" class="form-control rounded-0" placeholder="Enter Task Name">
                            </div>

                            <div class="form-footer">
                                <button type="submit" class="btn btn-success btn-pill">Submit</button>
                                <button type="submit" class="btn btn-light btn-pill">Cancel</button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    include("../include/footer.php");
    ?>