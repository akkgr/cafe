<?php
	// Αρχικοποίηση αντικειμένου διεπαφής με τη βάση δεδομένων
  	$db = new Db(); 

  	// Εκτέλεση μεθόδου ανάκτησης εγγραφών
	$result = $db->GetSales();
	
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
		// Εμφάνιση σε πίνακα της πληροφορίας
		echo '<h3>Συνολικός Τζίρος</h3>';
		echo '<table class="table table-hover">';
		echo '<th>Τρέχουσας Ημέρας</th>';
		echo '<th>Εβδομάδας</th>';
		echo '<th>Μήνα</th>';
		echo '<tr>';
		echo '<td>'.$result['day'].'</td>';
		echo '<td>'.$result['week'].'</td>';
		echo '<td>'.$result['month'].'</td>';
		echo '</tr>';
		echo '</table>';		
	}
?>