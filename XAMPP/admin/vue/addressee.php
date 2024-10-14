<!-- ------------------------------------------------- -->    
<!-- Update time : 03.10.2024  -->  
<!-- Author : H. Baytar  -->  
<!-- Confirmation message when CRUD Operations are executed -->     
<!-- ------------------------------------------------- -->    
<section class="container mt-5">
    <?php
    if (isset($_SESSION['message'])) {
        echo $_SESSION['message'];
        unset($_SESSION['message']); // Efface le message après l'affichage
    }
    ?>
</section>



<?php  

// Définir le code HTML comme une chaîne de caractères
// Heredoc Syntaxe (<<<HTML et HTML; ) 
// Le contenu HTML est placé dans une variable $infoMessage en utilisant Heredoc, ce qui permet de conserver la mise en forme d'origine. 
$alertMessage = <<<HTML
<div class="container">
    <div class="container alert alert-warning">
        <h3><strong>Warning, please note!</strong></h3>
        <ol>
            <li>            
                For the Task Manager system to be able <strong>to send e-mails</strong> to the right people,
                it is essential that you <strong>delete or correct</strong> all incorrect or non-existent <strong>e-mail addresses</strong>!
            </li>
            <li>
                Don't forget to <strong>refresh the page</strong> in your web browser (FireFox, Chrome, etc.) 
                after an operation (with the DB) so that you can see the <strong>changes</strong> made to the rows in the recipients table. 
            </li>
        </ol>    
    </div>
    <hr>
</div>
HTML;



// Définir le code HTML comme une chaîne de caractères
$infoMessage = <<<HTML
<div class="container">
    <div class="container alert alert-info">
        <h3><strong>Warning, please note!</strong></h3>
        <strong>Please note the special characters defined in the email message!</strong><br>
        <ul>
            <li><strong>/name</strong> is the variable which will be replaced by the <strong>task name</strong>.</li>
            <li><strong>/date</strong> is the variable which will be replaced by the <strong>date of the task</strong>.</li>
        </ul> 
    </div>
</div>
HTML;

// Définir le code HTML comme une chaîne de caractères
$title_table_recipients = <<<HTML
    <br>
    <h2>Addressees / Recipients</h2>
    <h4>{$numOfAddressees} e-mail recipients found</h4>
    <br>
HTML;

// Définir le code HTML comme une chaîne de caractères
$table_recipients = <<<HTML
<div class="container">
    <table class="table table-hover table-striped">
    <thead><tr>
        <th scope="col">Select</th>
        <th scope="col">Name</th>
        <th scope="col">Email</th>
        <th scope="col"></th>
        <th scope="col"></th>
        <th scope="col"></th>
    
HTML;


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
        <!-- Warning note --> 
        <!-- ------------------------------------------------- -->   
        <br>
        <?php echo $infoMessage  ?>


        <!-- ------------------------------------------------- -->    
        <!-- MAIL BODY (Content, message to send) --> 
        <!-- ------------------------------------------------- -->   
        <div class="form-group">
            <textarea class="form-control editor" id="textarea_mail" rows="10" name="textarea_mail"><?php echo $mail->text ?></textarea>
        </div>

        <!-- ------------------------------------------------- -->    
        <!-- Title of addresses / recicpients list  --> 
        <!-- ------------------------------------------------- -->   
        <?php echo $title_table_recipients  ?>

        <!-- ------------------------------------------------- -->    
        <!-- Warning note --> 
        <!-- ------------------------------------------------- -->   
        <?php echo $alertMessage  ?>

        <!-- ------------------------------------------------- -->  
        <!-- ADDRESSEES / RECIPIENTS LIST FROM MYSQL DB --> 
        <!-- ------------------------------------------------- -->  
        <?php echo $table_recipients  ?>
                    <!-- ------------------------------------------------- -->  
                    <!-- Link to a Modal window for creating a new Addressee -->  
                    <!-- ------------------------------------------------- -->   
                    <th scope="col">
                        <div style="text-align: right;">
                            <?php require 'partials/modalAddresseeCreate.php';?> <!-- CREATE NEW ADDRESSEE (INSERT INTO DB) -->
                        </div>
                    </th>
                </tr>
            </thead>
                <tbody>
                    <?php foreach ( $addressees as $recipient ) {?>
                        <tr>   <!-- CHECK LIST FOR RECIPIENTS --> 
                            <td> <input type="checkbox" name="check_list[]" value="<?php  echo $recipient['id']?>"></td> 

                              <!-- RECIPIENTS NAME & EMAIL --> 
                            <td><?php echo $recipient['name']?></td> 
                            <td><?php echo $recipient['email']?></td> 

                            <td> </td>  
                            <td> </td> 

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
                                                <!-- Modal DELETE AN ADDRESSEE -->
                                                <h5 class="modal-title fs-4 luckiest" id="exampleModalLabel"><span style="color:blue;">Are you sure ?</span></h5>
                                                <button type="button" class="close fs-4 position-absolute top-0 end-0 m-2" data-dismiss="modal" aria-label="Close">
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
                                </div><!-- end.modal-windows.delete()  --> 


                    
                        </tr> 
                    <?php }?><!-- end.foreach() LOOP --> 
                </tbody>
            </table>
    </form><!-- end.Form html --> 

</div> 
