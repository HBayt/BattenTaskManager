
    <!-- BUTTON TO CREATE NEW ADDRESSEE-->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createVacationModal">
        Create
    </button>

    <!-- Modal CREATE NEW ADDRESSEE -->
    <div class="modal fade" id="createVacationModal" tabindex="-1" role="dialog" aria-labelledby="id_createReceiver" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">

             <!-- Modal CREATE NEW ADDRESSEE -->
            <h5 class="modal-title" id="id_createReceiver">Create new Addressee</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <!-- FORM CREATE NEW ADDRESSEE -->
        <form method="POST">

            <input type="hidden"  name="action"  value="createAddressee">

            <div class="modal-body">
                 <!-- INPUT NAME OF ADDRESSEE -->
                <div class="form-group">
                    <label>Name </label>
                    <input type="text" class="form-control" id="addr_name" name="addr_name" value="" placeholder="Name">
                </div>
                 <!-- Modal EMAIL OF ADDRESSEE -->
                <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" class="form-control" id="addr_email" name="addr_email" value="" placeholder="Enter email">
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" name="create_addressee">Create</button>
            </div>

        </form>
        </div>
    </div>
    </div>
</div>