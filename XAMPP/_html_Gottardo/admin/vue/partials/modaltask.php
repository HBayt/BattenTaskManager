<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#alter-modal-<?php echo $t->id; ?>">
    Alter
</button>
<div class="modal fade" id="alter-modal-<?php echo $t->id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Modifier</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form method="POST" class="task">
            <input type="hidden"  name="action"  value="updateTask">
            <input type="hidden"  name="id"  value="<?php echo $t->id; ?>">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo $t->name; ?>" placeholder="Title">
                </div>
                <div class="form-group mt-3">
                    <label>Color</label>
                    <input type="text" class="form-control color-picker" id="color" name="color" value="<?php echo $t->color; ?>" placeholder="color">
                    <button class="picker btn btn-primary" height="20px" width="20px"></button>
                </div>
                <div class="form-group mt-3">
                    <label>Weekday</label>
                    <div class="form-check">
                        <input class="form-check-input" name="weekdays[]" type="checkbox" value="Monday" <?php if (in_array('Monday',json_decode($t->weekdays))) { echo 'checked';} ?>>
                        <label class="form-check-label">
                            Monday
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="weekdays[]" type="checkbox" value="Tuesday" <?php if (in_array('Tuesday',json_decode($t->weekdays))) { echo 'checked';} ?>>
                        <label class="form-check-label">
                            Tuesday
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="weekdays[]" type="checkbox" value="Wednesday" <?php if (in_array('Wednesday',json_decode($t->weekdays))) { echo 'checked';} ?>>
                        <label class="form-check-label">
                            Wednesday
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="weekdays[]" type="checkbox" value="Thursday" <?php if (in_array('Thursday',json_decode($t->weekdays))) { echo 'checked';} ?>>
                        <label class="form-check-label">
                            Thursday
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="weekdays[]" type="checkbox" value="Friday" <?php if (in_array('Friday',json_decode($t->weekdays))) { echo 'checked';} ?>>
                        <label class="form-check-label">
                            Friday
                        </label>
                    </div>
                </div>
                <div class="form-group mt-3">
                <label>Group</label>
                <?php foreach ( $group as $g ){ ?>
                    <div class="form-check">
                        <input class="form-check-input" name="idGroup[]" type="checkbox" value="<?php echo $g->id ?>" id="flexCheckDefault"  <?php if (checkRelation($g, $t->sharedGroup)) { echo 'checked';}  ?>>
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