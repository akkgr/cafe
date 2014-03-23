<?php
	try {
		session_start();
	  	require_once("db.php");

	  	// Έλεγχος αν ο χρήστης είναι διαχειριστής
		if(isset($_SESSION['role']) && $_SESSION['role'] == 'Διαχειριστής') {

			$db = new Db();
			// Έλεγχος ότι υπάρχουν οι απαιτούμενες μεταβλητές
		  	if (isset($_GET['id'])) {
		  		$id = $_GET['id'];
		  		// Εκτέλεση μεθόδου για την διαγραφή
		  		$result = $db->DelUser($id);
		  	}
		  	else {
		  		$result = array('error' => true, 'message' => "Λάθος username.");
		  	}
		}
		else {
			$result = array('error' => true, 'message' => "Πρέπει να συνδεθήτε ως διαχειρηστής.");
		}
	} catch(Exception $e) {
		$result = array('error' => true, 'message' => $e->getMessage());
	}
  	
  	// Επιστροφή του αποτελέσματος της διεργασίας
  	header('Content-Type: application/json; charset=utf-8');
  	echo json_encode($result);
?>