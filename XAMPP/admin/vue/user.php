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
$infoMessage = <<<HTML
<div class="container">
    <div class="container alert alert-warning">
        <h3> <strong>Warning, please note!</strong> </h3>
        <p>
            <ol>
                <li>
                    When updating an <strong>user</strong>, don't forget to 
                    <ul>
                        <li>Make sure his/her <strong>email address</strong> is correct and/or exists.</li>
                        <li>Update the <strong>user's group label</strong> included in <strong>his/her name</strong> as well. </li>
                    </ul>             
                </li>
                <li>When registering a <strong>new user</strong>, 
                    <ul>
                        <li>Check that the <strong>email address</strong> is correct and/or exists. </li>
                        <li>Don't forget to add the <strong>user's group label</strong>  to <strong>user's name</strong>, to make it easier to read the calendar. </li>
                    </ul>  
                </li>
                <li> When  <strong>adding</strong> a new user or  <strong>updating</strong> a user , If the user's weekday is unknown, select the <strong>‘Unknown’ </strong>radio button on the creation/update form. </li>
            </ol>  
        </p>    
    </div>
   <hr> 
</div>
HTML;
?> 

<div class="container mt-5">
    <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/admin/group.php">Groups</a></li>
        <li class="breadcrumb-item active">
            <?php 
  
                if (!empty($group->name)) {   
                    echo $group->name;                            
                    $display_group = false; 
                }else{
                    echo "User"; 
                    $display_group = true; 
                }
            ?>
        </li>
    </ol>
    </nav>
</div>


<!-- ------------------------------------------------- -->    
<!-- Page title & Button Create (Insert into db.table ) -->     
<!-- ------------------------------------------------- -->      
<div class="container">
    <table style="width:100%">
    <tr>
        <td> 
            <h2>Users</h2>
            <h3>(<?php echo $numOfUsers;  ?> users found)</h3> 
        </td>
        <td>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createUserModal" style="float: right;">Create </button>
        </td>
        <td></td>
    </tr>
    </table> 
    <br>
    <hr>
</div>


<?php echo $infoMessage?> 


