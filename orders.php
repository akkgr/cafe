<?php
  	$db = new Db();
  	if (isset($_GET['page']))
  		$page = $_GET['page'];
  	else
  		$page = 0;
	$result = $db->GetOrders($page);
	if ($result['error'])
	{
	  	echo '<div class="alert alert-danger">';
        echo '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
        echo '<strong>'.$result['message'].'</strong>';
        echo '</div>';
	}
	else {
		echo '<ul class="pagination">';
		echo '<li><a class="text-primary"> Σελίδα: </a></li>';
		for ($i = 0;$i < $result['pages'];$i++) {
			if ($i == $page) {
				echo '<li class="active"><a href="index.php?action=orders&page='.$i.'">'.($i + 1).'</a></li>';
			}
			else {
				echo '<li><a href="index.php?action=orders&page='.$i.'">'.($i + 1).'</a></li>';
			}
		}
		echo '</ul>';
		echo '<table class="table table-hover">';
		echo '<th>Ημερομηνία</th>';
		echo '<th>Σερβιτόρος</th>';
		echo '<th>Προιόν</th>';
		echo '<th style="text-align:right;">Τιμή</th>';
		echo '<th style="text-align:right;">Ποσότητα</th>';
		echo '<th style="text-align:right;">Σύνολο</th>';
		foreach ($result['data'] as $order) {
			echo '<tr>';
			echo '<td>'.$order['OrderDateTime'].'</td>';
			echo '<td>'.$order['lastname'].' '.$order['firstname'].'</td>';
			echo '<td>'.$order['name'].'</td>';
			echo '<td style="text-align:right;">'.$order['price'].'</td>';
			echo '<td style="text-align:right;">'.$order['quantity'].'</td>';
			echo '<td style="text-align:right;">'.$order['total'].'</td>';
			echo '</tr>';
		}
		echo '</table>';
		echo '<ul class="pagination">';
		echo '<li><a class="text-primary"> Σελίδα: </a></li>';
		for ($i = 0;$i < $result['pages'];$i++) {
			if ($i == $page) {
				echo '<li class="active"><a href="index.php?action=orders&page='.$i.'">'.($i + 1).'</a></li>';
			}
			else {
				echo '<li><a href="index.php?action=orders&page='.$i.'">'.($i + 1).'</a></li>';
			}
		}
		echo '</ul>';
	}
?>