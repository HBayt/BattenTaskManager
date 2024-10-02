<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-details-<?php echo $u->id ?>">
    details
</button>

<!-- Modal -->
<div class="modal fade" id="modal-details-<?php echo $u->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Groupes</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <div class="modal-body">
        <h2>Vacation</h2>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">start</th>
                <th scope="col">end</th>
            </tr>
            </thead>
            <tbody>
                <?php foreach ( $u->ownVacationList as $vacation ) { ?>
                    <tr>
                        <td>
                            <?php echo (new DateTime($vacation->start))->format("d.m.y") ?>
                        </td>
                        <td>
                            <?php echo (new DateTime($vacation->end))->format("d.m.y") ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <h2>Task</h2>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Date</th>
            </tr>
            </thead>
            <tbody>
                <?php foreach ( $u->ownTaskedList as $tasked ) { ?>
                    <tr>
                        <td>
                            <?php echo $tasked->task->name ?>
                        </td>
                        <td>
                            <?php echo (new DateTime($tasked->start))->format("l d.m.y") ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    </div>
    </div>
  </div>
</div>


