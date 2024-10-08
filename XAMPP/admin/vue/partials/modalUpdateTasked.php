<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#updateTaskedModal-<?php echo $tasked["id"]; ?>">
    Update
</button>

 <!-- -------------------------------------------------- -->    
<!-- UPDATE - Modal Button UPDATE TABLE ROW (MySQL) -->     
<!-- -------------------------------------------------- -->  
<div class="modal fade" id="updateTaskedModal-<?php echo $tasked["id"]; ?>" tabindex="-1" role="dialog" aria-labelledby="UpdateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
		
            <!-- Modal header --> 
            <div class="modal-header">
                <h5 class="modal-title fs-4 luckiest" id="UpdateModalLabel"><span style="color:blue;">Update tasked (task/user)</span></h5>
                <button type="button" class="close fs-4 position-absolute top-0 end-0 m-2" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Modal Body/Content & Form --> 
            <form method="POST" class="task">
                <input type="hidden"  name="action"  value="updateTasked">
                <input type="hidden"  name="id"  value="<?php echo $tasked["id"]; ?>">
                
                <div class="modal-body">


                    <!-- Datepicker Input with Unique ID -->
                    <div class="form-group">
                        <label for="start"><h5><span style="color:brown;">Selected start date</span></h5></label>
                        <input type="text" class="form-control" id="datePicker_start_<?php echo $tasked['id']; ?>" name="datePicker_start" 
                               value="<?php echo (new DateTime($tasked['start']))->format("d.m.Y") ?>"
                               placeholder="Start date" required>
                        <br>
                        <br>                              
                    </div>

                    <!-- User Dropdown -->
                    <div class="form-group">
                        <label for="selected_userId"><h5><span style="color:brown;">Assigned user</span></h5></label>
                        <select name="selected_userId" class="form-control">
                            <optgroup label="Select an user">
                                <?php foreach ($users as $u) { ?>
                                    <option value="<?php echo $u->id ?>" <?php echo $u->name == $tasked["user_name"] ? "selected" : ""; ?>>
                                        <?php echo $u->name ?>
                                    </option>
                                <?php } ?>
                            </optgroup>
                        </select>
                        <br>
                        <br>                              
                    </div>

                    <!-- Task Dropdown -->
                    <div class="form-group">
                        <label for="selected_taskId"><h5><span style="color:brown;">Task to be assigne</span></h5></label>
                        <select name="selected_taskId" class="form-control">
                            <optgroup label="Select a task">
                                <?php foreach ($tasks as $t) { ?>
                                    <option value="<?php echo $t->id ?>" <?php echo $t->name == $task['name'] ? "selected" : ""; ?>>
                                        <?php echo $t->name ?>
                                    </option>
                                <?php } ?>
                            </optgroup>
                        </select>
                        <br>
                        <br>                              
                    </div>


                    <!-- Radio Buttons -->
                    <div class="form-group">
                        <label for="contacted"><h5><span style="color:brown;">Contacted (via email)?</span></h5></label>
                        <br>
                        <input type="radio" name="radio_contacted" value="NO" <?php echo $tasked["contacted"] == 'NO' ? "checked" : ""; ?>> NO  
                        <br>
                        <input type="radio" name="radio_contacted" value="YES" <?php echo $tasked["contacted"] == 'YES' ? "checked" : ""; ?>> YES
                        <br>
                        <br>                              
                    </div>
                    
                    

                    
                    <br>
                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="UpdateTasked" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- jQuery Script -->
<script>
$(document).ready(function() {
    // Initialiser le Datepicker pour chaque élément avec un ID unique
    $('.modal').on('shown.bs.modal', function() {
        var taskId = $(this).attr('id').split('-')[1];
        flatpickr("#datePicker_start_" + taskId, {dateFormat: "d.m.Y", weekNumbers: true});
    });
});
</script>



<!-- Script pour initialiser Flatpickr -->
