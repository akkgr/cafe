<?php
  	$db = new Db();
  	if (isset($_GET['page']))
  		$page = $_GET['page'];
  	else
  		$page = 0;
	$result = $db->GetItems($page);
	if ($result['error'])
	{
	  	echo '<div class="alert alert-danger">';
        echo '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
        echo '<strong>'.$result['message'].'</strong>';
        echo '</div>';
	}
	else {
		
		echo '<ul class="pagination">';
		echo '<li><a class="text-primary" href="index.php?action=new"><span class="glyphicon glyphicon-plus"> Νέο Προϊόν</a></li>';
		echo '<li><a class="text-primary"> Σελίδα: </a></li>';
		for ($i = 0;$i < $result['pages'];$i++) {
			if ($i == $page) {
				echo '<li class="active"><a href="index.php?action=items&page='.$i.'">'.($i + 1).'</a></li>';
			}
			else {
				echo '<li><a href="index.php?action=items&page='.$i.'">'.($i + 1).'</a></li>';
			}
		}
		echo '</ul>';

		echo '<table class="table table-hover">';
		echo '<th>Όνομα</th>';
		echo '<th>Περιγραφή</th>';
		echo '<th style="text-align:right;">Τιμή</th>';
		echo '<th></th>';
		echo '<th></th>';
		foreach ($result['data'] as $item) {
			echo '<tr>';
			echo '<td>'.$item['name'].'</td>';
			echo '<td>'.$item['description'].'</td>';
			echo '<td class="text-right">'.$item['price'].'</td>';
			echo '<td class="text-right">
			<a class="text-info" href="#">
			<span class="glyphicon glyphicon-edit">Αλλαγή</a></td>';
			echo '<td class="text-right">
			<a href="delitem.php?id='.$item['itemid'].'" class="text-danger confirm" title="Να διαγραφεί το προϊόν '.$item['name'].';">
			<span class="glyphicon glyphicon-remove">Διαγραφή</a></td>';
			echo '</tr>';
		}
		echo '</table>';

		echo '<ul class="pagination">';
		echo '<li><a class="text-primary" href="index.php?action=new"><span class="glyphicon glyphicon-plus"> Νέο Προϊόν</a></li>';
		echo '<li><a class="text-primary"> Σελίδα: </a></li>';
		for ($i = 0;$i < $result['pages'];$i++) {
			if ($i == $page) {
				echo '<li class="active"><a href="index.php?action=items&page='.$i.'">'.($i + 1).'</a></li>';
			}
			else {
				echo '<li><a href="index.php?action=items&page='.$i.'">'.($i + 1).'</a></li>';
			}
		}
		echo '</ul>';		
	}
?>