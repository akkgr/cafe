<!-- modal διάλογος που περιέχει την φόρμα με τα πεδία τοθ ποριόντος -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<form id="form" role="form">
                    <input type="hidden" id="itemid" name="itemid">
					<div class="form-group">
						<label for="name">Όνομα</label>
						<input type="text" class="form-control" id="name" name="name" placeholder="Όνομα">
					</div>
					<div class="form-group">
						<label for="description">Περιγραφή</label>
						<input type="text" class="form-control" id="description" name="description" placeholder="Περιγραφή">
					</div>
					<div class="form-group">
						<label for="price">Τιμή</label>
						<input type="text" class="form-control" id="price" name="price" placeholder="Τιμή">
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Άκυρο</button>
						<button type="submit" class="btn btn-primary">Αποθήκευση</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- τέλος διαλόγου -->

<script>
    // κώδικας για το validation της φόρμας
	$('#form').validate({
        // δήλωση κάνονων
        rules: {
            name: {
                required: true
            },
            description: {
                required: true
            },
            price: {
                required: true,
                number : true
            }
        },
        // κώδικας μορφοποίσης και δημιουργίας στοιχείων
        // αν υπάρχει παραβίαση των κονόνων ή όχι
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
        // κώδικας που αναλάμβάνει το submit
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