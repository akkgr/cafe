<?php
	// Αρχικοποίηση αντικειμένου διεπαφής με τη βάση δεδομένων
  	$db = new Db();

  	// Έλεγχος τρέχουσας σελίδας εγγραφών
  	if (isset($_GET['page']))
  		$page = $_GET['page'];
  	else
  		$page = 0;

  	// Εκτέλεση μεθόδου ανάκτησης εγγραφών
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
		echo '<li><a href="#" class="add" data-url="itemadd.php">';
		echo '<span class="glyphicon glyphicon-plus"> Νέο Προιόν</a></li>';
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
		echo '<th></th>';

		// Επάνάληψη για τη δημιουργία γραμμών για κάθε εγγραφή
		foreach ($result['data'] as $item) {
			
			$message = "Να διαγραφεί το προιόν ".$item['name'].";";
			$delurl = "itemdelete.php?id=".$item['itemid'];
			$editurl = "itemupdate.php";

			echo '<tr>';
			// Στήλες με τα πεδία της εγγραφής
			echo '<td>'.$item['name'].'</td>';
			echo '<td>'.$item['description'].'</td>';
			echo '<td class="text-right">'.$item['price'].'</td>';
			
			// Επιλογή Επεξεργασίας της Εγγραφής
			echo '<td class="text-right">';
			echo '<button type="button" title="Αλλαγή" class="btn btn-primary edit" data-url="'.$editurl.'"';
			echo "data-item='".json_encode($item)."'>";
			echo '<span class="glyphicon glyphicon-edit"></a></td>';
			
			// Επιλογή Διαγραφής της Εγγραφής
			echo '<td class="text-right">';
			echo '<button type="button" title="Διαγραφή" class="btn btn-danger confirm" data-url="'.$delurl.'" data-message="'.$message.'">';
			echo '<span class="glyphicon glyphicon-remove"></button></td>';
			
			echo '</tr>';
		}
		echo '</table>';

		// Επιλογές Σελίδων
		echo '<ul class="pagination">';
		echo '<li><a href="#" class="add" data-url="itemadd.php">';
		echo '<span class="glyphicon glyphicon-plus"> Νέο Προιόν</a></li>';
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

	// Ενσωμάτωση φόρμας επεξεργασίας μίας εγγραφής
	include "item.php";
?>