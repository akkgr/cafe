<?php
  // Έναρξη Session
  session_start();
  // Ενσωμάτωση κώδικα διεπαφής με τη βάση δεδομένων
  require_once("db.php");
?>
<?php
  // Έλεγχος LogIn
  // Έλεγχος αν έχουν γίνει post το username και το password.
  // Αν έχου γίνει τότε εκτελούμε απο την κλάση Db τη μέθοδο login
  if (isset($_POST['username']) && isset($_POST['password'])) {
        $db = new Db();
        $result = $db->login($_POST['username'],$_POST['password']);
        if ($result['error'])
        {
          $_SESSION['message'] = $result['message'];
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="img/cafe.ico">
    <title>Cafe</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
    <script src="js/jquery-1.11.0.min.js"></script>
    <script src="js/jquery.validate.min.js"></script>
    <script src="js/messages_el.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </head>
  <body>

    <!-- Επικεφαλίδα για εμφάνιση menou επιλογών -->
    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href=".">Cafe</a>
        </div>
        <div class="navbar-collapse collapse">          
          <?php
            // έλεγχος με βάση τη session μεταβλητή που κρατά την πληροφορία του ρόλου του χρήστη
            // για την εμφάνιση του μενού
            if(isset($_SESSION['role'])){
              $role = $_SESSION['role'];
              $name = $_SESSION['username'];
              include 'menu.php';
          ?>
            <ul class="nav navbar-nav navbar-right">
              <li><a href="logout.php"><?php echo $name; ?> - Αποσύνδεση</a></li>
            </up>
          <?php } ?>
        </div>
      </div>
    </div>
    <!-- Τέλος Επικεφαλίδας -->

    <!-- κυρίως σώμα -->
    <div class="container-fluid">
    <?php
      // Έλεγχος ύπαρξης session μεταβλητής
      // για το ρόλο του χρήστη
      if (!(isset($_SESSION['role'])))
        // Αν δεν έχει οριστεί εμφανίζουμε οθόνη για login
        include 'login.php';
      else {
        // Αν έχει οριστεί ελέγχουμε αν υπάρχει GET παράμετρος
        // με το όνομα action που καθορίζει συγκεκριμένη επιλογή 
        // του χρήστη από το μενοu
        if (isset($_GET['action'])) {
          // Ανάλογα εμφανίζουμε την αντίστοιχη οθόνη
          switch ($_GET["action"]) {
            case "users":
              include 'users.php';
              break;
            case "items":
              include 'items.php';
              break;
            case "orders":
              include 'orders.php';
              break;
            case "top":
              include 'topitems.php';
              break;
            case "sales":
              include 'sales.php';
              break;
            case "catalog":
              include 'catalog.php';
              break;
            case "xml":
              include 'xml.php';
              break;
            default:
              echo '<div class="jumbotron">';
              echo '<h3>Cafe, σύστημα παραγγελιοληψίας.</h3>';
              echo '<p>η σελίδα δεν υπάρχει.</p>';
              echo '</div>';
          }
        } else {
          echo '<div class="jumbotron">';
          echo '<h3>Cafe, σύστημα παραγγελιοληψίας.</h3>';
          echo '<p>έχετε συνδεθεί ως '.$_SESSION['username'].'</p>';
          echo '</div>';
        }
      }
    ?>
    </div>
    <!-- τέλος κυρίως σώματος -->
    
    <!-- Popup Modal Διάλογος για εμφάνιση πληροφοριών στον χρήστη -->
    <div class="modal fade" id="infoDialog" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-body">
            <p class="text-danger" id="infoMessage"></p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
          </div>
        </div>
      </div>
    </div>
    <!-- τέλος διαλόγου πληροφοριών -->

    <!-- Popup Modal Διάλογος για επιβεβαίωση διαγραφής -->
    <div class="modal fade" id="confirmDialog" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-body">
            <p class="text-info" id="confirmMessage"></p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Άκυρο</button>
            <button type="submit" class="btn btn-danger delete">Διαγραφή</button>
          </div>
        </div>
      </div>
    </div>
    <!-- τέλος διαλόγου επιβεβαίωσης -->

    <script src="js/cafe.js"></script>
  </body>
</html>