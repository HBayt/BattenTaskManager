<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#updateAddresseeModal-<?php echo $recipient->id ?>">
    Update
</button>

<!-- ------------ -->
<!-- Modal window -->
 <!-- ------------ -->
<div class="modal fade" id="updateAddresseeModal-<?php echo $recipient->id ?>" tabindex="-1" role="dialog" aria-labelledby="ModalUpdateAddressee" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalUpdateAddressee">Update recipient</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

        <!-- --------------------- -->
        <!-- HTML FORM (HTTP POST) -->
        <!-- --------------------- -->
        <form method="POST">
            <div class="modal-body">
                <input type="hidden" id="id_addressee" name="id_addressee" value="<?php echo $recipient->id ?>">
                <input type="hidden"  name="action"  value="update_addressee">
                <div class="form-group">
                    <label>Name (Recipient, Addressee)</label>
                    <input type="text" class="form-control" id="addr_name" name="addr_name" value="<?php echo $recipient->name ?>" placeholder="Enter name">
                </div>
                
                <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" class="form-control" id="addr_email" name="addr_email" value="<?php echo $recipient->email ?>" placeholder="Enter email">
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" name="update_addressee">Save changes</button>
            </div>
        </form>
    </div>
  </div>
</div>

