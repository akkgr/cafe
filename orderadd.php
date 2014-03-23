<?php
	try {
		session_start();
	  	require_once("db.php");

	  	// Έλεγχος αν ο χρήστης επιτρέπεται
		if(isset($_SESSION['role']) && isset($_SESSION['username']) && $_SESSION['role'] == 'Σερβιτόρος') {

			$db = new Db();
			// Έλεγχος ότι υπάρχουν οι απαιτούμενες μεταβλητές
		  	if (isset($_POST['itemid']) 
		  		&& isset($_POST['quantity'])) {
		  		$itemid = $_POST['itemid'];
			  	$quantity = $_POST['quantity'];
			  	$username = $_SESSION['username'];
			  	// Εκτέλεση μεθόδου για την εισαγωγή
		  		$result = $db->AddOrder($itemid,$quantity,$username);
		  	}
		  	else {
		  		$result = array('error' => true, 'message' => "Λάθος Κωδικός Προϊόντος.");
		  	}
		}
		else {
			$result = array('error' => true, 'message' => "Πρέπει να συνδεθήτε ως Σερβιτόρος.");
		}
	} catch(Exception $e) {
		$result = array('error' => true, 'message' => $e->getMessage());
	}
  	
  	// Επιστροφή του αποτελέσματος της διεργασίας
  	header('Content-Type: application/json');
  	echo json_encode($result);
?>