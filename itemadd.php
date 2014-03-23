<?php
	try {
		session_start();
	  	require_once("db.php");

	  	// Έλεγχος αν ο χρήστης επιτρέπεται να προσθέση νέο προιόν
		if(isset($_SESSION['role']) && $_SESSION['role'] == 'Διαχειριστής') {

			$db = new Db();
			// Έλεγχος ότι υπάρχουν οι απαιτούμενες μεταβλητές
		  	if (isset($_POST['name']) 
		  		&& isset($_POST['description'])
		  		&& isset($_POST['price'])) {
		  		$name = $_POST['name'];
			  	$description = $_POST['description'];
			  	$price = $_POST['price'];
			  	// Εκτέλεση μεθόδου για την εισαγωγή
		  		$result = $db->AddItem($name,$description,$price);
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
  	
  	// Επιστροφή του αποτελέσματος της διεργασίας
  	header('Content-Type: application/json');
  	echo json_encode($result);
?>