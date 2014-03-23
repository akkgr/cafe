<?php
	try {
		session_start();
	  	require_once("db.php");

	  	// Έλεγχος αν ο χρήστης είναι διαχειριστής
		if(isset($_SESSION['role']) && $_SESSION['role'] == 'Διαχειριστής') {

			$db = new Db();
			// Έλεγχος ότι υπάρχουν οι απαιτούμενες μεταβλητές
		  	if (isset($_POST['lastname']) 
		  		&& isset($_POST['firstname'])
		  		&& isset($_POST['username'])
		  		&& isset($_POST['password'])
		  		&& isset($_POST['role'])) {
		  		$lastname = $_POST['lastname'];
			  	$firstname = $_POST['firstname'];
			  	$username = $_POST['username'];
			  	$password = $_POST['password'];
			  	$role = $_POST['role'];
			  	// Εκτέλεση μεθόδου για την ενημέρωση
		  		$result = $db->UpdateUser($lastname,$firstname,$username,$password,$role);
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