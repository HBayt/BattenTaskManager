<div class="container">
    <h1 class="my-5">Email message </h1>
    <h2>Special characters</h2>
    <p>/name to add the task name</p>
    <p>/date to add the date</p>
    <form method="POST">
      <div class="form-group">
        <textarea class="form-control editor" id="mail" rows="17" name="mail" rows="3"><?php echo $mail->text ?></textarea>
      </div>
      <input type="submit" class="btn btn-primary my-3">
    </form>
</div>