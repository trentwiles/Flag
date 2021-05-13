<?php
include "header.php";

$val

?>

<h1>Reset your password</h1>
<form action="/api/v1/reset" method="post" class="w-400 mw-full">
  <div class="form-group">
    <label for="email" class="required">Email</label>
    <input type="text" name="email" class="form-control" id="email" value='' placeholder="Username" required="required">
  </div>
  <input class="btn btn-primary btn-block" type="submit" value="Reset My Password">
</form>

<?php
include "footer.php";
