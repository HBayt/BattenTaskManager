<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-details-<?php echo $u->id ?>">
    Details
</button>

<!-- Modal POP_UP -->
<div class="modal fade" id="modal-details-<?php echo $u->id ?>" tabindex="-1" role="dialog" aria-labelledby="ModalDetailsUser" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalDetailsUser"> User details 
            <?php 
                if(!empty($u->name)){
                    echo "(".$u->name.")"; 
                }  
            ?>
            </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <div class="modal-body">

            <!-- ------------------------------------------- -->
        <!-- User Weekdays  -->
        <!-- ------------------------------------------- -->
        <h2>Weekdays</h2>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">Weekday</th>
            </tr>
            </thead>
            <tbody>
                <!-- weekdays (of task)-->
                <?php 
                    (array) $user_weekdays = (array) $u->weekdays; 
                    if(is_array($user_weekdays) && count($user_weekdays) != 0){
                        $datas = json_decode($u->weekdays, TRUE); 
                        foreach ($datas as $result){ ?>
                            <tr> <td> <?php echo $result."<br>"; ?></td></tr>                        
                <?php }} else{ ?>
                            <tr><td> <?php echo "NULL <br>"?> </td></tr> 
                <?php  } ?>
            </tbody>
        </table>
        <br><br>

        <!-- ------------------------------------------- -->
        <!-- User vacations  -->
        <!-- ------------------------------------------- -->
        <h2>Vacations</h2>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">Start</th>
                <th scope="col">End</th>
            </tr>
            </thead>
            <tbody>
                <?php 
                    (array) $user_vacations = (array) $u->ownVacationList; 
                    if(is_array($user_vacations) && count($user_vacations) != 0){
                        foreach ( $user_vacations as $vacation ) { 
                ?>
                        <tr>
                            <td>
                                <?php echo (new DateTime($vacation->start))->format("d.m.y") ?>
                            </td>
                            <td>
                                <?php echo (new DateTime($vacation->end))->format("d.m.y") ?>
                            </td>
                        </tr>                        
                <?php 
                        }
                    } else{ ?>
        
                        <tr>
                            <td> <?php echo "NULL <br>"?> </td>
                            <td> <?php echo "NULL <br>"?> </td>
                        </tr> 
                    <?php 
                        } ?>
            </tbody>
        </table>
        <br><br>
        <!-- ------------------------------------------- -->
        <!-- User Tasks (taskeds) -->
        <!-- ------------------------------------------- -->
        <h2>Assigned tasks</h2>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Date</th>
            </tr>
            </thead>
            <tbody>


                <?php 
                    (array) $user_taskeds = (array) $u->ownTaskedList; 
                    if(is_array($user_taskeds) && count($user_taskeds) != 0){

                        foreach (  $user_taskeds as $tasked  ) { ?>
                            <tr>
                                <td>
                                    <?php echo $tasked->task->name?>
                                </td>
                                <td>
                                    <?php echo (new DateTime($tasked->start))->format("l d.m.y") ?>
                                </td>
                            </tr>                        
                            <?php 
                        }
                    } else{ ?>
        
                        <tr>
                            <td> <?php echo "NULL <br>"?> </td>
                            <td> <?php echo "NULL <br>"?> </td>
                        </tr> 
                    <?php 
                        } ?>
            </tbody>
        </table>       
        <br><br>

    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    </div>
    </div>
  </div>
</div>


