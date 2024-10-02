<!-- ---------------------------------------------------------------------------- -->
<!-- BUTTON TO OPEN MODAL WINDOW FOR UPDATE AN ADDRESSEE -->
<!-- ---------------------------------------------------------------------------- -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#updateAddresseeModal-<?php echo $recipient->id ?>">
    Update
</button>

<!-- ---------------------------------------------------------------------------- -->
<!-- Modal window -->
<!-- ---------------------------------------------------------------------------- -->
<div class="modal fade" id="updateAddresseeModal-<?php echo $recipient->id ?>" tabindex="-1" role="dialog" aria-labelledby="ModalUpdateAddressee" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <!-- --------------------- -->
      <!-- Window HEAD           -->
      <!-- --------------------- -->
      <div class="modal-header">

        <!--FORM.H5 - POP-UP TITLE -->
        <h5 class="modal-title fs-3 luckiest" id="ModalUpdateAddressee"><span style="color:blue;">Update recipient</span></h5>
        <br>
        <br>

        <!--FORM.BUTTON (CLOSE POP-UP) -->
        <button type="button" class="close fs-3 position-absolute top-0 end-0 m-2" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>

      </div>

  <!-- --------------------- -->
  <!-- HTML FORM (HTTP POST) -->
  <!-- --------------------- -->
  <form method="POST">
      <div class="modal-body" style="text-align: left;">

          <input type="hidden" id="id_addressee" name="id_addressee" value="<?php echo $recipient->id ?>">
          <input type="hidden"  name="action"  value="update_addressee">
          <br>

          <div class="form-group">
              <label  for="addr_name"><h5><span style="color:brown;">Name of beneficiary / recipient</span></h5></label> 
              <input type="text" class="form-control" id="addr_name" name="addr_name" value="<?php echo $recipient->name ?>" placeholder="Enter name">
              <br>
          </div>

          <div class="form-group">
              <label  for="addr_email"><h5><span style="color:brown;">Email address of beneficiary / recipient</span></h5></label> 
              <input type="email" class="form-control" id="addr_email" name="addr_email" value="<?php echo $recipient->email ?>" placeholder="Enter email">
              <br>
          </div>

      </div>

      <br>
      <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" name="update_addressee">Save changes</button>
      </div>
  </form>
    </div>
  </div>
</div>




