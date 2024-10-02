<section class="container mt-5">
    <h2>Admin</h2>
    <table class="table">
        <thead>
            <tr>
            <th scope="col">Username</th>
            <th scope="col"></th>
            </tr>
        </thead>
        <?php foreach( $admin as $a ) {?>
            <tr>
            <td><?php echo $a->name ?></td>
            <td>
                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#deleteModal<?php echo $a->id ?>">
                    Delete
                </button>

                <!-- Modal -->
                <div class="modal fade" id="deleteModal<?php echo $a->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                    <input type="hidden"  name="id_admin" value="<?php echo $a->id ?>">
                                    <button type="submit" class="btn btn-danger">DELETE</button>
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
    <div class="align-middle">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createModal">
        Create
    </button>

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
                <form method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" class="form-control" id="name" name="name" value="" placeholder="Name">
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" id="name" name="password" value="" placeholder="Password">
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
</section>