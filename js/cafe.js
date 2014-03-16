
$(document).ready(function(){
	$('table tr').click(function(){
		$("tr.info").removeClass('info');
		$(this).toggleClass('info');
	})
})

$('.confirm').click(function(e){
	var item = this;
    if (confirm(this.title)) {
    	$.ajax({
	      url: item.href,
	      type: "get",
	      dataType: "json",
	      success: function(data){
	      	if (data.error)
	      		alert(data.message);
	      	else
	        	$(item).closest('tr').remove();           
	      },
	      error:function(){
          	alert('error');
	      }   
	    }); 
		event.preventDefault();
	} else {
		event.preventDefault();
	}
})
