
    <!-- BUTTON TO CREATE NEW ADDRESSEE-->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createVacationModal">
        Create
    </button>

    <!-- Modal CREATE NEW ADDRESSEE -->
    <div class="modal fade" id="createVacationModal" tabindex="-1" role="dialog" aria-labelledby="id_createReceiver" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">


            <!-- --------------------- -->
            <!-- MODAL HEADER          -->
            <!-- --------------------- -->
            <div class="modal-header">

                <!--FORM.H1 - POP-UP TITLE -->
                <h1 class="modal-title fs-3 luckiest" id="ModalUpdateAddressee">Create new Addressee</h1>
                <br>

                <!--FORM.BUTTON (CLOSE POP-UP) -->
                <button type="button" class="close fs-3 position-absolute top-0 end-0 m-2" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>

            <!-- FORM CREATE NEW ADDRESSEE -->
            <form method="POST">
                <div class="modal-body" style="text-align: left;">

                    <input type="hidden"  name="action"  value="createAddressee">
                    <br>

                    <!-- INPUT NAME OF ADDRESSEE -->
                    <div class="form-group">
                        <label  for="addr_name"><h4>Name (Recipient, Addressee)</h4></label>
                        <input type="text" class="form-control" id="addr_name" name="addr_name" value="" placeholder="Name">
                        <br>
                    </div>

                    <!-- Modal EMAIL OF ADDRESSEE -->
                    <div class="form-group">
                        <label for="addr_email"><h4>Email address</h4></label>
                        <input type="email" class="form-control" id="addr_email" name="addr_email" value="" placeholder="Enter email">
                        <br>
                    </div>
                </div>

                <br> 
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="create_addressee">Create</button>
                </div>

            </form>
        </div>
    </div>
    </div>
</div>