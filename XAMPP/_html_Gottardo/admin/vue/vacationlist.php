<section class="container mt-5">

<div class="container">
<h2>Vacations
    <?php 
        if(isset($_GET['user_name'])){
            echo " - ".  $_GET['user_name']; 
        } 
    ?>
</h2>

    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createModal" style="float: right;">Create </button>
    <br><br>
    <hr>
    <br>
</div>

    <!-- TABLE VACATION  -->
    <table class="table">
         <!-- TABLE HEADE  -->
        <thead>
            <tr>
                <th scope="col">id (vacation)</th>
                <th scope="col">start (vacation)</th>
                <th scope="col">end (vacation)</th>
                <th scope="col">email (user)</th>
                <th scope="col">name (user) </th>
                <th scope="col"></th>
                <th scope="col"></th>

            </tr>
        </thead>
         <!-- TABLE BODY  -->
        <tbody>

            <?php foreach ( $vacations as $vacation ) { ?>
                <tr>
                <td> <?php  echo $vacation['id']?> </td>
                    <td> <?php echo (new DateTime($vacation['start']))->format("d.m.Y") ?></td>
                    <td> <?php echo (new DateTime($vacation['end']))->format("d.m.Y") ?> </td>
                    <td> <?php echo $vacation['email']  ?></td>
                    <td> <?php echo $vacation['name'] ?> </td>



                     <!-- FORM  -->
                    <form method="POST">
                        <!-- -------------- -->
                        <!-- BUTTON DELETE  -->
                         <!-- -------------- -->
                        <td>
                            <input type="hidden"  name="id_vacation"  value="<?php echo $vacation['id']?>">
                            <input type="hidden"  name="id_email"  value="<?php echo $vacation['email']?>">
                            <button type="submit" class="btn btn-secondary" value="delete_vacation" name="delete_vacation">Delete</button></td>

                        <!-- -------------- -->
                        <!-- ACTION UPDATE  -->
                         <!-- -------------- -->
                        <td><?php require 'partials/modalUpdateVacation.php';?></td>              
                    </form>    
                </tr>
            <?php } ?>
        </tbody>
    </table>


    <!-- Modal-CREATE -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New vacation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>start</label>
                            <input type="date" class="form-control" id="start" name="start" value="" placeholder="start ...">
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>end</label>
                            <input type="date" class="form-control" id="end" name="end" value="" placeholder="end ...">
                        </div>
                    </div> 


                    <div class="modal-body">
                        <div class="form-group">
                            <label>User email</label>
							<?php if ( isset($_GET['user_id'])) { ?>
									<output 
										type="text" 
										class="form-control" 
										id="mail" 
										name="mail"
										value="<?php echo$vacation['email'] ?>"
										placeholder="email"
									> 
										<?php echo $vacation['email'] ?>
									</output>

							<?php } else{?>
								<input type="text" class="form-control" id="mail" name="mail" value="" placeholder="user email ...">								
							<?php }?>
                        </div>
                    </div> 

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit"  name="create_vacation" class="btn btn-primary">Create</button>
                    </div>   


                </form>
            </div>
        </div>
    </div> <!-- End .Modal-Create -->








    
</section>