<?php
	// Αρχικοποίηση αντικειμένου διεπαφής με τη βάση δεδομένων
  	$db = new Db();

  	// Έλεγχος τρέχουσας σελίδας
  	if (isset($_GET['page']))
  		$page = $_GET['page'];
  	else
  		$page = 0;

  	// Ανάκτηση δεδομένων από την βάση
	$result = $db->GetItems($page);

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
				echo '<li class="active"><a href="index.php?action=items&page='.$i.'">'.($i + 1).'</a></li>';
			}
			else {
				echo '<li><a href="index.php?action=items&page='.$i.'">'.($i + 1).'</a></li>';
			}
		}
		echo '</ul>';

		// Έναρξη πίνακα με επικεφαλίδες για την προβολή των εγγραφών
		echo '<table class="table table-hover">';
		echo '<th>Όνομα</th>';
		echo '<th>Περιγραφή</th>';
		echo '<th style="text-align:right;">Τιμή</th>';
		echo '<th></th>';

		// Επάνάληψη για τη δημιουργία γραμμών για κάθε εγγραφή
		foreach ($result['data'] as $item) {
			
			$url = "orderadd.php";

			echo '<tr>';
			echo '<td>'.$item['name'].'</td>';
			echo '<td>'.$item['description'].'</td>';
			echo '<td class="text-right">'.$item['price'].'</td>';

			// Επιλογή καταχώρησης παραγγελίας
			echo '<td class="text-right">';
			echo '<button type="button" title="Παραγγελία" class="btn btn-primary edit" data-url="'.$url.'"';
			echo "data-item='".json_encode($item, JSON_UNESCAPED_UNICODE)."'>";
			echo '<span class="glyphicon glyphicon-edit"></a></td>';
			
			echo '</tr>';
		}
		echo '</table>';

		// Επιλογές Σελίδων
		echo '<ul class="pagination">';
		echo '<li><a class="text-primary"> Σελίδα: </a></li>';
		for ($i = 0;$i < $result['pages'];$i++) {
			if ($i == $page) {
				echo '<li class="active"><a href="index.php?action=items&page='.$i.'">'.($i + 1).'</a></li>';
			}
			else {
				echo '<li><a href="index.php?action=items&page='.$i.'">'.($i + 1).'</a></li>';
			}
		}
		echo '</ul>';		
	}

	// Ενσωμάτωση φόρμας παραγγελίας
	include "order.php";
?>