<div class="container-fluid">
  <div class="row">
    <form class="form-signin" role="form" method="Post" action="index.php">
      <h3 class="form-signin-heading">Σύστημα Παραγγελιοληψίας</h3>
      <input type="text" name="username" class="form-control" placeholder="User name" required autofocus title="Παρακαλώ συμπληρώστε το πεδίο">
      <input type="password" name="password" class="form-control" placeholder="Password" required title="Παρακαλώ συμπληρώστε το πεδίο">
      <button class="btn btn-lg btn-primary btn-block" type="submit">Είσοδος</button>
    </form>
    <?php
      if(isset($_SESSION['message'])){
        echo '<div class="alert alert-danger">';
        echo '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
        echo '<strong>'.$_SESSION['message'].'</strong>';
        echo '</div>';
        unset($_SESSION['message']);
      }
    ?>
  </div>
</div>