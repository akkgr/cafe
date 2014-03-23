<?php
	// Αρχικοποίηση αντικειμένου διεπαφής με τη βάση δεδομένων
  	$db = new Db();

  	// Έλεγχος τρέχουσας σελίδας εγγραφών
  	if (isset($_GET['page']))
  		$page = $_GET['page'];
  	else
  		$page = 0;

  	// Εκτέλεση μεθόδου ανάκτησης εγγραφών
	$result = $db->GetOrders($page);

	// Έλεγχος για τυχόν σφάλμα κατα την ανάκτηση δεδομένων
	if ($result['error'])
	{
		// Προβολή σφάλματος
	  	echo '<div class="alert alert-danger">';
        echo '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
        echo '<strong>'.$result['message'].'</strong>';
        echo '</div>';
	}
	else {

		// Επιλογές Σελίδων
		echo '<ul class="pagination">';
		echo '<li><a class="text-primary"> Σελίδα: </a></li>';
		for ($i = 0;$i < $result['pages'];$i++) {
			if ($i == $page) {
				echo '<li class="active"><a href="index.php?action=orders&page='.$i.'">'.($i + 1).'</a></li>';
			}
			else {
				echo '<li><a href="index.php?action=orders&page='.$i.'">'.($i + 1).'</a></li>';
			}
		}
		echo '</ul>';

		// Έναρξη πίνακα με επικεφαλίδες για την προβολή των εγγραφών
		echo '<table class="table table-hover">';
		echo '<th>Ημερομηνία</th>';
		echo '<th>Σερβιτόρος</th>';
		echo '<th>Προιόν</th>';
		echo '<th style="text-align:right;">Τιμή</th>';
		echo '<th style="text-align:right;">Ποσότητα</th>';
		echo '<th style="text-align:right;">Σύνολο</th>';

		// Επάνάληψη για τη δημιουργία γραμμών για κάθε εγγραφή
		foreach ($result['data'] as $order) {
			echo '<tr>';
			// Στήλες με τα πεδία της εγγραφής
			echo '<td>'.$order['OrderDateTime'].'</td>';
			echo '<td>'.$order['lastname'].' '.$order['firstname'].'</td>';
			echo '<td>'.$order['name'].'</td>';
			echo '<td style="text-align:right;">'.$order['price'].'</td>';
			echo '<td style="text-align:right;">'.$order['quantity'].'</td>';
			echo '<td style="text-align:right;">'.$order['total'].'</td>';
			echo '</tr>';
		}
		echo '</table>';

		// Επιλογές Σελίδων
		echo '<ul class="pagination">';
		echo '<li><a class="text-primary"> Σελίδα: </a></li>';
		for ($i = 0;$i < $result['pages'];$i++) {
			if ($i == $page) {
				echo '<li class="active"><a href="index.php?action=orders&page='.$i.'">'.($i + 1).'</a></li>';
			}
			else {
				echo '<li><a href="index.php?action=orders&page='.$i.'">'.($i + 1).'</a></li>';
			}
		}
		echo '</ul>';
	}
?>