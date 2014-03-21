<?php
	try {
		session_start();
	  	require_once("db.php");

		if(isset($_SESSION['role']) && $_SESSION['role'] == 'Διαχειριστής') {

			$db = new Db();
		  	if (isset($_GET['id'])) {
		  		$id = $_GET['id'];
		  		$result = $db->DelItem($id);
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