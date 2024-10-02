<?php 
// Définir le code HTML comme une chaîne de caractères
$infoMessage = <<<HTML
<div class="container">
    <div class="container alert alert-info">
        <h5><strong>Warning, please note!</strong></h5>
        <p> 
            To generate the <strong> task assignment (task/user)</strong>  
            <ol>
                <li>Choose a date by clicking on the <strong>black field input</strong> above, i.e. the calendar field.</li>
                <li>Click on the <strong>Generate button</strong>. </li>
                <li><strong>Wait</strong> for the Taskmanager system to generate the tasks.  </li>
                <li>
                    <strong>Check</strong> the result by going to 
                    <ul>
                        <li>To the <strong>calendar</strong> page <a class="link-offset-1" href="http://localhost/admin/callendar.php">http://localhost/admin/callendar.php</a>.</li>
                        <li>Go to the list of <strong>generated tasks</strong> page <a class="link-offset-1" href="http://localhost/admin/tasked.php">http://localhost/admin/tasked.php</a>.</li>
                    </ul> 
                </li>
            </ol> 
        </p> 
        <p> To manage <strong> Tasks</strong> , i.e. to create a new task, to delete / to update an existing task , go to the task list <strong> below</strong>.</p> 
    </div>
</div>
HTML;
?> 

<section class="container mt-5">

