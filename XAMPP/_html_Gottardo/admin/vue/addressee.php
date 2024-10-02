<?php 
// echo $_POST["send"]; 
// var_dump($_POST['check_list']);
?>

<div class="container">
    <!-- ------------------ --> 
    <!-- FORM  --> 
    <!-- ------------------ --> 
    <form method="POST"> 

        <table class="table">
            <tr> 
                <td>
                    <h2>Email message </h2>
                    <h4>Special characters</h4>          
                    <ul>
                        <li>/name to add the task name</li>
                        <li>/date to add the date</li>
                    </ul>                          
                </td>            
                <td> 
                    <div style="text-align: right;">
                        <!-- BOUTON ENVOYER --> 
                        <input type="submit" class="btn btn-primary my-3" value="Send e-mail" name="send_mail" > 
                    </div>
                </td> 
            </tr>
        </table> 

        <!-- ------------------------------------------------- -->    
        <!-- MAIL BODY (Content, message to send) --> 
        <!-- ------------------------------------------------- -->   
        <div class="form-group">
            <textarea class="form-control editor" id="mail" rows="10" name="mail"><?php echo $mail->text ?></textarea>
        </div>

        <br>
        <h4>Addressees (e-mail recipients)</h4> 

        <!-- ------------------------------------------------- -->  
        <!-- ADDRESSEES / RECIPIENTS LIST FROM MYSQL DB --> 
        <!-- ------------------------------------------------- -->  
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Select</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col"></th>

                    <!-- ------------------------------------------------- -->  
                    <!-- Link to a Modal window for creating a new Addressee -->  
                    <!-- ------------------------------------------------- -->   
                    <th scope="col" style="text-align: right;"><?php require 'partials/modalAddresseeCreate.php';?> <!-- CREATE NEW ADDRESSEE (INSERT INTO DB) -->

                    </th>
                </tr>
            </thead>
                <tbody>
                    <?php foreach ( $addressees as $recipient ) { ?>
                        <tr>   <!-- CHECK LIST FOR RECIPIENTS --> 
                            <td> <input type="checkbox" name="check_list[]" value="<?php  echo $recipient['id']?>"></td> 

                              <!-- RECIPIENTS NAME & EMAIL --> 
                            <td><?php  echo $recipient['name']?></td> 
                            <td><?php  echo $recipient['email']?></td> 

                            <!-- ------------------------------------------------- -->  
                            <!-- Link to a Modal window for Updating an Addressee -->  
                            <!-- ------------------------------------------------- -->   
                            <td scope="col" style="text-align: right;">
                                <?php require 'partials/modalAddresseeUpdate.php';?> <!-- UPDATE ADDRESSEE-->
                            </td>


                                <!-- ------------------------------------------------- -->  
                                <!--  Button DELETE (RECIPIENT) to a Modal window  --> 
                                <!-- ------------------------------------------------- -->  
                                <td>
                                    <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#deleteAddresseeModal<?php  echo $recipient['id']?>"> Delete </button>
                                </td>

                                <!-- ------------------------------------------------- -->  
                                <!-- Modal window to DELETE a Recipient -->
                                <!-- ------------------------------------------------- -->  
                                <div class="modal fade" id="deleteAddresseeModal<?php  echo $recipient['id']?>" tabindex="-1" role="dialog" aria-labelledby="modal_deleteAddressee" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modal_deleteAddressee">Are you sure ?</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form method="POST"><!-- Form html --> 
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <form method="POST">
                                                    <input type="hidden"  name="id_addressee" value="<?php  echo $recipient['id']?>">
                                                    <input type="hidden"  name="method"  value="Delete">
                                                    <button type="submit" name="delete_addressee" class="btn btn-danger">Delete</button>
                                                </form>
                                            </div>
                                        </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr> 
                    <?php } ?><!-- end.foreach() LOOP --> 
                </tbody>
            </table>
    </form><!-- end.Form html --> 

</div> 
<?php 


?>







