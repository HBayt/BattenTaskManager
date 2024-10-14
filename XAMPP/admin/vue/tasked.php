<!-- ------------------------------------------------- -->    
<!-- Update time : 03.10.2024  -->  
<!-- Author : H. Baytar  -->  
<!-- Confirmation message when CRUD Operations are executed -->     
<!-- ------------------------------------------------- -->    
<section class="container mt-5">
    <?php
    if (isset($_SESSION['message'])) {
        echo $_SESSION['message'];
        unset($_SESSION['message']); // Efface le message après l'affichage
    }
    ?>
</section>


<section class="container mt-5">

<!-- ------------------------------------------------- -->    
<!-- Page title & Button Create (Insert into db.table ) -->     
<!-- ------------------------------------------------- -->      

<div class="container">
    <h2>Tasks to be performed / Assignments</h2>
    <h3>(<?php echo $numOfTaskeds;  ?> pending tasks)</h3> 
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createTaskedModal" style="float: right;">Create </button>
    <br><br>
    <hr>
</div>

<div class="container alert alert-warning">
    <h3> <strong>Warning, please note!</strong> </h3>
    <p> 
        To assign a task to a user that does not exist (a <strong>new user</strong>), please frist create this user by going to the <strong>Users menu</strong> in the Task Manager application <strong>menu bar</strong> . 
        <br>
        Please note that if you create it from the <strong> MySQL database </strong> you may forget some fields. <br><br>
        <strong>If this happens, the Task Manager system will no longer be able to display the calendar of tasks to be carried out. </strong> 
    </p> 
</div>
<hr>
<br>



<!-- ------------------------------------------------- -->  
<!-- TASKEDS LIST FROM MYSQL DB --> 
<!-- ------------------------------------------------- -->  
<div class="container">
    <table class="table table-hover table-striped">
        <thead>
            <tr>
                <th scope="col">Id (tasked)</th>
                <th scope="col">Task start</th>
                <th scope="col">Weekday</th>           
                <th scope="col">Task (label)</th>
                <th scope="col">Group</th>            
                <th scope="col">Assigned user</th>
                <th scope="col">Email sent?</th>
                <th scope="col"></th>
                <th scope="col"></th>

            </tr>
        </thead>
        <!-- TABLE BODY  -->
        <tbody>
            <?php foreach ( $taskeds as $tasked ) { 
                $task = getTaskName($tasked['task_id']);                 
                
                ?>
        
                <tr>
                    <td><?php  echo $tasked['id']?> </td>   <!-- id (tasked) -->
                    <td> <?php echo (new DateTime($tasked['start']))->format("d.m.Y") ?></td><!-- start date (tasked) -->
                    <td><!-- Weekday (of task)-->
                        <?php 
                            $datas = json_decode($task['weekdays'], TRUE);    
                            // $tasked_start = (new DateTime($tasked['start']));     
                            $tasked_start = date('l', strtotime( $tasked['start'])); 
                            // foreach ($datas as $result) {  if($result == $tasked_start ){ echo $tasked_start."<br>"; }}
                            echo date('l', strtotime( $tasked_start));
                        ?> 
                    </td>
                    <td> <?php                     

                            $task_name = $task["libelle"];
                            echo $task_name ;                        
                        ?> 
                    </td>
                    <!-- 
                        task_done(s) 
                        <td>< ?php echo $tasked['tasked_done']?></td>               
                    -->
                    <td><?php echo $tasked['group_liebelle']?> </td><!-- groupe (task/user)-->

                    <td><?php echo $tasked['user_name']?> </td><!-- title (tasked user)-->

                        <?php 
                        // echo $tasked['contacted']
                        if($tasked['contacted'] == 'YES'){ ?>
                            <td style="color:green;"><strong><?=$tasked['contacted'] ?></strong></td>
                        <?php } else{?>
                                <td style="color:red;"><?=$tasked['contacted']?></td>
                        <?php }?>

                    </td><!-- user and managers contacted -->

                        <!-- FORM  -->
                    <form method="POST">
                
                        <!-- -------------- -->
                        <!-- ACTION UPDATE  -->
                        <!-- -------------- -->
                        <td>
                            <?php require 'partials/modalUpdateTasked.php';?>
                        </td>    

                        <!-- -------------- -->
                        <!-- BUTTON DELETE  -->
                        <!-- -------------- -->
                        <td>
                            <?php require 'partials/modalDeleteTasked.php';?>
                        </td>   
    
                    </form>   
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
</section> 




<!-- -------------------------------------------------- -->    
<!-- CREATE - Modal Button Insert into DB Table (MySQL) -->     
<!-- -------------------------------------------------- -->    
<div class="modal fade" id="createTaskedModal" tabindex="-1" role="dialog" aria-labelledby="CreateModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
		
            <div class="modal-header">
                <h5 class="modal-title fs-4 luckiest" id="exampleModalLabel"><span style="color:blue;">Assign task to user</span></h5>
                <button type="button" class="close fs-4 position-absolute top-0 end-0 m-2" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

			<form method="POST" name="Form_CreateTasked">

				<!-- $_POST['action'] --> 
				<input type="hidden"  name="action"  value="CreateTasked">
				<div class="modal-body">


                    <!-- 
                        INPUT TEXT 
                        JQUERY DATE_PICKER 
                    -->

                    <!-- START DATE -->   
                    <div class="form-group">
                    <h5><span style="color:brown;">Select start date</span></h5>
                        <input type="text" class="form-control" id="start_datePicker" name="start" value="" placeholder="start ..." required><!-- $_POST['start'] -->
                        <br> 
                        <br> 
                    </div>


					<!--USER  -->   
                    <!-- dropdown list to choose a User to be assigned  -->   <!-- $_POST['selected_userId'] -->  
					<div class="form-group">
                        <h5><span style="color:brown;">User to be assign</span></h5>
                        <select name="selected_userId" id="id_selectUser" class="form-control" >
                            <optgroup label="Select an user" class="form-control" >
                                <?php foreach ( $users as $u ){ ?>
                                    <option value="<?php echo $u->id ?>" name="<?php echo $u->id ?>" > <?php echo $u->name ?> </option>
                                <?php }  ?>
                            </optgroup>
                        </select>
						<br>
                        <br> 
					</div>

			
					<!-- TASK  -->    
					<!-- Check list to choose a TASK -->   <!-- $_POST['group'] --> 
					<div class="form-group">
                        <h5><span style="color:brown;">Task to be assign </span></h5>
						<?php foreach ( $tasks as $t ){ ?>
							<div class="form-check">
								<input 
                                    class="form-check-input" 
                                    name="checked_taskId" type="radio" 
                                    id="<?php echo $t->id ?>" 
                                    value="<?php echo $t->id ?>" 
                                    <?php if($t->libelle == "CAFE_ALL"){echo "checked";}  ?>
                                > <!-- end.input -->
								<label class="form-check-label"> 
                                    <?php echo $t->name ?> 
                                    
                                </label>
							</div>
						<?php }  ?>
					</div>
					<br>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Create</button>
				</div>
			</form>
		
		</div>
	</div>
</div>




<!-- Script pour initialiser Flatpickr -->
<script>

$(document).ready(function() { 

    // ____________________________
    // FLATPICK | DATEPICKER 
    // ____________________________
    // dateFormat: "d.m.Y ==>  Format de la date à soumettre
    // inline: true ==> Afficher le calendrier au chargement 
    flatpickr("#start_datePicker", {
        dateFormat: "d.m.Y", 
        weekNumbers: true,  
        allowInput: true // prevent "readonly" prop --> required field 
        
    });

}); 




</script> 