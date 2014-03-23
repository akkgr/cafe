<?php
	// Αρχικοποίηση αντικειμένου διεπαφής με τη βάση δεδομένων
  	$db = new Db();

  	// Εκτέλεση μεθόδου ανάκτησης εγγραφών
	$result = $db->GetTopItems();

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
		
		// Έναρξη πίνακα με επικεφαλίδες για την προβολή των εγγραφών
		echo '<h3>Προιόντα με τις περισσότερες πωλήσεις</h3>';
		echo '<table class="table table-hover">';
		echo '<th>Προιόν</th>';
		echo '<th style="text-align:right;">Ποσότητα</th>';
		// Επάνάληψη για τη δημιουργία γραμμών για κάθε εγγραφή
		foreach ($result['top'] as $order) {
			echo '<tr>';
			echo '<td>'.$order['name'].'</td>';
			echo '<td style="text-align:right;">'.$order['total'].'</td>';
			echo '</tr>';
		}
		echo '</table>';

		// Έναρξη πίνακα με επικεφαλίδες για την προβολή των εγγραφών
		echo '<h3>Προιόντα με τις λιγότερες πωλήσεις</h3>';
		echo '<table class="table table-hover">';
		echo '<th>Προιόν</th>';
		echo '<th style="text-align:right;">Ποσότητα</th>';
		// Επάνάληψη για τη δημιουργία γραμμών για κάθε εγγραφή
		foreach ($result['last'] as $order) {
			echo '<tr>';
			echo '<td>'.$order['name'].'</td>';
			echo '<td style="text-align:right;">'.$order['total'].'</td>';
			echo '</tr>';
		}
		echo '</table>';
		
	}
?>