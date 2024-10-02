
<?php 
// Définir le code HTML comme une chaîne de caractères
$infoMessage = <<<HTML
<div class="container">
    <div class="container alert alert-info">
        <h3><strong>Warning, please note!</strong></h3>

        <ol> 
            <li> 
                <strong>Please, take care when inserting a new vacation or updating an existing vacation.</strong><br>
                <ul>
                    <li>The <strong> start date</strong> , you selected becomes the minimum date in the calendar. 
                    All dates below the selected date could be <strong> deactivated</strong> .</li>
                    <li>The <strong> end date</strong> , you selected  becomes the maximum selectable date in the displayed calendar . 
                    All dates above the selected date could be <strong> deactivated</strong> .</li>
                </ul>                
            </li> 
            <li> 
                <strong>To display a calender for start/end date, just click on the wanted input.</strong><br>
            </li> 
        </ul> 



    </div>
</div>
HTML;


?> 



<section class="container mt-5">

    <!-- ------------------------------------------------- -->    
    <!-- Page title & Button Create (Insert into db.table ) -->     
    <!-- ------------------------------------------------- -->      
    <div class="container">
        <table style="width:100%">
        <tr>
            <td> 
            <h2>Vacations
                <?php 
                    if(isset($_GET['user_name'])){
                        echo " - ".  $_GET['user_name']; 
                        echo "<h3>".$numOfUserVacations." vacation(s) found </h3>" ; 
                    }elseif(isset($numOfVacations) && $numOfVacations >= 1){
                        echo "<h3>".$numOfVacations." vacation(s) found </h3>" ; 
                    }
                ?>
            </h2>

            </td>
            <td>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createModal" style="float: right;">Create </button>
            </td>
            <td></td>
        </tr>
        </table> 
        <br>
        <hr>
    </div>
        <?php echo $infoMessage ?> 


    <!-- -------------- -------------- -------------- -->
    <!-- TABLE VACATION  -->
    <!-- -------------- -------------- -------------- -->
    <table class="table">
         <!-- TABLE HEADE  -->
        <thead>
            <tr>
                <th scope="col">id (vacation)</th>
                <th scope="col">start (vacation)</th>
                <th scope="col">end (vacation)</th>
                <th scope="col">email (user)</th>
                <th scope="col">name (user) </th>
                <th scope="col"></th>
                <th scope="col"></th>

            </tr>
        </thead>
         <!-- TABLE BODY  -->
        <tbody>

            <?php foreach ( $vacations as $vacation ) { ?>
                <tr>
                <td> <?php  echo $vacation['id']?> </td>
                    <td> <?php echo (new DateTime($vacation['start']))->format("d.m.Y") ?></td>
                    <td> <?php echo (new DateTime($vacation['end']))->format("d.m.Y") ?> </td>
                    <td> <?php echo $vacation['email']  ?></td>
                    <td> <?php echo $vacation['name'] ?> </td>



                     <!-- FORM  -->
                    <form method="POST">
                        <!-- -------------- -->
                        <!-- BUTTON DELETE  -->
                         <!-- -------------- -->
                        <td>
                            <input type="hidden"  name="id_vacation"  value="<?php echo $vacation['id']?>">
                            <input type="hidden"  name="id_email"  value="<?php echo $vacation['email']?>">
                            <button type="submit" class="btn btn-secondary" value="delete_vacation" name="delete_vacation">Delete</button></td>

                        <!-- -------------- -->
                        <!-- ACTION UPDATE  -->
                         <!-- -------------- -->
                        <td><?php require 'partials/modalUpdateVacation.php';?></td>              
                    </form>    
                </tr>
            <?php } ?>
        </tbody>
    </table>


    <!-- -------------- -------------- -------------- -->
    <!-- Modal-CREATE -->
    <!-- -------------- -------------- -------------- -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">

            <div class="modal-content">

            <div class="modal-header">
                <!--FORM.H5 - POP-UP TITLE -->
                <h5 class="modal-title fs-3 luckiest" id="exampleModalLabel">New vacation</h5>
                <br>

                <!--FORM.BUTTON (CLOSE POP-UP) -->
                <button type="button" class="close fs-3 position-absolute top-0 end-0 m-2" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>



            <form method="POST">

                <div class="modal-body">

                <!-- 
                    INPUT TEXT 
                    JQUERY DATE_PICKER 
                -->

                <!-- START DATE -->  
                <div class="modal-body">
                    <div class="form-group">
                        <label><h4>Start </h4></label>
                        <input type="text" class="form-control" id="start_datePicker" name="start" value="" placeholder="start ..." required>
                    </div>
                </div>

                <!-- END DATE -->  	
                <div class="modal-body">
                    <div class="form-group">
                        <label><h4>End </h4></label>
                        <input type="text" class="form-control" id="end_datePicker"  name="end" value="" placeholder="end ..." required>
                    </div>
                </div>                             


                <!--
                    USER  DROPDOWN LIST 
                -->   
                <!-- dropdown list to choose a User to be assigned  -->   <!-- $_POST['selected_userId'] -->  
                <div class="modal-body">
                    <div class="form-group">
                        <label><h4>User </h4></label>
                        <select name="selected_userId" id="id_selectUser" class="form-control" >
                            <optgroup label="Select an user" class="form-control" >
                                <?php 
                                    foreach ( $users as $u ){ 
                                        $value = $u->id; $name = $u->name; 
                                        if(isset($_GET['user_name']) && $_GET['user_name'] == $u->name)
                                        {
                                            echo "<option selected='selected' value='".$value."'>".$name."</option>";
                                        }
                                        else
                                        {
                                            echo "<option value='".$value."'>".$name."</option>";
                                        }
                                    }  
                                ?>
                            </optgroup>
                        </select>
                        <br>
                        <br> 
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit"  name="create_vacation" class="btn btn-primary">Create</button>
                </div>   

                </div> 
            </form>
        </div>
    </div>
</div> <!-- End .Modal-Create -->
</section>




<!-- Script pour initialiser Flatpickr -->
<script>

$(document).ready(function() { 

    // ____________________________
    // FLATPICK | DATEPICKER 
    // ____________________________
    // flatpickr("#datepicker", {dateFormat: "d.m.Y",  inline: true });  // inline: true === Afficher le calendrier au chargement 
    flatpickr("#start_datePicker", {dateFormat: "d.m.Y", weekNumbers: true});
    flatpickr("#end_datePicker", {dateFormat: "d.m.Y", weekNumbers: true});


    $('#start_datePicker').change(function() { 
        let startDate = document.querySelector('#start_datePicker')._flatpickr.selectedDates[0];
        flatpickr("#end_datePicker", {dateFormat: "d.m.Y", minDate: startDate});
    }) 

    $('#end_datePicker').change(function() {  
        let endDate = document.querySelector('#end_datePicker')._flatpickr.selectedDates[0];
        flatpickr("#start_datePicker", {dateFormat: "d.m.Y", maxDate: endDate});
    }) 


}) 
</script> 