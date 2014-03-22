<?php
	try {
		session_start();
	  	require_once("db.php");

	  	// Έλεγχος αν ο χρήστης επιτρέπεται να ενημερώση προιόν
		if(isset($_SESSION['role']) && $_SESSION['role'] == 'Διαχειριστής') {

			$db = new Db();
			// Έλεγχος ότι υπάρχουν οι απαιτούμενες μεταβλητές
		  	if ( isset($_POST['itemid'])
		  		&& isset($_POST['name']) 
		  		&& isset($_POST['description'])
		  		&& isset($_POST['price'])) {
		  		$itemid = $_POST['itemid'];
		  		$name = $_POST['name'];
			  	$description = $_POST['description'];
			  	$price = $_POST['price'];
			  	// Εκτέλεση μεθόδου για την ενημέρωση
		  		$result = $db->UpdateItem($itemid,$name,$description,$price);
		  	}
		  	else {
		  		$result = array('error' => true, 'message' => "Λάθος Κωδικός Προϊόντος.");
		  	}
		}
		else {
			$result = array('error' => true, 'message' => "Πρέπει να συνδεθήτε ως διαχειρηστής.");
		}
	} catch(Exception $e) {
		$result = array('error' => true, 'message' => $e->getMessage());
	}
  	
  	header('Content-Type: application/json');
  	echo json_encode($result);
?>