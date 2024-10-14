
<?php 
// Définir le code HTML comme une chaîne de caractères
?> 



<!-- ------------------------------------------------- -->    
<!-- Page title & Button Create (Insert into db.table ) -->     
<!-- ------------------------------------------------- -->      

<section class="container mt-5">
<div class="container">
    <table style="width:100%">
    <tr>
        <td> 
            <h2>Users workdays (Does not include vacations)</h2>
            <h3>(<?php echo $numOfUsers;  ?> users found)</h3> 
        </td>
        <td>
            
        </td>
        <td></td>
    </tr>
    </table> 
    <hr>
</div>
</section>

<!-- ------------------------------------------------- -->    
<!-- UUSER WEEKDAYS -->     
<!-- ------------------------------------------------- -->    
<section class="container mt-5">
    <table class="table table-hover table-striped">
        <thead>
            <tr>
            <th scope="col">Atelier / Workshop / Werkstatt</th>
            <th scope="col">Monday (Lun)</th>
            <th scope="col">Tuesday (Mar)</th>
            <th scope="col">Wednesday (Mer)</th>
            <th scope="col">Thursday (Jeu) </th>
            <th scope="col">Friday (Ven)</th>
            </tr>
        </thead>
        <tbody> 
        <?php  
            // var_dump($groups); 
        
        foreach($groups as $group){
            if(!empty($group)){
                    echo " <tr>";
                    echo " <td>".$group->name."</td>";

                    // For the Monday column | Für die Spalte am Montag | Pour la colonne Lundi 
                    echo " <td>"; 
                    foreach($users as $user){
                        $userWeekdays = json_decode($user->weekdays); 

                        if(!empty($userWeekdays) && in_array('Monday', $userWeekdays) ){
                            if ($user-> group_id == $group-> id) { 
                                echo $user->name."</br>";
                            } 

                        }
                        $userWeekdays = null; 
                    }
                    echo "</td>";



                    // For the Tuesday column | Für die Spalte am Dienstag | Pour la colonne Mardi  
                    echo " <td>"; 
                    foreach($users as $user){
                        $userWeekdays = json_decode($user->weekdays); 

                        if(!empty($userWeekdays) && in_array('Tuesday', $userWeekdays) ){
                            if ($user-> group_id == $group-> id) { 
                                echo $user->name."</br>";
                            } 
                        }
                        $userWeekdays = null; 
                    }
                    echo "</td>";



                    // For the Wednesday column | Für die Spalte am Mittwoch | Pour la colonne Mercredi  
                    echo " <td>"; 
                    foreach($users as $user){
                        $userWeekdays = json_decode($user->weekdays); 

                        if(!empty($userWeekdays) && in_array('Wednesday', $userWeekdays) ){
                            if ($user-> group_id == $group-> id) { 
                                echo $user->name."</br>";
                            } 
                        }
                        $userWeekdays = null; 
                    }
                    echo "</td>";


                    // For the Thursday column | Für die Spalte am Donnerstag | Pour la colonne Jeudi  
                    echo " <td>"; 
                    foreach($users as $user){
                        $userWeekdays = json_decode($user->weekdays); 

                        if(!empty($userWeekdays) && in_array('Thursday', $userWeekdays) ){
                            if ($user-> group_id == $group-> id) { 
                                echo $user->name."</br>";
                            } 
                        }
                        $userWeekdays = null; 
                    }
                    echo "</td>";



                    // For the Friday column | Für die Spalte am Freitag | Pour la colonne Vendredi  
                    echo " <td>"; 
                    foreach($users as $user){
                        $userWeekdays = json_decode($user->weekdays); 

                        if(!empty($userWeekdays) && in_array('Friday', $userWeekdays) ){
                            if ($user-> group_id == $group-> id) { 
                                echo $user->name."</br>";
                            } 
                        }
                        $userWeekdays = null; 
                    }
                    echo "</td>";

                }else{
                    echo "<tr><td>NON </td><tr>";  
                }
            }
        ?> 
    </tbody> 
    </tr>
    </table> 
    <br>
    <br>
</section>


