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
		echo '<li><a data-toggle="modal" href="#" data-backdrop="static" data-target="#myModal">';
		echo '<span class="glyphicon glyphicon-plus"> Νέος Χρήστης</a></li>';
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
			$message = "Να διαγραφεί ο χρήστης ".$user['username'].";";
			$url = "userdelete.php?id=".$user['username'];
			echo '<tr>';
			echo '<td>'.$user['lastname'].'</td>';
			echo '<td>'.$user['firstname'].'</td>';
			echo '<td>'.$user['username'].'</td>';
			echo '<td>'.$user['password'].'</td>';
			echo '<td>'.$user['role'].'</td>';
			
			echo '<td class="text-right">';
			echo '<button type="button" title="Αλλαγή" class="btn btn-primary edit" data-url="'.$url.'" data-message="'.$message.'">';
			echo '<span class="glyphicon glyphicon-edit"></a></td>';
			
			echo '<td class="text-right">';
			echo '<button type="button" title="Διαγραφή" class="btn btn-danger confirm" data-url="'.$url.'" data-message="'.$message.'">';
			echo '<span class="glyphicon glyphicon-remove"></button></td>';
			
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

	include "useredit.php";
?>