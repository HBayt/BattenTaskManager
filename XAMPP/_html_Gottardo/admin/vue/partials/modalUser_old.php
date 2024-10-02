<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#updateModal-<?php echo $u->id ?>">
    Update
</button>

<!-- Modal -->
<div class="modal fade" id="updateModal-<?php echo $u->id ?>" tabindex="-1" role="dialog" aria-labelledby="ModalCreateUser" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalCreateUser">Update user</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST">
        <div class="modal-body">
            <input type="hidden" id="id" name="id" value="<?php echo $u->id ?>">
            <input type="hidden"  name="action"  value="alterUser">
            <div class="form-group">
                <label>Firstname and lastname</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $u->name ?>" placeholder="Enter email">
            </div>
            
            <div class="form-group">
                <label for="exampleInputEmail1">Email address</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $u->email ?>" placeholder="Enter email">
            </div>

            <div class="form-group mt-3">
                <label>Weekday</label>
                <div class="form-check">
                    <input class="form-check-input" name="weekdays[]" type="checkbox" value="Monday" <?php if (json_decode($u->weekdays) && in_array('Monday',json_decode($u->weekdays))) { echo 'checked';} ?>>
                    <label class="form-check-label">
                        Monday
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="weekdays[]" type="checkbox" value="Tuesday" <?php if (json_decode($u->weekdays) && in_array('Tuesday',json_decode($u->weekdays))) { echo 'checked';} ?>>
                    <label class="form-check-label">
                        Tuesday
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="weekdays[]" type="checkbox" value="Wednesday" <?php if (json_decode($u->weekdays) && in_array('Wednesday',json_decode($u->weekdays))) { echo 'checked';} ?>>
                    <label class="form-check-label">
                        Wednesday
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="weekdays[]" type="checkbox" value="Thursday" <?php if (json_decode($u->weekdays) && in_array('Thursday',json_decode($u->weekdays))) { echo 'checked';} ?>>
                    <label class="form-check-label">
                        Thursday
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="weekdays[]" type="checkbox" value="Friday" <?php if (json_decode($u->weekdays) && in_array('Friday',json_decode($u->weekdays))) { echo 'checked';} ?>>
                    <label class="form-check-label">
                        Friday
                    </label>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