<!-- ------------------------------------------------- -->    
<!-- User list from DB MySQL -->     
<!-- ------------------------------------------------- -->    
<div class="container">
    <table class="table table-hover table-striped">
        <thead>
            <tr>
            <th scope="col">First and lastname</th>
            <th scope="col">Email</th>
            <th scope="col"> <?php if(empty($group->name)){echo "Assigned group"; } ?> </th>
            <th scope="col"></th>
            <th scope="col"></th>
            <th scope="col"></th>
            <th scope="col"></th>
            </tr>
        </thead>
        <?php 
  
        foreach( $user as $u ) {?>
            <tr>
            <td><?php echo $u->name ?></td>
            <td><?php echo $u->email ?></td>

            <?php 

                $g = json_decode($u->group);   
                if($display_group == true && ! empty( $g)){
                    echo "<td>".$g->name."</td>";
                }else{
                    echo "<td> </td>";  
                }
            ?>


            <!-- ------------------------------------------------- -->    
            <!-- CRUD Actions / Modal windows -->     
            <!-- ------------------------------------------------- -->    
            <td><a href="/admin/vacationlist.php?user_id=<?php echo $u->id ?>&user_name=<?php echo $u->name ?>"><button class="btn btn-primary">Vacation</button></a></td>
            <td><?php require 'partials/modalDetailUser.php';?></td>
            <td><?php require 'partials/modalUpdateUser.php';?></td>
            <td>

                <!-- ------------------------------------------------- -->    
                <!-- Modal Button Delete (Insert into db.table ) -->     
                <!-- ------------------------------------------------- -->    
                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#deleteModal<?php echo $u->id ?>">
                    Delete
                </button>

                <!-- ------------------------------------------------- -->    
                <!-- Modal window to Delete a user  -->     
                <!-- ------------------------------------------------- -->    
                <div class="modal fade" id="deleteModal<?php echo $u->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">

                        <!-- Modal header --> 
                        <div class="modal-header">
                            <!-- Modal window / Title --> 
                            <h5 class="modal-title fs-4 luckiest" id="exampleModalLabel"><span style="color:blue;">Are you sure ?</span></h5>
                            <button type="button" class="close fs-4 position-absolute top-0 end-0 m-2" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>                        

                        <form method="POST">
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <form method="POST">
                                    <input type="hidden"  name="id" value="<?php echo $u->id ?>">
                                    <input type="hidden"  name="action"  value="deleteUser">
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </div>
                        </form>

                        </div>
                    </div>
                </div>   
            </td>
            </tr>

        <?php } ?>
    </table>

    <!-- -------------------------------------------------- -->    
    <!-- CREATE - Modal Button Insert into DB Table (MySQL) -->     
    <!-- -------------------------------------------------- -->    
    <div class="modal fade" id="createUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">


            <!-- Modal header --> 
            <div class="modal-header">
                <!-- Modal window / Title --> 
                <h5 class="modal-title fs-3 luckiest" id="exampleModalLabel"><span style="color:blue;">New user</span></h5>
                <button type="button" class="close fs-4 position-absolute top-0 end-0 m-2" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form method="POST">
                <!-- $_POST['action'] --> 
                <input type="hidden"  name="action"  value="createUser">
                <div class="modal-body">

                    <!-- Firstname and lastname -->    
                    <div class="form-group">
                        <label><h5><span style="color:brown;">Firstname & lastname</span></h5></label>
                        <input type="text" class="form-control" id="name" name="name" value="" placeholder="Name" required> <!-- $_POST['name'] --> 
                        <br>
                    </div>


                    <!-- Email  -->    
                    <div class="form-group">
                        <label for="email"><h5><span style="color:brown;">Email address</span></h5></label>
                        <input type="email" class="form-control" id="email" name="email" value="" placeholder="Enter email" required> <!-- $_POST['email'] --> 
                        <br>
                    </div>

                    <!-- Weekdays /   $_POST['weekdays'] --> 
                    <div class="form-group">
                        <label><h5><span style="color:brown;">Weekdays</span></h5></label>
                        <div class="form-check">
                            <input class="form-check-input" name="weekdays[]" type="checkbox" value="Monday"  checked>
                            <label class="form-check-label">
                                Monday
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" name="weekdays[]" type="checkbox" value="Tuesday">
                            <label class="form-check-label">
                                Tuesday
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" name="weekdays[]" type="checkbox" value="Wednesday">
                            <label class="form-check-label">
                                Wednesday
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" name="weekdays[]" type="checkbox" value="Thursday">
                            <label class="form-check-label">
                                Thursday
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" name="weekdays[]" type="checkbox" value="Friday">
                            <label class="form-check-label">
                                Friday
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" name="weekdays[]" type="checkbox" value="UNKNOWN">
                            <label class="form-check-label">
                                UNKNOWN
                            </label>
                        </div>
                        <br>
                        <br>
                    </div>
            
                    <!-- Group  -->    
                    <!-- Check list to choose a group -->   <!-- $_POST['group'] --> 
                    <div class="form-group">
                        <label><h5><span style="color:brown;">Assigned group</span></h5></label>
                        <?php foreach ( $groups as $g ){ ?>
                            <div class="form-check">
                                <input 
                                    class="form-check-input" 
                                    name="id_group" type="radio"  
                                    id="<?php echo $g->id ?>"                            
                                    value="<?php echo $g->id ?>" 
                                    <?php if (isset( $g->id) &&  $g->name=="NOT ASSIGNED") echo "checked";?> 

                                > <!-- end.input-->    

                                <label class="form-check-label">
                                    <?php echo $g->name ?>
                                </label>
                            </div>
                        <?php }  ?>
                    </div>
                    <br>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
            </form>
        </div>
    </div>
    </div>
</div>