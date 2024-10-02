<section class="container mt-5">

    <!-- ------------------------------------------------- -->    
    <!-- Page title & Button Create (Insert into db.table ) -->     
    <!-- ------------------------------------------------- -->      
    <div class="container">
        <table style="width:100%">
        <tr>
            <td> 
                <h2>Groups</h2>
                <h3>(<?php echo $numOfGroups;  ?> groups found)</h3> 
            </td>
            <td>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createGroupModal" style="float: right;">Create </button>
            </td>
            <td></td>
        </tr>
        </table> 
        <br>
        <hr>
    </div>

    <!-- ------------------------------------------------- -->    
    <!-- Group list from MySQL DB  -->     
    <!-- ------------------------------------------------- -->    
    <div class="container mt-5">
    <table class="table">
            <thead>
                <tr>
                <th scope="col">Name</th>
                <th scope="col">Label</th>
                <th scope="col"></th>
                <th scope="col"></th>
                </tr>
            </thead>
            <?php foreach( $group as $g ) {?>
                <tr>
                <td><?php echo $g->name ?></td>
                <td><?php echo $g->libelle ?></td>
                <td>

                <!-- ------------------------------------------------- -->    
                <!-- Delete Button  -->     
                <!-- ------------------------------------------------- -->    
                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#deleteModal<?php echo $g->id ?>">
                    Delete
                </button>

                <!-- ------------------------------------------------- -->    
                <!-- Modal for Delete action (CRUD) -->     
                <!-- ------------------------------------------------- -->    
                <div class="modal fade" id="deleteModal<?php echo $g->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                    <input type="hidden"  name="id" value="<?php echo $g->id ?>">
                                    <input type="hidden"  name="method"  value="DELETE">
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
                </td>


                <!-- BOUTTON GROUP USERS  --> 
                <td><a href="/admin/user.php?group_id=<?php echo $g->id ?>"><button type="button" class="btn btn-primary">Group users</button></a></td>
                </tr>
                
            <?php } ?>
        </table>


        <!-- ------------------------------------------------- -->    
        <!--  CREATE / MODAL CONTAINER -->     
        <!-- ------------------------------------------------- -->    
        <div class="modal fade" id="createGroupModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">


                <!-- Modal header --> 
                <div class="modal-header">
                    <!-- Modal window / Title --> 
                    <h5 class="modal-title fs-4 luckiest" id="exampleModalLabel"><span style="color:blue;">New group</span></h5>
                    <button type="button" class="close fs-4 position-absolute top-0 end-0 m-2" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>


                <form method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="start"><h5><span style="color:brown;">Group label</span></h5></label>
                            <input type="text" class="form-control" id="label" name="label" value="" placeholder="Group label / UID" required>
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="start"><h5><span style="color:brown;">Name</span></h5></label>
                            <input type="text" class="form-control" id="name" name="name" value="" placeholder="Group name" required>
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
</div>