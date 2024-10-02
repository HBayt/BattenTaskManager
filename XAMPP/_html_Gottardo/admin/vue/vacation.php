<section class="container mt-5">
    <h2>Vacation - <?php echo $_GET['user_name'] ?></h2>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">start</th>
                <th scope="col">end</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ( $vacations as $vacation ) { ?>
                <tr>
                    <td>
                        <?php echo (new DateTime($vacation->start))->format("d.m.y") ?>
                    </td>
                    <td>
                        <?php echo (new DateTime($vacation->end))->format("d.m.y") ?>
                    </td>
                    <td>
                        <form method="POST">
                            <input type="hidden" value="<?php echo $vacation->id ?>" name="id"/>
                            <input type="submit" class="btn btn-danger" value="Delete" />
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
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
                            <label>start</label>
                            <input type="date" class="form-control" id="start" name="start" value="" placeholder="start ...">
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>end</label>
                            <input type="date" class="form-control" id="end" name="end" value="" placeholder="end ...">
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
</section>