<div class="container mt-5">
  <table class="table">
        <thead>
            <tr>
            <th scope="col">Name</th>
            <th scope="col"></th>
            <th scope="col"></th>
            </tr>
        </thead>
        <?php foreach( $group as $g ) {?>
            <tr>
            <td><?php echo $g->name ?></td>
            <td>
            <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#deleteModal<?php echo $g->id ?>">
                Delete
            </button>

            <!-- Modal -->
            <div class="modal fade" id="deleteModal<?php echo $g->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                <input type="hidden"  name="id" value="<?php echo $g->id ?>">
                                <input type="hidden"  name="method"  value="DELETE">
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
            </td>
            <td><a href="/admin/user.php?group_id=<?php echo $g->id ?>"><button type="button" class="btn btn-primary">Add User</button></a></td>
            </tr>
            
        <?php } ?>
    </table>

    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createModal">
        Create
    </button>

    <!-- Modal -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create a group</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label>libelé</label>
                        <input type="text" class="form-control" id="name" name="name" value="" placeholder="Name">
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
</div>