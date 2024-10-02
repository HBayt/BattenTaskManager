<section class="container mt-5">
    <h2>Change user for the task</h2>
    <table class="table">
        <thead>
            <tr>
            <th scope="col">First and lastname</th>
            <th scope="col"></th>
            </tr>
        </thead>
        <?php foreach( $user as $u ) {?>
            <tr>
            <td><?php echo $u->name ?></td>
            <td><form method="POST">
                <input type="hidden"  name="id_user" value="<?php echo $u->id ?>">
                <button type="submit" class="btn btn-secondary">choose</button>
            </form></td>
            </tr>

        <?php } ?>
    </table>
    <div class="align-middle">
        
        <form method="POST">
            <input type="hidden" name="tasked_id" value="<?php echo $_GET['tasked_id'] ?>">
            <input class="btn btn-primary" type="submit" value="Change for random user" />
        </form>
    </div>
</section>