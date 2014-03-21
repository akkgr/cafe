<?php
	try {
		session_start();
	  	require_once("db.php");

		if(isset($_SESSION['role']) && isset($_SESSION['username']) && $_SESSION['role'] == 'Σερβιτόρος') {

			$db = new Db();
		  	if (isset($_POST['itemid']) 
		  		&& isset($_POST['quantity'])) {
		  		$itemid = $_POST['itemid'];
			  	$quantity = $_POST['quantity'];
			  	$username = $_SESSION['username'];
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
  	
  	header('Content-Type: application/json');
  	echo json_encode($result);
?>