<!-- ------------------------------------------------- -->    
<!-- Task generator (generate form given day to 3 months -->     
<!-- ------------------------------------------------- -->    
<div class="container">
<!-- <form action="/admin/generateTasks.php" method="POST">  -->  
<form action="/admin/generateTasks.php" method="POST">
    <table class="table">
        <tr> 
            <td><h1>Generate taskeds </h1> </td> 
            <td> <button type="submit" class="btn btn-primary mt-3" style="float: right;">Generate</button> </td> 
        </tr>

        <tr> 
            <td colspan="2">            
                <?php $currentDateTime = new DateTime(); ?>                 
                <!--FORM.INPUT (GENERATE TASKED FORM TODAY ) -->

                <div class="card mb-1 mt-3 text-bg-light p-3" style="max-width: 180rem;">

                    <div class="card-header"> 
                        <label for="start"><h4>From (tasks start date) </h4></label> <!-- $_POST['datePicker_start'] -->   
                        <h6> Select a start date from the calendar below by clicking on the black field. </h6>
                    </div>

                    <!-- CALENDAR INPUT (TYPE TEXT)-->
                    <div class="card-body ">
                        <p class="card-text ">
                            <input 
                                type="text" 
                                class="form-control text-bg-dark" 
                                id="from" 
                                name="from" 
                                value="<?php echo ($currentDateTime)->format("d.m.Y") ?>"
                                placeholder="Start date" required></p>
                    </div> 
                    <!-- STEP MESSAGE -->
                    <?php echo $infoMessage ?> 
                </div>
            </td>
        </tr>
    </table>
</form> 
</div>

<!-- ------------------------------------------------- -->    
<!-- Page title & Button Create (Insert into db.table ) -->     
<!-- ------------------------------------------------- -->      
<div class="container">
    <table class="table">
        <tr> 
            <td>
                <h1><?php echo $numOfTasks;  ?> tasks to perform</h1>   
            </td>
            <td>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createTaskModal" style="float: right;">Add new</button> 
            </td>
        </tr>
    </table>
</div>
<!-- ------------------------------------------------- -->    
<!-- Task list from MySQL DB  -->     
<!-- ------------------------------------------------- -->    
<div class="container mt-5">
    <table class="table">
            <thead>
                <tr>
                <!-- <th scope="col">Label</th> -->   
                <th scope="col">Name</th>
                <th scope="col">Weekdays</th> 
                <th scope="col">Group(s)</th>
                <th scope="col"></th>
                <th scope="col"></th>
                </tr>
            </thead>

            <?php foreach( $task as $t ) {?>
                <tr>
                    <!-- Color finder : https://www.w3schools.com/colors/colors_picker.asp 
                    <td>< ?php echo $t->color ?></td>                     
                    -->   

                    <!-- <td>< ?php echo $t->libelle ?></td> -->   
                    <td><?php echo $t->name ?></td>
                    <td>
                        <?php 
                            $datas = json_decode($t['weekdays'], TRUE);    
                            $datas = is_array($datas) ? $datas : array($datas);       
                            // print_r( $datas ); echo "<br>"; 
                            // foreach ( $array ?? [] as $item ) {
                            foreach ($datas as $result) { echo $result."<br>"; }
                        ?> 
                    </td>
                    <td> 
                        <?php  
                            // Groups attributed to task 
                            foreach ( $group as $g ){ if (checkRelation($g, $t->sharedGroup)) { echo $g->name.'<br>';}  }
                        ?>
                    </td>
                    <td><?php include 'partials/modalUpdateTask.php';?></td>
                    <td> 
                        <!-- ---------------------- -->   
                        <!-- BUTTTON MODAL 'Delete' -->
                        <!-- ---------------------- -->   
                        <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#deleteModal<?php echo $t->id ?>">
                            Delete
                        </button>

                        <!-- ------------------------------------------------------------- -->    
                        <!-- Modal window to delete a  task (db MySQL)   -->     
                        <!-- ------------------------------------------------------------- -->    
                        <div class="modal fade" id="deleteModal<?php echo $t->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">


                                    <div class="modal-header">
                                        <h5 class="modal-title fs-4 luckiest" id="exampleModalLabel"><span style="color:blue;">Are you sure ?</span></h5>
                                        <button type="button" class="close fs-4 position-absolute top-0 end-0 m-2" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <form method="POST">
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <form method="POST">
                                                <input type="hidden"  name="id" value="<?php echo $t->id ?>">
                                                <input type="hidden"  name="action"  value="deleteTask">
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
    
            <?php } ?> 
    </table>

    <!-- ------------------------------------------------------------- -->    
    <!-- Modal window to create a new task (to insert into db MySQL) -->     
    <!-- ------------------------------------------------------------- -->    
    <div class="modal fade" id="createTaskModal" tabindex="-1" role="dialog" aria-labelledby="CreateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">

        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title fs-4 luckiest" id="exampleModalLabel"><span style="color:blue;">New Task</span></h5>
                <button type="button" class="close fs-4 position-absolute top-0 end-0 m-2" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>


            <!-- Form POST for creating new task -->     
            <form method="POST" class="task">
                <input type="hidden"  name="action"  value="createTask">
                <div class="modal-body">
                <div class="form-group">
                            <label><h5><span style="color:brown;">Title</span></h5></label>
                            <input type="text" class="form-control" id="name" name="name" value="" placeholder="Title">
                            <br>
                        </div>
                <div class="form-group">
                    <label><h5><span style="color:brown;">Task label / UID </span></h5></label>
                    <input type="text" class="form-control" id="label" name="label" value="" placeholder="Label / UID" required>
                </div>                
                <br>
                <div class="form-group">
                    <label><h5><span style="color:brown;">Color</span></h5></label>
                    <input type="text" class="form-control" id="color" name="color" value="" placeholder="color" required>
                    <button class="picker btn btn-primary" height="20px" width="20px"></button>
                </div>
                <br>
                <!-- Check list for working days -->     
                <div class="form-group mt-3">
                <label><h5><span style="color:brown;">Weekdays</span></h5></label>
                    <div class="form-check">
                        <input class="form-check-input" name="weekdays[]" type="checkbox" value="Monday" checked>
                        <label class="form-check-label">
                            Monday
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="weekdays[]" type="checkbox" value="Tuesday">
                        <label class="form-check-label">
                            Tuesday
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="weekdays[]" type="checkbox" value="Wednesday">
                        <label class="form-check-label">
                            Wednesday
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="weekdays[]" type="checkbox" value="Thursday">
                        <label class="form-check-label">
                            Thursday
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="weekdays[]" type="checkbox" value="Friday">
                        <label class="form-check-label">
                            Friday
                        </label>
                    </div>
                </div>
    
                <!-- Check list to choose a group -->   
                <div class="form-group mt-3">
                    <label><h5><span style="color:brown;">Group</span></h5></label>
                    <?php foreach ( $group as $g ){ ?>
                        <div class="form-check">
                            <input class="form-check-input" name="idGroup[]" type="checkbox" value="<?php echo $g->id ?>" id="flexCheckDefault"
                            <?php if (isset( $g->id) &&  $g->name=="NOT ASSIGNED GROUP") echo "checked";?>
                            >
                            <label class="form-check-label" >
                                <?php  echo $g->name ?>
                            </label>
                        </div>
                    <?php }  ?>
                </div>

                </div>

                <!-- From Modal / Button Close and Button Create  -->     
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
            </form>
        </div>

    </div>
</div>
</div>


<!-- Script pour initialiser Flatpickr -->
<script>

$(document).ready(function() { 

    // ____________________________
    // FLATPICK | DATEPICKER 
    // ____________________________
    // flatpickr("#datepicker", {dateFormat: "d.m.Y",  inline: true });  // inline: true === Afficher le calendrier au chargement 
    flatpickr("#from", {dateFormat: "d.m.Y", weekNumbers: true});

}) 
</script> 