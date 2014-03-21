
// Αλλαγή της css class στο click event των tr
// για να δώσουμε την αίσθηση της επιλεγμένης γραμμής
$(document).ready(function(){
	$('table tr').click(function(){
		$("tr.info").removeClass('info');
		$(this).toggleClass('info');
	})
})

// Εμφάνιση διαλόγου  για επιβαιβέωση διαγραφής
$('.confirm').click(function(e){
	var message = $(this).data('message');
	var url = $(this).data('url');
	$(this).closest('tr').toggleClass("marked");
	$('#confirmMessage').text(message);
	$('.delete').data('target', url);
	$('#confirmDialog').modal('toggle');
})

// Εμφάνιση διαλόγου επεξεργασίας εγγραφής
$('.edit').click(function(e){
	// αρχικοποίηση αντικειμένου από το data attribute του element
	var item = $(this).data('item');
	// Ανάθεση target
	$("#form").prop("action", $(this).data('url'));
	// Ανάθεση τιμών στα elements της form
	for(var propertyName in item) {
		$("#"+propertyName).val(item[propertyName]);
	}
	// αρχικοποίηση του validation
	$(".help-block").hide();
	$(".has-error").removeClass("has-error");
	// Εμφάνιση διαλόγου
	$('#myModal').modal('toggle');
})

// Εμφάνιση διαλόγου προσθήκης εγγραφής
$('.add').click(function(e){
	// Ανάθεση target
	$("#form").prop("action", $(this).data('url'));
	// αρχικοποίηση τιμών στα input elements της form
	$("form :input").each(function(){
		$(this).val('');
	});
	// Εμφάνιση διαλόγου
	$('#myModal').modal('toggle');
})

// Εκτέλεση διαγραφής με ajax κλήση
$('.delete').click(function(e){
	// αρχικοποίηση αντικειμένου επιλεγμένου element
	// η επιλόγη έχει γίνει σε προηγούμενο στάδιο 
	// με την αλλαγή της css κλάσης του element
	var item = $('.marked');
	// Απόεπιλογή του επιλεγμένου element
	$(item).toggleClass("marked");
	// κλείσιμο διαλόγου επιβαιβέωσης διαγραφής
	$('#confirmDialog').modal('toggle');
	// αρχικοποίηση υπερσυνδέσμου από το data attribute του element
	var href = $(this).data('target');
	// ajax κλήση υπερσυνδέσμου
	$.ajax({
		url: href,
		type: "get",
		dataType: "json",
		// επιτυχής κλήση
		success: function(data){
			// έλεγχος δεδομένων που μας επέστρεψε η κλήση
			if (data.error) {
				// εμφάνιση μηνύματος με το σφάλμα που προέκυψε
				// στο  server
				$('#infoMessage').text(data.message);
				$('#infoDialog').modal('toggle');
			} else {
				// Η διεργασία στο server εκτελέστηκε επιτυχώς
				// οπότε σβήνουμε τη γραμμή της εγγραφής
				$(item).closest('tr').remove();
			}
		},
		// ανεπιτυχής κλήση
		// εμφάνιση μηνύματος με το σφάλμα
		error:function(){
			alert('error');
		}
	});
})
