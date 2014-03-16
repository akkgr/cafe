<?php
  	$db = new Db();
  	if (isset($_GET['page']))
  		$page = $_GET['page'];
  	else
  		$page = 0;
	$result = $db->GetUsers($page);
	if ($result['error'])
	{
	  	echo '<div class="alert alert-danger">';
        echo '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
        echo '<strong>'.$result['message'].'</strong>';
        echo '</div>';
	}
	else {
		echo '<ul class="pagination">';
		echo '<li><a class="text-primary" href="index.php?action=new"><span class="glyphicon glyphicon-plus"> Νέος Χρήστης</a></li>';
		echo '<li><a class="text-primary"> Σελίδα: </a></li>';
		for ($i = 0;$i < $result['pages'];$i++) {
			if ($i == $page) {
				echo '<li class="active"><a href="index.php?action=users&page='.$i.'">'.($i + 1).'</a></li>';
			}
			else {
				echo '<li><a href="index.php?action=users&page='.$i.'">'.($i + 1).'</a></li>';
			}
		}
		echo '</ul>';

		echo '<table class="table table-hover">';
		echo '<th>Επώνυμο</th>';
		echo '<th>Όνομα</th>';
		echo '<th>UserName</th>';
		echo '<th>Password</th>';
		echo '<th>Ρόλος</th>';
		echo '<th></th>';
		echo '<th></th>';
		foreach ($result['data'] as $user) {
			echo '<tr>';
			echo '<td>'.$user['lastname'].'</td>';
			echo '<td>'.$user['firstname'].'</td>';
			echo '<td>'.$user['username'].'</td>';
			echo '<td>'.$user['password'].'</td>';
			echo '<td>'.$user['role'].'</td>';
			echo '<td class="text-right">
			<a class="text-info" href="index.php?action=edit">
			<span class="glyphicon glyphicon-edit">Αλλαγή</a></td>';
			echo '<td class="text-right">
			<a href="deluser.php?id='.$user['username'].'" class="text-danger confirm" 
			title="Να διαγραφεί ο χρήστης '.$user['username'].';">
			<span class="glyphicon glyphicon-remove">Διαγραφή</a></td>';
			echo '</tr>';
		}
		echo '</table>';
		
		echo '<ul class="pagination">';
		echo '<li><a class="text-primary" href="index.php?action=new"><span class="glyphicon glyphicon-plus"> Νέος Χρήστης</a></li>';
		echo '<li><a class="text-primary"> Σελίδα: </a></li>';
		for ($i = 0;$i < $result['pages'];$i++) {
			if ($i == $page) {
				echo '<li class="active"><a href="index.php?action=users&page='.$i.'">'.($i + 1).'</a></li>';
			}
			else {
				echo '<li><a href="index.php?action=users&page='.$i.'">'.($i + 1).'</a></li>';
			}
		}
		echo '</ul>';
	}
?>