<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#updateTaskModal-<?php echo $t->id; ?>">
    Update
</button>

<!-- ------------------- --> 
<!-- Modal Task / Update --> 
<!-- ------------------- --> 
<div class="modal fade" id="updateTaskModal-<?php echo $t->id; ?>" tabindex="-1" role="dialog" aria-labelledby="UpdateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">

        <div class="modal-content">
		


            <!-- --------------------- -->
            <!-- MODAL HEADER          -->
            <!-- --------------------- -->
            <div class="modal-header">

                <!--FORM.H1 - POP-UP TITLE -->
                <h5 class="modal-title fs-4 luckiest" id="ModalUpdateAddressee"><span style="color:blue;">Update Task</span></h5>
                <br>

                <!--FORM.BUTTON (CLOSE POP-UP) -->
                <button type="button" class="close fs-4 position-absolute top-0 end-0 m-2" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>



            <!-- --------------------------------------------------- --> 
            <!-- Modal Body/Content & Form --> 
            <!-- --------------------------------------------------- --> 
            <form method="POST" class="task">
                <input type="hidden"  name="action"  value="updateTask">
                <input type="hidden"  name="id"  value="<?php echo $t->id?>">

                <div class="modal-body" >

                    <div class="modal-body">
                        <div class="form-group">
                            <label><h5><span style="color:brown;">Title</span></h5></label>
                            <input type="text" class="form-control" id="name" name="name" value="<?php echo $t->name?>" placeholder="Title">
                            <br>
                        </div>

                        <div class="form-group">
                            <label><h5><span style="color:brown;">Label / UID </span></h5></label>
                            <input type="text" class="form-control" id="label" name="label" value="<?php echo $t->libelle?>" placeholder="Label / UID">
                            <br>
                        </div>

                        <div class="form-group mt-3">
                            <label><h4>Color</h4></label>
                            <label><h5><span style="color:brown;">Color</span></h5></label>
                            <input type="text" class="form-control color-picker" id="color" name="color" value="<?php echo $t->color?>" placeholder="color">
                            <button class="picker btn btn-primary" height="20px" width="20px"></button>
                            <br>
                        </div>
                        <br>
                        <!-- ----------------- --> 
                        <!-- Checkbox Weekdays --> 
                        <!-- ----------------- --> 
                        <div class="form-group mt-3">
                            <label><h5><span style="color:brown;">Weekday</span></h5></label>
                            <div class="form-check">
                                <input class="form-check-input" name="weekdays[]" type="checkbox" value="Monday" <?php if (in_array('Monday',json_decode($t->weekdays))) { echo 'checked';} ?>>
                                <label class="form-check-label">
                                    Monday
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" name="weekdays[]" type="checkbox" value="Tuesday" <?php if (in_array('Tuesday',json_decode($t->weekdays))) { echo 'checked';} ?>>
                                <label class="form-check-label">
                                    Tuesday
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" name="weekdays[]" type="checkbox" value="Wednesday" <?php if (in_array('Wednesday',json_decode($t->weekdays))) { echo 'checked';} ?>>
                                <label class="form-check-label">
                                    Wednesday
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" name="weekdays[]" type="checkbox" value="Thursday" <?php if (in_array('Thursday',json_decode($t->weekdays))) { echo 'checked';} ?>>
                                <label class="form-check-label">
                                    Thursday
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" name="weekdays[]" type="checkbox" value="Friday" <?php if (in_array('Friday',json_decode($t->weekdays))) { echo 'checked';} ?>>
                                <label class="form-check-label">
                                    Friday
                                </label>
                            </div>
                            <br>
                        </div>
                    <!-- ----------------- --> 
                    <!-- Checkbox Groups   --> 
                    <!-- ----------------- --> 
                    <div class="form-group mt-3">
                        <label><h5><span style="color:brown;">Group</span></h5></label>
                        <!-- < ?php echo "<br>"?> print_r($t->sharedGroup); // if (checkRelation($g, $t->sharedGroup)) { echo 'checked';}  --> 

                        <?php  foreach ( $group as $g ){    ?>                       
        
                            <div class="form-check">
                                <input 
                                    class="form-check-input" 
                                    name="idGroup[]" 
                                    type="checkbox" 
                                    value="<?php echo $g->id ?>" 
                                    id="flexCheckDefault"  
                                    <?php if (checkRelation($g, $t->sharedGroup)) { echo 'checked';} ?> >
                                <label class="form-check-label"><?php echo $g->name?></label>
                            </div>
                        <?php } ?>
                    </div>

                </div><!-- End.div class="modal-body" --> 


                <!-- Modal footer --> 
                <div class="modal-footer">
                    <!-- Buttons Close / Update --> 
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>

            </form><!-- end./Form --> 

        </div>
    </div>
</div>