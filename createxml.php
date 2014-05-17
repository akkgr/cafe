<html lang="el">
	<head>
    	<meta charset="utf-8">
	</head>
	<body>

<?php
	try {
		session_start();
	  	require_once("db.php");

	  	// Έλεγχος αν ο χρήστης είναι διαχειριστής
		if(isset($_SESSION['role']) && $_SESSION['role'] == 'Διαχειριστής') {

			$db = new Db();
			// Έλεγχος ότι υπάρχουν οι απαιτούμενες μεταβλητές
		  	if (isset($_POST['date_start']) 
		  		&& isset($_POST['date_end'])) {
		  		$df = $_POST['date_start'];
                $dt = $_POST['date_end'];
			  	// Εκτέλεση μεθόδου για την εισαγωγή
		  		$result = $db->CreateXML($df,$dt." 23:59:59");

		  		//Αρχικοποίηση της μεταβλητής
	            $create_xml = '';

	            // Δημιουργία του DOD το οποίο περιγράφει το xml
	            $create_xml .="<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n" . "<?xml-stylesheet
	                        type=\"application/xml\" href=\"orders.xsl\"?>\n" . "<!DOCTYPE orders [
	                        <!ELEMENT orders (order*)>
	                        <!ELEMENT order (name, price, quantity, waiter)>
	                        <!ELEMENT name (#PCDATA)>
	                        <!ELEMENT price (#PCDATA)>
	                        <!ELEMENT quantity (#PCDATA)>
	                        <!ELEMENT waiter (#PCDATA)>
	                        ]>
	                        <orders>\n";

		  		foreach ($result['data'] as $order) {
		  			$create_xml.="\t<order>\n\t\t" . "<name>" . $order['name'] . "</name>\n\t\t";
	                $create_xml.="<price>" . $order['price'] . "</price>\n\t\t";
	                $create_xml.="<quantity>" . $order['quantity'] . "</quantity>\n\t\t";
	                $create_xml.="<waiter>" . $order['waiter'] . "</waiter>\n\t";
	                $create_xml .="</order>\n";
		  		}
		  		$create_xml .="</orders>\n";

		  		// Μεταβλητή στην οποία τοποθετείται το αρχείο με όνομα orders.xsl
	            $xsl_filename = "orders.xsl";
	            $doc = new DOMDocument();
	            $xsl = new XSLTProcessor();
	            $doc->load($xsl_filename);
	            $xsl->importStyleSheet($doc);
	            $doc->LoadXML($create_xml);

	            //Έλεγχος για την εγκυρότητα του αρχείου βάσει του DTD
            	if (!$doc->validate()) {
            		echo "<p>Το αρχείο δεν είναι έγκυρο σύμφωνα με το DTD.</p>";
	            }
                echo $xsl->transformToXML($doc);
		  	}
		  	else {
		  		echo "<p>Λάθος ημερομηνίες.</p>";
		  	}
		}
		else {
			echo "<p>Πρέπει να συνδεθήτε ως διαχειρηστής.</p>";
		}
	} catch(Exception $e) {
		echo "<p>".$e->getMessage()."</p>";
	}
?>

	</body>
</html>