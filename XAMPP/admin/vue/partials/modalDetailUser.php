<!-- ------------------------------------------------- -->    
<!-- CRUD SELECT (DETAILS) BUTTON -->     
<!-- ------------------------------------------------- -->   
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-details-<?php echo $u->id ?>">
    Details
</button>

<!-- ------------------------------------------------- -->    
<!-- CRUD SELECT (DETAILS) MODAL WINDOW -->     
<!-- ------------------------------------------------- -->  
<div class="modal fade" id="modal-details-<?php echo $u->id ?>" tabindex="-1" role="dialog" aria-labelledby="ModalDetailsUser" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

        <div class="form-group">
            <table class="table">
                <tbody>
                    <tr>
                        <td>  <h2 class="modal-title" id="ModalDetailsUser"> Details<br><?php echo $u->name?></h2></td>
                        <td> 
                            <button type="button" class="close fs-3 position-absolute top-0 end-0 m-2" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

 
        <!-- ------------------------------------------------- -->    
        <!-- $_POST['id_group'] --> 
        <!-- Check list to display the group -->      
        <!-- ------------------------------------------------- -->           
        <div class="modal-body">
            <h2>Group</h2>
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Id</th>
                </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>  <?php  $group = loadGroup($u->group_id); echo $group->name;  ?> </td>
                        <td> <?php echo $group->id; ?> </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- ------------------------------------------------- -->    
        <!-- VACATIONS -->     
        <!-- ------------------------------------------------- -->  
        <div class="modal-body">
                <!-- $_POST['id'] --> 
                <input type="hidden" id="id" name="id" value="<?php echo $u->id ?>">
                <!-- $_POST['user_group'] --> 
                <input type="hidden" id="id" name="user_group" value="<?php echo $u->group_id ?>">
                <!-- $_POST['action'] --> 
                <input type="hidden"  name="action"  value="detailsUser">
            <?php if ( count($u->ownVacationList ) > 0 ) { ?>            
                <h2>Vacation</h2>
                <table class="table">
                <thead>
                <tr>
                    <th scope="col">Start</th>
                    <th scope="col">End</th>
                </tr>
                </thead>
                <tbody>
                    <?php foreach ( $u->ownVacationList as $vacation ) { ?>
                        <tr>
                            <td>
                                <?php echo (new DateTime($vacation->start))->format("d.m.y") ?>
                            </td>
                            <td>
                                <?php echo (new DateTime($vacation->end))->format("d.m.y") ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
                </table>
            <?php } ?>
        </div>

        <!-- ------------------------------------------------- -->    
        <!-- TASKS -->     
        <!-- ------------------------------------------------- -->  
        <div class="modal-body">    
            <?php if ( count($u->ownTaskedList ) > 0 ) { ?>        
                <h2>Task</h2>
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Date</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php foreach ( $u->ownTaskedList as $tasked ) { ?>
                            <tr>
                                <td>
                                    <?php echo $tasked->task->name ?>
                                </td>
                                <td>
                                    <?php echo (new DateTime($tasked->start))->format("l d.m.y") ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php } ?>
        </div>

        <!-- ------------------------------------------------- -->    
        <!-- BUTTON CLOSE -->     
        <!-- ------------------------------------------------- -->  
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>

    </div>
  </div>
</div>


