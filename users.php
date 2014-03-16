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
		echo '<li><a data-toggle="modal" href="#" data-backdrop="static" data-target="#myModal"><span class="glyphicon glyphicon-plus"> Νέος Χρήστης</a></li>';
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
			title="Διαγραφή χρήστης '.$user['username'].';">
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

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Δημιουργία Νέου Χρήστη</h4>
			</div>
			<div class="modal-body">
				<form id="form" role="form">
					<div class="form-group">
						<label for="lastname">Email address</label>
						<input type="text" class="form-control" id="lastname" name="lastname" placeholder="Επίθετο">
					</div>
					<div class="form-group">
						<label for="firstname">Email address</label>
						<input type="text" class="form-control" id="firstname" name="firstname" placeholder="Όνομα">
					</div>
					<div class="form-group">
						<label for="username">Email address</label>
						<input type="text" class="form-control" id="username" name="username" placeholder="UserName">
					</div>
					<div class="form-group">
						<label for="password">Password</label>
						<input type="password" class="form-control" id="password" name="password" placeholder="Password">
					</div>
					<div class="form-group">
						<label for="role">Ρόλος</label>
						<select class="form-control" id="role" name="role">
							<option>Διαχειριστής</option>
							<option>Σερβιτόρος</option>
						</select>
					</div>
					<button type="submit" class="btn btn-primary">Αποθήκευση</button>
				</form>
			</div>
		</div>
	</div>
</div>

<script>
	$('#form').validate({
        rules: {
            firstname: {
                minlength: 3,
                maxlength: 15,
                required: true
            },
            lastname: {
                minlength: 3,
                maxlength: 15,
                required: true
            }
        },
        highlight: function(element) {
            $(element).closest('.form-group').addClass('has-error');
        },
        unhighlight: function(element) {
            $(element).closest('.form-group').removeClass('has-error');
        },
        errorElement: 'span',
        errorClass: 'help-block',
        errorPlacement: function(error, element) {
            if(element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        }
    });
</script>