
<!-- Modal -->
<button type="button" class="btn btn-primary" data-toggle="modal"  name="update_vacation" 
    data-target="#updateModal-<?php echo $vacation['id']?>">
    Update
</button>

<!-- MODAL WINDOW (POP-UP) -->
<div class="modal fade" id="updateModal-<?php echo $vacation['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">

                <!--FORM.H5 - POP-UP TITLE -->
                <h5 class="modal-title fs-3 luckiest" id="exampleModalLabel">Update vacation</h5>
                <br>

                <!--FORM.BUTTON (CLOSE POP-UP) -->
                <button type="button" class="close fs-3 position-absolute top-0 end-0 m-2" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>


            <!-- FORM -->
            <form method="POST">
                
                <div class="modal-body">
                    <!--FORM.INPUT (VACATION ID) -->
                    <input type="hidden" id="id_vacation" name="id_vacation" value="<?php echo$vacation['id']?>">

                    <!-- 
                        INPUT TEXT 
                        JQUERY DATE_PICKER 
                    -->

                    <!--FORM.INPUT (VACATION START) -->
                    <div class="form-group">

                        <?php 
                            $vac_start = new DateTime($vacation['start']); 
                        ?>

                        <label for="start"><h4>Start date </h4></label>
                        <input 
                            type="text" 
                            class="form-control" 
                            id="dpicker_updatestart-<?php echo $vacation['id'] ?>" 
                            name="start"
                            value="<?php echo $vac_start->format("d.m.Y") ?>"
                            placeholder="Start date" required>
                    </div>
                </div>
                <br>

                <!--FORM.INPUT (VACATION END ) -->
                <div class="modal-body">
                    <div class="form-group">
                        <label for="end"><h4>End date </h4></label>
                        <input 
                            type="text" 
                            class="form-control" 
                            id="dpicker_updateend-<?php echo $vacation['id'] ?>" 
                            name="end"
                            value="<?php echo (new DateTime($vacation['end']))->format("d.m.Y") ?>"
                            placeholder="End date" required>
                    </div>
                </div>
                <br>


                <!--FORM.INPUT (VACATION User email ) -->
                <div class="modal-body">
                    <div class="form-group">
                        <label for="email"><h4>User email</h4></label>
                        <output type="text" class="form-control" id="email" name="email"
                            value="<?php echo$vacation['email'] ?>"
                            placeholder="email"> <?php echo$vacation['email'] ?></output>

                        <input type="hidden" id="user_id" name="user_id" value="<?php echo$vacation['user_id']?>">
                    </div>
                </div>
                <br>


                <!-- BUTTONS (Close / Save changes) -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="save_changes" class="btn btn-primary">Save changes</button>
                </div>
            </form> <!-- END .FORM -->

        </div>
    </div>
</div>




<?php 
// var_dump($vacation['id'] ) 
// var_dump($vacation['start'] ) 
// var_dump($vacation['end'] ) 
// var_dump($vacation['name'] ) 
// var_dump($vacation['email'] ) 
// var_dump($vacation['user_id'] ) 

?>


<script> 
    $(document).ready(function() { 

        // ____________________________
        // SAMPLE | UPDATE  setdate:'today'
        // ____________________________
        // $(function() { $("#start_datePicker").datepicker({ inline: true, dateFormat: 'dd/mm/yy', "setDate","21.09.24"}); }); 


        $('input[id^="dpicker_updatestart"]').each(function() {
            const id = $(this).attr('id').split('-')[1]; // Récupère l'ID de vacation

            $("#dpicker_updatestart-" + id).datepicker({dateFormat: 'dd.mm.yy'}); 
            $("#dpicker_updateend-" + id).datepicker({dateFormat: 'dd.mm.yy'}); 

            $('#dpicker_updatestart-' + id).change(function() { 
                let startDate = $(this).datepicker('getDate'); 
                $("#dpicker_updateend-" + id).datepicker("option", "minDate", startDate); 
            });

            $('#dpicker_updateend-' + id).change(function() { 
                let endDate = $(this).datepicker('getDate'); 
                $("#dpicker_updatestart-" + id).datepicker("option", "maxDate", endDate); 
            });
        });
    }); 
</script> 


