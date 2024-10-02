<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#updateTaskedModal-<?php echo $tasked["id"]; ?>">
    Update
</button>

<!-- ------------------- --> 
<!-- Modal Task / Update --> 
<!-- ------------------- --> 
<div class="modal fade" id="updateTaskedModal-<?php echo $tasked["id"]; ?>" tabindex="-1" role="dialog" aria-labelledby="UpdateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
		
		<!-- Modal header --> 
        <div class="modal-header">
			<!-- Modal window / Title --> 
            <h5 class="modal-title" id="UpdateModalLabel">Update tasked (task/user)</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <!-- --------------------------------------------------- --> 
		<!-- Modal Body/Content & Form --> 
         <!-- --------------------------------------------------- --> 



         <form method="POST" class="task">
            <input type="hidden"  name="action"  value="updateTask">
            <input type="hidden"  name="id"  value="<?php echo $tasked["id"]; ?>">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Title (User name)</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo $tasked["user_name"];  ?>" placeholder="Title">
                    </div>
                    <div class="form-group mt-3">
                        <label>Task name</label>
                        <input type="text" class="form-control color-picker" id="color" name="color" value="<?php echo $task['name']; ?>" placeholder="color">
                        <button class="picker btn btn-primary" height="20px" width="20px"></button>
                    </div>

                    <div class="form-group mt-3">
                        <label>Start day </label>
                        <input type="text" class="form-control color-picker" id="color" name="color" value="<?php echo $tasked['start']; ?>" placeholder="color">
                        <button class="picker btn btn-primary" height="20px" width="20px"></button>
                    </div>                    
                </div>

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