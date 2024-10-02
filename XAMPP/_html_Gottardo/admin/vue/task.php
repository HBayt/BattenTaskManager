<div class="container mt-5">
    <table class="table">
            <thead>
                <tr>
                <th scope="col">Name</th>
                <th scope="col"></th>
                <th scope="col"></th>
                <th scope="col"></th>
                <th scope="col"></th>
                </tr>
            </thead>
            <?php foreach( $task as $t ) {?>
                <tr>
                <td><?php echo $t->name ?></td>
                <td></td>
                <td><?php include 'partials/modaltask.php'; ?></td>
                <td>
                    <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#deleteModal<?php echo $t->id ?>">
                        Delete
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="deleteModal<?php echo $t->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Are you sure ?</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form method="POST">
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <form method="POST">
                                        <input type="hidden"  name="id" value="<?php echo $t->id ?>">
                                        <input type="hidden"  name="action"  value="deleteTask">
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </div>
                            </form>
                            </div>
                        </div>
                    </div>
                </td>
                </tr>
    
            <?php } ?> 
    </table>
    <button type="button" class="btn btn-primary  mt-3 mb-5" data-toggle="modal" data-target="#createModal">
        Create
    </button>
    <form action="/admin/generateTasks.php" method="POST">
        <h3>Generate task</h3>
        <div class="form-group mt-3">
            <label>From</label>
            <input type="date"  class="form-control" name="from" value="<?php echo (new DateTime)->format('Y-m-d'); ?>">
        </div>

        <button type="submit" class="btn btn-primary mt-3">Generate task</button>
    </form>
    <!-- Modal -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Create</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form method="POST" class="task">
            <input type="hidden"  name="action"  value="createTask">
            <div class="modal-body">
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" class="form-control" id="name" name="name" value="" placeholder="Title">
                </div>
                <div class="form-group">
                    <label>Color</label>
                    <input type="text" class="form-control" id="color" name="color" value="" placeholder="color">
                    <button class="picker btn btn-primary" height="20px" width="20px"></button>
                </div>
                <div class="form-group mt-3">
                <label>Weekdays</label>
                    <div class="form-check">
                        <input class="form-check-input" name="weekdays[]" type="checkbox" value="Monday">
                        <label class="form-check-label">
                            Monday
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="weekdays[]" type="checkbox" value="Tuesday">
                        <label class="form-check-label">
                            Tuesday
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="weekdays[]" type="checkbox" value="Wednesday">
                        <label class="form-check-label">
                            Wednesday
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="weekdays[]" type="checkbox" value="Thursday">
                        <label class="form-check-label">
                            Thursday
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="weekdays[]" type="checkbox" value="Friday">
                        <label class="form-check-label">
                            Friday
                        </label>
                    </div>
                </div>
                <div class="form-group mt-3">
                <label>Group</label>
                <?php foreach ( $group as $g ){ ?>
                    <div class="form-check">
                        <input class="form-check-input" name="idGroup[]" type="checkbox" value="<?php echo $g->id ?>" id="flexCheckDefault">
                        <label class="form-check-label">
                            <?php echo $g->name ?>
                        </label>
                    </div>
                <?php }  ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Create</button>
            </div>
        </form>
        </div>
    </div>
</div>