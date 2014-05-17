<?php
  if (isset($_GET['action']))
      $action = $_GET['action'];
    else
      $action = "index";
?>

<?php 
  if ($role == 'Διαχειριστής') {
?>
<ul class="nav navbar-nav">
	<li <?php if($action == "users") echo "class='active'" ?>><a href="index.php?action=users">Χρήστες</a></li>
	<li <?php if($action == "items") echo "class='active'" ?>><a href="index.php?action=items">Κατάλογος</a></li>
	<li <?php if($action == "orders") echo "class='active'" ?>><a href="index.php?action=orders">Παραγγελίες</a></li>
	<li <?php if($action == "top" || $action == "totals") echo "class='dropdown active'"; else echo "class='dropdown'" ?>>
      <a href="#" class="dropdown-toggle" data-toggle="dropdown">Στατιστικά <b class="caret"></b></a>
      <ul class="dropdown-menu">
        <li <?php if($action == "top") echo "class='active'" ?>><a href="index.php?action=top">Προιόντα</a></li>
        <li <?php if($action == "sales") echo "class='active'" ?>><a href="index.php?action=sales">Τζίρος</a></li>
      </ul>
  </li>
  <li <?php if($action == "xml") echo "class='active'" ?>><a href="index.php?action=xml">Αρχείο XML</a></li>
</ul>
<?php 
  } else {
?>
<ul class="nav navbar-nav">
  <li <?php if($action == "catalog") echo "class='active'" ?>><a href="index.php?action=catalog">Kατάλογος </a></li>
</ul>
<?php } ?>