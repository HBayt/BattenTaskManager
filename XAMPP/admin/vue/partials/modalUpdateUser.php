<!-- ------------------------------------------------- -->    
<!-- CRUD UPDATE BUTTON -->     
<!-- ------------------------------------------------- -->   
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#updateModal-<?php echo $u->id ?>">
    Update
</button>

<!-- ------------------------------------------------- -->    
<!-- CRUD UPDATE MODAL WINDOW -->     
<!-- ------------------------------------------------- -->   
<div class="modal fade" id="updateModal-<?php echo $u->id ?>" tabindex="-1" role="dialog" aria-labelledby="ModalUpdateUser" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">



      <div class="modal-header">
        <h5 class="modal-title fs-3 luckiest" id="ModalUpdateUser"><span style="color:blue;">Update user<br><?php echo $u->name?></span></h5>
        <button type="button" class="close fs-3 position-absolute top-0 end-0 m-2" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <br>


      <form method="POST">
        <div class="modal-body">

            <!-- $_POST['id'] --> 
            <input type="hidden" id="id" name="id" value="<?php echo $u->id ?>">
             <!-- $_POST['action'] --> 
            <input type="hidden"  name="action"  value="alterUser">

             <!-- $_POST['name'] --> 
            <div class="form-group">
                <label><h5><span style="color:brown;">Firstname & lastname</span></h5></label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $u->name ?>" placeholder="Enter name" required>
                </br>
            </div>
            

             <!-- $_POST['email'] --> 
            <div class="form-group">
                <label><h5><span style="color:brown;">Email address</span></h5></label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $u->email ?>" placeholder="Enter email" required>
                </br>
            </div>



            <!-- $_POST['weekdays'] --> 
            <div class="form-group mt-3">
                <label><h5><span style="color:brown;">Weekdays</span></h5></label>
                <div class="form-check">
                    <input class="form-check-input" name="weekdays[]" type="checkbox" value="Monday" <?php if (json_decode($u->weekdays) && in_array('Monday',json_decode($u->weekdays))) { echo 'checked';} ?>>
                    <label class="form-check-label">
                        Monday
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="weekdays[]" type="checkbox" value="Tuesday" <?php if (json_decode($u->weekdays) && in_array('Tuesday',json_decode($u->weekdays))) { echo 'checked';} ?>>
                    <label class="form-check-label">
                        Tuesday
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="weekdays[]" type="checkbox" value="Wednesday" <?php if (json_decode($u->weekdays) && in_array('Wednesday',json_decode($u->weekdays))) { echo 'checked';} ?>>
                    <label class="form-check-label">
                        Wednesday
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="weekdays[]" type="checkbox" value="Thursday" <?php if (json_decode($u->weekdays) && in_array('Thursday',json_decode($u->weekdays))) { echo 'checked';} ?>>
                    <label class="form-check-label">
                        Thursday
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="weekdays[]" type="checkbox" value="Friday" <?php if (json_decode($u->weekdays) && in_array('Friday',json_decode($u->weekdays))) { echo 'checked';} ?>>
                    <label class="form-check-label">
                        Friday
                    </label>
                </div>   
                <div class="form-check">
                    <input class="form-check-input" name="weekdays[]" type="checkbox" value="UNKNOWN" <?php if (json_decode($u->weekdays) && in_array('UNKNOWN',json_decode($u->weekdays))) { echo 'checked';} ?>>
                    <label class="form-check-label">
                        UNKNOWN 
                    </label>
                </div>                         
            </div>
            </br>



            <!-- $_POST['id_group'] --> 
            <!-- Check list to choose a group -->   

            <div class="form-group">
                <label><h5><span style="color:brown;">Assigned group </span></h5></label>
                <?php foreach ( $groups as $g ){ ?>
                    <div class="form-check">
                        <input 
                            class="form-check-input" 
                            name="id_group" type="radio"  
                            id="<?php echo $g->id ?>"                            
                            value="<?php echo $g->id ?>" 
                            <?php if (isset( $g->id) &&  $g->id==$u->group_id) echo "checked";?>  >

                        <label class="form-check-label">
                            <?php echo $g->name ?>
                        </label>
                    </div>
                <?php }  ?>
            </div>
            </br>


        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

