<div class="container-fluid">
  <div class="row">
    <!-- Φόρμα για το Log In --> 
    <form class="form-signin" role="form" method="Post" id="form" action="index.php">
      <h3 class="form-signin-heading">Σύστημα Παραγγελιοληψίας</h3>
      <div class="form-group">
      <input type="text" name="username" class="form-control" placeholder="User name" autofocus>
      </div>
      <div class="form-group">
      <input type="password" name="password" class="form-control" placeholder="Password">
      </div>
      <button class="btn btn-lg btn-primary btn-block" type="submit">Είσοδος</button>
    </form>
    <!-- Τέλος Φόρμας -->
    <?php
      // Έλεγχος για τυχόν μύνημα σφάλματος από προηγούμενη προσπάθεια
      // και εμφάνιση του.
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

<script>
  // κώδικας για το validation της φόρμας
  $('#form').validate({
        // κανόνες για τα πεδία username και password
        rules: {
            username: {
                required: true
            },
            password: {
                required: true
            }
        },
        // κώδικας μορφοποίσης και δημιουργίας στοιχείων
        // αν υπάρχει παραβίαση των κονόνων ή όχι
        highlight: function(element) {
            $(element).closest('.form-group').addClass('has-error');
        },
        unhighlight: function(element) {
            $(element).closest('.form-group').removeClass('has-error');
        },
        errorElement: 'span',
        errorClass: 'help-block',
        errorPlacement: function(error, element) {
            if(element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        }
    });
</script>