<?php
	class Db
	{
		private $dbhost = "localhost";
		private $dbuser = "root";
		private $dbpass = "";
		private $database = "cafe";
		private $db;
		private $limit = 20;

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

		private function disconnect() {

			/* Κλείσιμο σύνδεσης */
			$this->db->close();

		}

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

		function GetUsers($page) {

			$result = $this->connect();
			if ($result['error'])
				return $result;


			$total = $this->db->query('SELECT COUNT(*) total FROM users')->fetch_object()->total;
			$pages = ceil($total / $this->limit);

			$stmt = $this->db->stmt_init();
			if (!($stmt = $this->db->prepare("SELECT lastname,firstname,username,password,role 
									FROM users ORDER BY lastname,firstname LIMIT ? OFFSET ?")))
				return array('error' => true, 'message' => $this->db->error);

			if($page >= $pages)
				$offset = 0;
			else
				$offset = $page * $this->limit;

			if (!($stmt->bind_param("ii", $this->limit, $offset)))
		    	return array('error' => true, 'message' => $stmt->error);

		    if (!($stmt->execute()))
		    	return array('error' => true, 'message' => $stmt->error);

		    $res = $stmt->get_result();
		    while ($row = $res->fetch_array(MYSQLI_ASSOC))
	        {
	            $users[] = $row;
	        }
    		
		    $result = array('error' => false, 'data' => $users, 'pages' => $pages);

		    $stmt->close();		
			$this->disconnect();

			return $result;
		}

		function DelUser($id) {

			$result = $this->connect();
			if ($result['error'])
				return $result;

			$stmt = $this->db->stmt_init();
			if (!($stmt = $this->db->prepare("DELETE FROM users WHERE username = ?")))
				return array('error' => true, 'message' => $this->db->error);


			if (!($stmt->bind_param("s", $id)))
		    	return array('error' => true, 'message' => $stmt->error);

		    if (!($stmt->execute()))
		    	return array('error' => true, 'message' => $stmt->error);
    		
		    $result = array('error' => false, 'message' => "Επιτυχής διαγραφή.");

		    $stmt->close();		
			$this->disconnect();

			return $result;
		}

		function GetItems($page) {

			$result = $this->connect();
			if ($result['error'])
				return $result;

			$total = $this->db->query('SELECT COUNT(*) total FROM items')->fetch_object()->total;
			$pages = ceil($total / $this->limit);

			$stmt = $this->db->stmt_init();
			if (!($stmt = $this->db->prepare("SELECT itemid,name,description,price 
									FROM items ORDER BY name LIMIT ? OFFSET ?")))
				return array('error' => true, 'message' => $this->db->error);

			if($page >= $pages)
				$offset = 0;
			else
				$offset = $page * $this->limit;

			if (!($stmt->bind_param("ii", $this->limit, $offset)))
		    	return array('error' => true, 'message' => $stmt->error);

		    if (!($stmt->execute()))
		    	return array('error' => true, 'message' => $stmt->error);

		    $res = $stmt->get_result();
		    while ($row = $res->fetch_array(MYSQLI_ASSOC))
	        {
	            $items[] = $row;
	        }
    		
		    $result = array('error' => false, 'data' => $items, 'pages' => $pages);

		    $stmt->close();		
			$this->disconnect();

			return $result;
		}

		function DelItem($id) {

			$result = $this->connect();
			if ($result['error'])
				return $result;

			$stmt = $this->db->stmt_init();
			if (!($stmt = $this->db->prepare("DELETE FROM items WHERE itemid = ?")))
				return array('error' => true, 'message' => $this->db->error);


			if (!($stmt->bind_param("i", $id)))
		    	return array('error' => true, 'message' => $stmt->error);

		    if (!($stmt->execute()))
		    	return array('error' => true, 'message' => $stmt->error);
    		
		    $result = array('error' => false, 'message' => "Επιτυχής διαγραφή.");

		    $stmt->close();		
			$this->disconnect();

			return $result;
		}

		function GetOrders($page) {

			$result = $this->connect();
			if ($result['error'])
				return $result;


			$total = $this->db->query('SELECT COUNT(*) total FROM orders')->fetch_object()->total;
			$pages = ceil($total / $this->limit);

			$stmt = $this->db->stmt_init();
			if (!($stmt = $this->db->prepare("SELECT orderid,orders.itemid,quantity,OrderDateTime,
												orders.username,items.name,
												users.lastname,users.firstname,
												items.price, items.price * quantity total  
									FROM orders, items,users
                                    where items.itemid = orders.itemid and users.username = orders.username
                                    ORDER BY orderdatetime DESC LIMIT ? OFFSET ?")))
				return array('error' => true, 'message' => $this->db->error);

			if($page >= $pages)
				$offset = 0;
			else
				$offset = $page * $this->limit;

			if (!($stmt->bind_param("ii", $this->limit, $offset)))
		    	return array('error' => true, 'message' => $stmt->error);

		    if (!($stmt->execute()))
		    	return array('error' => true, 'message' => $stmt->error);

		    $res = $stmt->get_result();
		    while ($row = $res->fetch_array(MYSQLI_ASSOC))
	        {
	            $orders[] = $row;
	        }
    		
		    $result = array('error' => false, 'data' => $orders, 'pages' => $pages);

		    $stmt->close();		
			$this->disconnect();

			return $result;
		}
	}
?>
