
$(document).ready(function(){
	$('table tr').click(function(){
		$("tr.info").removeClass('info');
		$(this).toggleClass('info');
	})
})

$('.confirm').click(function(e){
	var message = $(this).data('message');
	var url = $(this).data('url');
	$(this).closest('tr').toggleClass("marked");
	$('#confirmMessage').text(message);
	$('.delete').data('target', url);
	$('#confirmDialog').modal('toggle');
})

$('.edit').click(function(e){
	$('#myModal').modal('toggle');
})

$('.delete').click(function(e){
	var item = $('.marked');
	$(item).toggleClass("marked");
	$('#confirmDialog').modal('toggle');
	var href = $(this).data('target');
	$.ajax({
      url: href,
      type: "get",
      dataType: "json",
      success: function(data){
      	if (data.error) {
      		$('#infoMessage').text(data.message);
      		$('#infoDialog').modal('toggle');
      	} else
        	$(item).closest('tr').remove();           
      },
      error:function(){
      	alert('error');
      }   
    }); 
})
