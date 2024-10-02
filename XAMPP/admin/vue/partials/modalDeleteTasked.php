<button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#deleteTaskedModal-<?php echo $tasked['id']?>">
    Delete
</button>

<div class="modal fade" id="deleteTaskedModal-<?php echo $tasked['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="DeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">


            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title fs-4 luckiest" id="DeleteModalLabel"><span style="color:blue;">Are you sure ?</span></h5>
                <button type="button" class="close fs-4 position-absolute top-0 end-0 m-2" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <p>Do you really want to delete this tasked (ID = <?php echo $tasked['id']; ?>)?</p>
            </div>
            <!-- Modal Footer & Form Submission -->
            <form method="POST" action="tasked.php">
                <input type="hidden" name="action" value="deleteTasked">
                <input type="hidden" name="tasked_id" value="<?php echo $tasked['id']; ?>">
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="deleteTasked" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
