$(document).ready(function () {
	$('.invoice_cleared').click(function() {
		var link = $(this);
		$.ajax({
			url: "invoice_cleared",
			dataType: "html",
			data: "invoice_id="+$(this).attr('title'),
			type: "post",
			success: function(data) {
				$('#invoice_'+link.attr('title')).addClass("success");
			}
		});
		return false;
	});
});