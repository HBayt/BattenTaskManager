<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-groups-<?php echo $u->id ?>">
    Groupes
</button>

<!-- Modal -->
<div class="modal fade" id="modal-groups-<?php echo $u->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Groupes</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST">
        <div class="modal-body">
            <input type="hidden" id="id" name="idUser" value="<?php echo $u->id ?>">
            <input type="hidden" name="action" value="addUserToGroup">
            <?php foreach ( $group as $g ){ ?>
              <div class="form-check">
                <input class="form-check-input" name="idGroup" type="radio" value="<?php echo $g->id ?>" id="flexCheckDefault" <?php if($g->id == $u->group_id) { echo "checked";} ?>>
                <label class="form-check-label" for="flexCheckDefault">
                  <?php echo $g->name ?>
                </label>
              </div>
            <?php }  ?>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

