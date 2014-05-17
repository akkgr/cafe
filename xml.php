<form id="form" role="form" action="createxml.php" method="post" target="_blank">
    <div class="form-group">
        <label for="name">Από Ημερομηνία</label>
        <input type="date" class="form-control" id="date_start" name="date_start" placeholder="YYYY-MM-DD">
    </div>
    <div class="form-group">
        <label for="name">Έως Ημερομηνία</label>
        <input type="date" class="form-control" id="date_end" name="date_end" placeholder="YYYY-MM-DD">
    </div>
    <button type="submit" class="btn btn-primary">Αρχείο XML</button>
</form>

<script>
    // κώδικας για το validation της φόρμας
    $('#form').validate({
        // δήλωση κάνονων
        rules: {
            date_start: {
                required: true
            },
            date_end: {
                required: true
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
    });
</script>