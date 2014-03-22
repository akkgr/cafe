<?php
	class Db
	{
		private $dbhost = "localhost";
		private $dbuser = "root";
		private $dbpass = "";
		private $database = "cafe";
		private $db;
		private $limit = 20;

		// Μέθοδος Αρχικοποίησης σύνδεσης με τη βάση δεδομένων
		private function connect() {
			
			/* Άνοιγμα σύνδεσης */
			$this->db = new mysqli($this->dbhost, $this->dbuser, $this->dbpass, $this->database);
			
			/* Έλεγχος Σύνδεσης */
			if (mysqli_connect_errno()) {
			    return array('error' => true, 'message' => "Πρόβλημα Σύνδεσης στη Βάση Δεδομένων: ".mysqli_connect_error());
			}
			else {
				$this->db->query("SET CHARACTER SET 'UTF8'");
				return array('error' => false, 'message' => "Connect succeeded");
			}
		}

		// Μέθοδος για το κλείσιμο της σύνδεσης με τη βάση δεδομένων
		private function disconnect() {

			/* Κλείσιμο σύνδεσης */
			$this->db->close();

		}

		// Μέθοδος Ελέγχου LogIn
		function login($username,$password) {

			$result = $this->connect();
			if ($result['error'])
				return $result;

			/* Πρόταση ερωτήματος */
			if (!($stmt = $this->db->prepare("SELECT username, role FROM users WHERE username=? and password=?")))
				return array('error' => true, 'message' => $this->db->error);
			    
		    /* Ανάθεση Μεταβλητών */
		    if (!($stmt->bind_param("ss", $username, $password)))
		    	return array('error' => true, 'message' => $stmt->error);

		    /* Εκτέλεση */
		    if (!($stmt->execute()))
		    	return array('error' => true, 'message' => $stmt->error);

		    /* Ανάθεση αποτελέσματος */
		    if (!($stmt->bind_result($user,$role)))
		    	return array('error' => true, 'message' => $stmt->error);

		    /* Ανάκτηση Αποτελέσματος */
		    /* Έλεγχος ότι ο χρήστης υπάρχει */
		    if ($stmt->fetch()) {
		    	// Ανάθεση σε Session μεταβλητές του username
		    	// και του ρόλου του χρήστη
		    	// για αναφορά σε αυτές από όλες τις κλήσεις
	    		$_SESSION['username'] = $user;
	    		$_SESSION['role'] = $role;
	    		$result = array('error' => false, 'message' => "User Logged In");
		    }
		    else {
		    	$result = array('error' => true, 'message' => "Ο συνδυασμός username, password δεν είναι σωστός.");
		    }

		    /* Κλείσιμο ερωτήματος */
		    $stmt->close();		
			$this->disconnect();

			return $result;
		}

		// Μέθοδος Ανάκτησης όλων των χρηστών
		// από τη βάση σε σελίδες
		function GetUsers($page) {

			$result = $this->connect();
			if ($result['error'])
				return $result;

			// Ερώτημα για υπολογισμό του αριθμού σελίδων
			$total = $this->db->query('SELECT COUNT(*) total FROM users')->fetch_object()->total;
			$pages = ceil($total / $this->limit);

			// Ερώτημα ανάκτησης χρηστών
			$stmt = $this->db->stmt_init();
			if (!($stmt = $this->db->prepare("SELECT lastname,firstname,username,password,role 
									FROM users ORDER BY lastname,firstname LIMIT ? OFFSET ?")))
				return array('error' => true, 'message' => $this->db->error);

			// Έλεγχος τρέχουσας σελίδας
			if($page >= $pages)
				$offset = 0;
			else
				$offset = $page * $this->limit;

			// Ανάθεση τιμών στις παραμέτρους του ερωτήματος
			if (!($stmt->bind_param("ii", $this->limit, $offset)))
		    	return array('error' => true, 'message' => $stmt->error);

		    // Εκτέλεση Ερωτήματος
		    if (!($stmt->execute()))
		    	return array('error' => true, 'message' => $stmt->error);

		    // Επανάληψη για διάβασμα εγγραφών
		    $res = $stmt->get_result();
		    while ($row = $res->fetch_array(MYSQLI_ASSOC))
	        {
	            $users[] = $row;
	        }
    		
    		// Αντικέιμενο για επιστροφή πληροφορίας απο τη μέθοδο 
		    $result = array('error' => false, 'data' => $users, 'pages' => $pages);

		    // Κλείσιμο ερωτήματος και σύνδεσης με τη βάση
		    $stmt->close();		
			$this->disconnect();

			return $result;
		}

		// Μέθοδος Προσθήκης Νέου Χρήστη
		function AddUser($lastname,$firstname,$username,$password,$role) {

			$result = $this->connect();
			if ($result['error'])
				return $result;

			// Ερώτημα εισαγωγής χρήστη στη βάση
			$stmt = $this->db->stmt_init();
			if (!($stmt = $this->db->prepare("INSERT INTO users (LastName,FirstName,Username,Password,Role) 
												VALUES (?,?,?,?,?)")))
				return array('error' => true, 'message' => $this->db->error);

			// Ανάθεση τιμών στις παραμέτρους του ερωτήματος
			if (!($stmt->bind_param("sssss",$lastname,$firstname,$username,$password,$role)))
		    	return array('error' => true, 'message' => $stmt->error);

		    // Εκτέλεση ερωτήματος
		    if (!($stmt->execute()))
		    	return array('error' => true, 'message' => $stmt->error);
    		
		    $result = array('error' => false, 'message' => "Επιτυχής εισαγωγή.");

		    $stmt->close();		
			$this->disconnect();

			return $result;
		}

		// Μέθοδος Ενημέρωσης Χρήστη
		function UpdateUser($lastname,$firstname,$username,$password,$role) {

			$result = $this->connect();
			if ($result['error'])
				return $result;

			// Ερώτημα ενημέρωσης χρήστη
			$stmt = $this->db->stmt_init();
			if (!($stmt = $this->db->prepare("UPDATE users SET LastName = ?, FirstName = ?, 
												Password = ?, Role = ? 
												WHERE Username = ?")))
				return array('error' => true, 'message' => $this->db->error);

			// Ανάθεση τιμών στις παραμέτρους του ερωτήματος
			if (!($stmt->bind_param("sssss",$lastname,$firstname,$password,$role,$username)))
		    	return array('error' => true, 'message' => $stmt->error);

		    // Εκτέλεση ερωτήματος
		    if (!($stmt->execute()))
		    	return array('error' => true, 'message' => $stmt->error);
    		
		    $result = array('error' => false, 'message' => "Επιτυχής αλλαγή.");

		    $stmt->close();		
			$this->disconnect();

			return $result;
		}

		// Μέθοδος Διαγραφής Χρήστη
		function DelUser($id) {

			$result = $this->connect();
			if ($result['error'])
				return $result;

			// Ερώτημα διαγραφής χρήστη
			$stmt = $this->db->stmt_init();
			if (!($stmt = $this->db->prepare("DELETE FROM users WHERE username = ?")))
				return array('error' => true, 'message' => $this->db->error);

			// Ανάθεση τιμών στις παραμέτρους του ερωτήματος
			if (!($stmt->bind_param("s", $id)))
		    	return array('error' => true, 'message' => $stmt->error);

		    // Εκτέλεση ερωτήματος
		    if (!($stmt->execute()))
		    	return array('error' => true, 'message' => $stmt->error);
    		
		    $result = array('error' => false, 'message' => "Επιτυχής διαγραφή.");

		    $stmt->close();		
			$this->disconnect();

			return $result;
		}

		// Μέθοδος Ανάκτησης όλων των προϊόντων
		// από τη βάση σε σελίδες
		function GetItems($page) {

			$result = $this->connect();
			if ($result['error'])
				return $result;

			// Ερώτημα για υπολογισμό του αριθμού σελίδων
			$total = $this->db->query('SELECT COUNT(*) total FROM items')->fetch_object()->total;
			$pages = ceil($total / $this->limit);

			// Ερώτημα ανάκτησης προϊόντων
			$stmt = $this->db->stmt_init();
			if (!($stmt = $this->db->prepare("SELECT itemid,name,description,price 
									FROM items ORDER BY name LIMIT ? OFFSET ?")))
				return array('error' => true, 'message' => $this->db->error);

			// Έλεγχος τρέχουσας σελίδας
			if($page >= $pages)
				$offset = 0;
			else
				$offset = $page * $this->limit;

			// Ανάθεση τιμών στις παραμέτρους του ερωτήματος			
			if (!($stmt->bind_param("ii", $this->limit, $offset)))
		    	return array('error' => true, 'message' => $stmt->error);

		    // Εκτέλεση Ερωτήματος
		    if (!($stmt->execute()))
		    	return array('error' => true, 'message' => $stmt->error);

		    // Επανάληψη για διάβασμα εγγραφών
		    $res = $stmt->get_result();
		    while ($row = $res->fetch_array(MYSQLI_ASSOC))
	        {
	            $items[] = $row;
	        }
    		
    		// Αντικέιμενο για επιστροφή πληροφορίας απο τη μέθοδο 
		    $result = array('error' => false, 'data' => $items, 'pages' => $pages);

		    // Κλείσιμο ερωτήματος και σύνδεσης με τη βάση
		    $stmt->close();		
			$this->disconnect();

			return $result;
		}

		// Μέθοδος Προσθήκης Νέου προϊόντος
		function AddItem($name,$description,$price) {

			$result = $this->connect();
			if ($result['error'])
				return $result;

			// Ερώτημα εισαγωγή προϊόντος
			$stmt = $this->db->stmt_init();
			if (!($stmt = $this->db->prepare("INSERT INTO items (Name,Description,Price) 
												VALUES (?,?,?)")))
				return array('error' => true, 'message' => $this->db->error);

			// Ανάθεση τιμών στις παραμέτρους του ερωτήματος
			if (!($stmt->bind_param("ssd",$name,$description,$price)))
		    	return array('error' => true, 'message' => $stmt->error);

		    // Εκτέλεση ερωτήματος
		    if (!($stmt->execute()))
		    	return array('error' => true, 'message' => $stmt->error);
    		
		    $result = array('error' => false, 'message' => "Επιτυχής εισαγωγή.");

		    // Κλείσιμο ερωτήματος και σύνδεσης με τη βάση
		    $stmt->close();		
			$this->disconnect();

			return $result;
		}

		// Μέθοδος ενημέρωσης προϊόντος
		function UpdateItem($itemid,$name,$description,$price) {

			$result = $this->connect();
			if ($result['error'])
				return $result;

			// Ερώτημα εισαγωγή προϊόντος
			$stmt = $this->db->stmt_init();
			if (!($stmt = $this->db->prepare("UPDATE items SET name = ?, description = ?, 
												price = ? 
												WHERE itemid = ?")))
				return array('error' => true, 'message' => $this->db->error);

			// Ανάθεση τιμών στις παραμέτρους του ερωτήματος
			if (!($stmt->bind_param("ssdi",$name,$description,$price,$itemid)))
		    	return array('error' => true, 'message' => $stmt->error);

		    // Εκτέλεση ερωτήματος
		    if (!($stmt->execute()))
		    	return array('error' => true, 'message' => $stmt->error);
    		
		    $result = array('error' => false, 'message' => "Επιτυχής αλλαγή.");

		    // Κλείσιμο ερωτήματος και σύνδεσης με τη βάση
		    $stmt->close();		
			$this->disconnect();

			return $result;
		}

		// Μέθοδος διαγραφής προϊόντος
		function DelItem($id) {

			$result = $this->connect();
			if ($result['error'])
				return $result;

			// Ερώτημα διαγραφής προϊόντος
			$stmt = $this->db->stmt_init();
			if (!($stmt = $this->db->prepare("DELETE FROM items WHERE itemid = ?")))
				return array('error' => true, 'message' => $this->db->error);

			// Ανάθεση τιμών στις παραμέτρους του ερωτήματος
			if (!($stmt->bind_param("i", $id)))
		    	return array('error' => true, 'message' => $stmt->error);

		    // Εκτέλεση ερωτήματος
		    if (!($stmt->execute()))
		    	return array('error' => true, 'message' => $stmt->error);
    		
		    $result = array('error' => false, 'message' => "Επιτυχής διαγραφή.");

		    // Κλείσιμο ερωτήματος και σύνδεσης με τη βάση
		    $stmt->close();		
			$this->disconnect();

			return $result;
		}

		// Μέθοδος Ανάκτησης όλων των παραγγελιών
		// από τη βάση σε σελίδες
		function GetOrders($page) {

			$result = $this->connect();
			if ($result['error'])
				return $result;

			// Ερώτημα για υπολογισμό του αριθμού σελίδων
			$total = $this->db->query('SELECT COUNT(*) total FROM orders')->fetch_object()->total;
			$pages = ceil($total / $this->limit);

			// Ερώτημα ανάκτησης των παραγγελιών
			$stmt = $this->db->stmt_init();
			if (!($stmt = $this->db->prepare("SELECT orderid,orders.itemid,quantity,OrderDateTime,
												orders.username,items.name,
												users.lastname,users.firstname,
												items.price, items.price * quantity total  
									FROM orders, items,users
                                    where items.itemid = orders.itemid and users.username = orders.username
                                    ORDER BY orderdatetime DESC LIMIT ? OFFSET ?")))
				return array('error' => true, 'message' => $this->db->error);

			// Έλεγχος τρέχουσας σελίδας
			if($page >= $pages)
				$offset = 0;
			else
				$offset = $page * $this->limit;

			// Ανάθεση τιμών στις παραμέτρους του ερωτήματος
			if (!($stmt->bind_param("ii", $this->limit, $offset)))
		    	return array('error' => true, 'message' => $stmt->error);

		    // Εκτέλεση ερωτήματος
		    if (!($stmt->execute()))
		    	return array('error' => true, 'message' => $stmt->error);

		    // Επάνάληψη για διάβασμα των εγγραφών
		    $res = $stmt->get_result();
		    while ($row = $res->fetch_array(MYSQLI_ASSOC))
	        {
	            $orders[] = $row;
	        }
    		
		    $result = array('error' => false, 'data' => $orders, 'pages' => $pages);

		    // Κλείσιμο ερωτήματος και σύνδεσης
		    $stmt->close();		
			$this->disconnect();

			return $result;
		}

		// Μέθοδος προσθήκης παραγγελίας
		function AddOrder($itemid,$quantity,$username) {

			$result = $this->connect();
			if ($result['error'])
				return $result;

			// Ερώτημα προσθήκης νέας παραγγελίας
			$stmt = $this->db->stmt_init();
			if (!($stmt = $this->db->prepare("INSERT INTO orders (itemid,quantity,username,orderdatetime) 
												VALUES (?,?,?,NOW())")))
				return array('error' => true, 'message' => $this->db->error);

			// Ανάθεση τιμών στις παραμέτρους του ερωτήματος			
			if (!($stmt->bind_param("iis",$itemid,$quantity,$username)))
		    	return array('error' => true, 'message' => $stmt->error);

		    // Εκτέλεση ερωτήματος
		    if (!($stmt->execute()))
		    	return array('error' => true, 'message' => $stmt->error);
    		
		    $result = array('error' => false, 'message' => "Επιτυχής εισαγωγή.");

		    // Κλείσιμο ερωτήματος και σύνδεσης
		    $stmt->close();		
			$this->disconnect();

			return $result;
		}

		// Μέθοδος ανάκτησης των 5 προϊόντων 
		// με τις περισσότερες και τις λιγότερες παραγγελίες
		function GetTopItems() {
			$result = $this->connect();
			if ($result['error'])
				return $result;

			// Ερώτημα ανάκτησης των 5 προϊόντων με τις περισσότερες παραγγελίες
			$stmt = $this->db->stmt_init();
			if (!($stmt = $this->db->prepare("SELECT items.name, sum(quantity) total
												FROM orders, items
			                                    where items.itemid = orders.itemid
			                                    group by items.name
			                                    ORDER BY total DESC LIMIT 5")))
				return array('error' => true, 'message' => $this->db->error);

		    if (!($stmt->execute()))
		    	return array('error' => true, 'message' => $stmt->error);

		    $res = $stmt->get_result();
		    while ($row = $res->fetch_array(MYSQLI_ASSOC))
	        {
	            $top[] = $row;
	        }

	        // Ερώτημα ανάκτησης των 5 προϊόντων με τις λιγότερες παραγγελίες
	        $stmt2 = $this->db->stmt_init();
			if (!($stmt2 = $this->db->prepare("SELECT items.name, sum(quantity) total
												FROM orders, items
			                                    where items.itemid = orders.itemid
			                                    group by items.name
			                                    ORDER BY total LIMIT 5")))
				return array('error' => true, 'message' => $this->db->error);

		    if (!($stmt2->execute()))
		    	return array('error' => true, 'message' => $stmt->error);

		    $res2 = $stmt2->get_result();
		    while ($row = $res2->fetch_array(MYSQLI_ASSOC))
	        {
	            $last[] = $row;
	        }
    		
		    $result = array('error' => false, 'top' => $top, 'last' => $last);

		    $stmt->close();		
		    $stmt2->close();
			$this->disconnect();

			return $result;			
		}

		// Μέθοδος ανάκτησης του συνολικού τζίρου του καταστήματος
		// για την τρέχουσα ημέρα, εβδομάδα και μήνα
		function GetSales(){
			$result = $this->connect();
			if ($result['error'])
				return $result;

			// Ερώτημα για τζίρο τρέχουσας ημέρας
			$stmt = $this->db->stmt_init();
			if (!($stmt = $this->db->prepare("SELECT sum(price) total 
												FROM orders, items 
												WHERE items.itemid = orders.itemid 
												AND DATE(orderdatetime)=CURDATE()")))
				return array('error' => true, 'message' => $this->db->error);

		    if (!($stmt->execute()))
		    	return array('error' => true, 'message' => $stmt->error);

		    $res = $stmt->get_result();
		    $row = $res->fetch_array(MYSQLI_ASSOC);
	        $day = $row['total'];
	        if($day == null) $day = 0;
	        
	        // Ερώτημα για τζίρο εβδομάδας
	        $stmt2 = $this->db->stmt_init();
			if (!($stmt2 = $this->db->prepare("SELECT sum(price) total 
												FROM orders, items 
												WHERE items.itemid = orders.itemid 
												AND YEARWEEK(orderdatetime)=YEARWEEK(CURDATE())")))
				return array('error' => true, 'message' => $this->db->error);

		    if (!($stmt2->execute()))
		    	return array('error' => true, 'message' => $stmt->error);

		    $res2 = $stmt2->get_result();
		    $row = $res2->fetch_array(MYSQLI_ASSOC);
	        $week = $row['total'];
	        if($week == null) $week = 0;

	        // Ερώτημα για τζίρο μήνα
	        $stmt3 = $this->db->stmt_init();
			if (!($stmt3 = $this->db->prepare("SELECT sum(price) total 
												FROM orders, items 
												WHERE items.itemid = orders.itemid 
												AND MONTH(orderdatetime)=MONTH(CURDATE())
												AND YEAR(orderdatetime)=YEAR(CURDATE())")))
				return array('error' => true, 'message' => $this->db->error);

		    if (!($stmt3->execute()))
		    	return array('error' => true, 'message' => $stmt->error);

		    $res3 = $stmt3->get_result();
		    $row = $res3->fetch_array(MYSQLI_ASSOC);
	        $month = $row['total'];
	        if($month == null) $month = 0;
    		
		    $result = array('error' => false, 'day' => $day, 'week' => $week, 'month' => $month);

		    $stmt->close();		
		    $stmt2->close();
		    $stmt3->close();
			$this->disconnect();

			return $result;
		}
	}
?>
