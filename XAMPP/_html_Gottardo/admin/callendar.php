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

<script>
    document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        events: <?php echo json_encode(getTaskedAdmin()) ?>
    });

    calendar.render();
    });
    
</script>
<div class="container mt-5">
    <h2>Index</h2>
    <?php foreach ($task as $t) { ?>
        <div class="badge" style="background-color: <?php echo $t->color ?>;">
            <?php echo $t->name ?>
        </div>
    <?php } ?>
    <div id='calendar' class="mt-5"></div>
    
</div>
<?php
require 'vue/partials/footer.php';
} else {
    header("Location: /admin/");
} 

