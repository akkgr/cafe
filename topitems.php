<?php
  	$db = new Db();
	$result = $db->GetTopItems();
	if ($result['error'])
	{
	  	echo '<div class="alert alert-danger">';
        echo '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
        echo '<strong>'.$result['message'].'</strong>';
        echo '</div>';
	}
	else {
		
		echo '<h3>Προιόντα με τις περισσότερες πωλήσεις</h3>';
		echo '<table class="table table-hover">';
		echo '<th>Προιόν</th>';
		echo '<th style="text-align:right;">Ποσότητα</th>';
		foreach ($result['top'] as $order) {
			echo '<tr>';
			echo '<td>'.$order['name'].'</td>';
			echo '<td style="text-align:right;">'.$order['total'].'</td>';
			echo '</tr>';
		}
		echo '</table>';

		echo '<h3>Προιόντα με τις λιγότερες πωλήσεις</h3>';
		echo '<table class="table table-hover">';
		echo '<th>Προιόν</th>';
		echo '<th style="text-align:right;">Ποσότητα</th>';
		foreach ($result['last'] as $order) {
			echo '<tr>';
			echo '<td>'.$order['name'].'</td>';
			echo '<td style="text-align:right;">'.$order['total'].'</td>';
			echo '</tr>';
		}
		echo '</table>';
		
	}
?>