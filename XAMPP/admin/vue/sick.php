<!--  ------------------------------- --> 
<!--  Change affected user for a task --> 
<!--  ------------------------------- --> 
<section class="container mt-5">

<div class="container">
    <!-- ------------------------------------------------- -->    
    <!-- Page title & Button Create (Insert into db.table ) -->     
    <!-- ------------------------------------------------- -->      
    <h2>Change user for the task</h2>
    <h3>(<?php echo $numOfUsers;  ?> users found)</h3> 

    <!--  Button to change random the task user --> 
        <form method="POST">
            <input type="hidden" name="tasked_id" value="<?php echo $_GET['tasked_id'] ?>">
            <input class="btn btn-primary" type="submit" value="Change for random user" style="float: right;"/>
        </form>    

    <br><br>
    <hr>
</div>


<div class="container alert alert-warning">
    <h5> <strong>Warning, please note!</strong> </h5>   
    <p> 
        Changing / Updating an assignment, i.e. replacing one user with another, automatically  <strong>triggers an e-mail</strong> 
        to the new user responsible for executing the selected task, 
        and to those responsible for monitoring the execution of the selected task.  
    </p> 
</div>
<hr>
<br>

	
	<!-- Table HTML --> 
    <table class="table">
	
        <thead>
            <tr>
            <th scope="col">First and lastname</th>
            <th scope="col"></th>
            </tr>
        </thead>
		
		<!--  Display User --> 
        <?php foreach( $user as $u ) {?>
            <tr>
            <td><?php echo $u->name ?></td>
            <td><form method="POST">
                <input type="hidden"  name="id_user" value="<?php echo $u->id ?>">
                <button type="submit" class="btn btn-secondary">Choose </button>
            </form></td>
            </tr>

        <?php } ?><!-- end .foreach() LOOP --> 
    </table>
	
	




</section>