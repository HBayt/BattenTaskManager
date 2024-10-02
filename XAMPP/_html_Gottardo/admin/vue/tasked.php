<section class="container mt-5">

<?php  
    // var_dump($taskeds) ; 
?> 



<!-- ------------------------------------------------- -->    
<!-- Page title & Button Create (Insert into db.table ) -->     
<!-- ------------------------------------------------- -->      
<div class="container">
    <h2>Tasks to be performed / Assignments</h2>

    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createTaskedModal" style="float: right;">Create </button>
    <br><br>
    <hr>
    <br>

</div>



<!-- ------------------------------------------------- -->  
<!-- TASKEDS LIST FROM MYSQL DB --> 
<!-- ------------------------------------------------- -->  
<table class="table">
    <thead>
        <tr>
            <th scope="col">Id (tasked)</th>
            <th scope="col">Task start</th>
            <th scope="col">Task name</th>
            <th scope="col">Task weekdays</th>
            <th scope="col">Assigned user</th>
            <th scope="col">Contacted (?)</th>
            <th scope="col">Group</th>
            <th scope="col"></th>

        </tr>
    </thead>
        <!-- TABLE BODY  -->
    <tbody>
        <?php foreach ( $taskeds as $tasked ) { ?>
            <tr>
                <td><?php  echo $tasked['id']?> </td>   <!-- id (tasked) -->
                <td> <?php echo (new DateTime($tasked['start']))->format("d.m.Y") ?></td><!-- start date (tasked) -->
                <td> <?php                     
                        $task = getTaskName($tasked['task_id']); 
                        $task_name = $task["libelle"];
                        echo $task_name ;                        
                     ?> 
            </td>
            <td><!-- weekdays (of task)-->
                <?php 
                    $datas = json_decode($task['weekdays'], TRUE);        
                    foreach ($datas as $result) { echo $result."<br>"; }
                ?> 
            </td>
                <td><?php echo $tasked['user_name']?> </td><!-- title (tasked user)-->
                <td><?php echo $tasked['contacted']?> </td><!-- user and managers contacted -->

                <!-- 
                    task_done(s) 
                    <td>< ?php echo $tasked['tasked_done']?></td>               
                -->
                <td><?php echo $tasked['group_liebelle']?> </td><!-- groupe (task/user)-->

                    <!-- FORM  -->
                <form method="POST">
                    <!-- -------------- -->
                    <!-- BUTTON DELETE  -->
                    <!-- -------------- -->
                    <td>
                        <input type="hidden"  name="id_tasked"  value="<?php echo $tasked['id']?>">
                        <button type="submit" class="btn btn-secondary" value="delete_tasked" name="delete_tasked">Delete</button>
                    </td>           
                </form>    
            </tr>
        <?php } ?>
    </tbody>
    </table>
   
</section> 






<!-- -------------------------------------------------- -->    
<!-- CREATE - Modal Button Insert into DB Table (MySQL) -->     
<!-- -------------------------------------------------- -->    
<div class="modal fade" id="createTaskedModal" tabindex="-1" role="dialog" aria-labelledby="CreateModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
		
			<div class="modal-header">

				<h1 class="modal-title" id="CreateModalLabel">Assign task to user</h1>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				    <span aria-hidden="true">&times;</span>
				</button>

			</div>

			<form method="POST">

				<!-- $_POST['action'] --> 
				<input type="hidden"  name="action"  value="CreateTasked">
				<div class="modal-body">

					<!-- START DATE -->    
                    <div class="form-group">
                        <label><h4>Select start date</h4></label>
                        <input type="date" class="form-control" id="start" name="start" value="" placeholder="start ..."><!-- $_POST['start'] --> 
                        <br> 
                        <br> 
                    </div>

					<!--USER  -->   
                    <!-- dropdown list to choose a User to be assigned  -->   <!-- $_POST['selected_userId'] -->  
					<div class="form-group">
						<label><h4>User to be assign</h4></label>
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
						<label><h4>Task to be assign </h4></label>
						<?php foreach ( $tasks as $t ){ ?>
							<div class="form-check">
								<input class="form-check-input" name="checked_taskId" type="radio" id="<?php echo $t->id ?>" value="<?php echo $t->id ?>" >
								<label class="form-check-label"> <?php echo $t->name ?> </label>
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
