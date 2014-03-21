
<div class="modal fade" id="myModal" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<form id="form" role="form" method="post">
					<div class="form-group">
						<label for="lastname">Επώνυμο</label>
						<input type="text" class="form-control" id="lastname" name="lastname" placeholder="Επίθετο">
					</div>
					<div class="form-group">
						<label for="firstname">Όνομα</label>
						<input type="text" class="form-control" id="firstname" name="firstname" placeholder="Όνομα">
					</div>
					<div class="form-group">
						<label for="username">UserName</label>
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
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Άκυρο</button>
						<button type="button" class="btn btn-primary save">Αποθήκευση</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<script>
	$('#form').validate({
        rules: {
            firstname: {
                required: true
            },
            lastname: {
                required: true
            },
            username: {
                required: true
            },
            password: {
                required: true
            },
            role: {
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
        },
        submitHandler: function(form) {
        	var postData = $(form).serializeArray();
			var formURL = $(form).attr("action");
			$.ajax({
				url : formURL,
				type: "POST",
				data : postData,
				dataType: "json",
				success:function(data) {
					// έλεγχος δεδομένων που μας επέστρεψε η κλήση
					if (data.error) {
						// εμφάνιση μηνύματος με το σφάλμα που προέκυψε
						// στο  server
						$('#infoMessage').text(data.message);
						$('#infoDialog').modal('toggle');
					} else {
						// Η διεργασία στο server εκτελέστηκε επιτυχώς
						// ανανέωση σελίδας
						location.reload();
					}
				},
				error: function() {
					alert('error');
				}
			});
			return false;
        }
    });
</script>