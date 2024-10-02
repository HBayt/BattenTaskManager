<div class="container mt-5">
    <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/admin/group.php">Groups</a></li>
        <li class="breadcrumb-item active">
            <?php 
                if (!empty($group->name)) {
                    echo $group->name; 
                }else{
                    echo "User"; 
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
    <h2>Users</h2>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createUserModal" style="float: right;">Create </button>
</div>


<!-- ------------------------------------------------- -->    
<!-- User list from DB MySQL -->     
<!-- ------------------------------------------------- -->    
<div class="container mt-5">
  <table class="table">
        <thead>
            <tr>
            <th scope="col">First and lastname</th>
            <th scope="col">Email</th>
            <th scope="col"></th>
            <th scope="col"></th>
            <th scope="col"></th>
            <th scope="col"></th>
            </tr>
        </thead>
        <?php foreach( $user as $u ) {?>
            <tr>
            <td><?php echo $u->name ?></td>
            <td><?php echo $u->email ?></td>

            <!-- ------------------------------------------------- -->    
            <!-- CRUD Actions / Modal windows -->     
            <!-- ------------------------------------------------- -->    
            <td><a href="/admin/vacationlist.php?user_id=<?php echo $u->id ?>&user_name=<?php echo $u->name ?>"><button class="btn btn-primary">Vacation</button></a></td>
            <td><?php require 'partials/modalDetailUser.php';?></td>
            <td><?php require 'partials/modalUser.php';?></td>
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
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Are you sure ?</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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

    <!-- ------------------------------------------------- -->    
    <!-- Modal Button Insert into DB Table (MySQL) -->     
    <!-- ------------------------------------------------- -->    
    <div class="modal fade" id="createUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">New user</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form method="POST">
            <input type="hidden"  name="action"  value="createUser">
            <div class="modal-body">
                <div class="form-group">
                    <label>Firstname and lastname</label>
                    <input type="text" class="form-control" id="name" name="name" value="" placeholder="Name">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" value="" placeholder="Enter email">
                </div>
                <div class="form-group mt-3">
                    <label>Weekdays</label>
                    <div class="form-check">
                        <input class="form-check-input" name="weekdays[]" type="checkbox" value="Monday">
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
</div>