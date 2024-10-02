<?php
    require 'config.php';
    // require 'vue/partials/header.php';
    require 'admin/vue/partials/header.php';
    require 'utils/connectdb.php';
    require 'model/task.php';

    $task = getTasks();
?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        events: <?php echo json_encode(getTasked()); ?>
    });
        calendar.render();
    });
</script>



<br>  
<!-- ------------------------------------------------- -->    
<!-- Page title & Button Create (Insert into db.table ) -->     
<!-- ------------------------------------------------- -->     
 
<section class="container mt-5">
    <div class="container">
        <table class="table">
            <tr> 
                <td>
                    <!-- Title -->    
                    <h2>Index</h2>                                 
                </td>            
                <td> 
                    <div style="text-align: right;">
                        <!-- LINK Login (URL)
                            <a href="admin/admin.php">Login </a>
                        --> 

                        <div class="container">
                            <!-- ------------------------------------------------- -->    
                            <!-- Button to open Modal Window -->     
                            <!-- ------------------------------------------------- --> 
                            <a href="admin/admin.php"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createAdminModal" style="float: right;">Login </button></a>
                            <br>
                        </div>

                        <br>  
                        <br> 
                    </div>
                </td> 
            </tr>
        </table> 
        <br> 
        <!-- ------------------------------------------------- -->    
        <!-- Print Tasks list -->     
        <!-- ------------------------------------------------- --> 
        <?php foreach ($task as $t) { ?>
            <div class="badge" style="background-color: <?php echo $t->color ?>;">
                <?php echo $t->name;?>  
            </div>
        <?php } ?>

        <br>         
        <!-- ------------------------------------------------- -->    
        <!-- Print Calendar -->     
        <!-- ------------------------------------------------- --> 
        <div class="container">
            <div id='calendar' class="mt-5"></div>
        </div>
    
</div>
<?php
// require 'vue/partials/footer.php';
require 'admin/vue/partials/footer.php';
