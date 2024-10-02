<?php
session_start();

if($_SESSION["login"]) {


require '../config.php';
require 'vue/partials/header.php';
include '../utils/connectdb.php';
require '../model/task.php';
require 'vue/partials/nav.php';


$task = getTasks(); 

?>




<script type="text/javascript" charset="utf-8">
    document.addEventListener('DOMContentLoaded', function() {
        
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: <?php echo json_encode(getTaskedAdmin()) ?>
        });

    calendar.render();
    });
    
</script>




<!-- ------------------------------------------------- -->    
<!-- Page title & Button Create (Insert into db.table ) -->     
<!-- ------------------------------------------------- -->     
 
<section class="container mt-5">
    <div class="container">
        <!-- Title -->    
        <h2>Index</h2>
        
        <br>
        <hr>
        <br>

        <!-- ------------------------------------------------- -->    
        <!-- Button to open Modal Window -->     
        <!-- ------------------------------------------------- --> 
        <?php foreach ($task as $t) { ?>
            <div class="badge" style="background-color: <?php echo $t->color ?>;">
                <?php echo $t->name ?>
            </div>
        <?php } ?>


        <!-- ------------------------------------------------- -->    
        <!-- Calendar integration -->     
        <!-- ------------------------------------------------- --> 
        <div id='calendar' class="mt-5">
        </div>
    
    </div>
</div>

</section>



<?php
    require 'vue/partials/footer.php';
} else {
    header("Location: /admin/");
} 

