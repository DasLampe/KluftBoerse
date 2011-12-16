$(document).ready(function () {
	// Return a helper with preserved width of cells
	var fixHelper = function(e, ui) {
		ui.children().each(function() {
			$(this).width($(this).width());
		});
		return ui;
	};

	$("#invoice tbody").sortable({
		items: "tr",
		placeholer: "ui-state-highlight"
	}).disableSelection();
	
	$('#show_items_select').click(function()
	{
		$('#items_select').toggle('blind', 'slow');
		return false;
	});
	
	$('select[id="client"]').change(function()
	{
		$.ajax({
			url: window.location+'/client_info',
			dataType: "html",
			data: "client_id="+$(this).val(),
			type: "post",
			success: function(data) {
				$('#client_info').html('<strong>Adresse:</strong><br/>'+data).show();
			}
		});
	});

	$('#items_select li').live('click', function() {
		$.ajax({
			url: window.location+'/item_info/'+$(this).attr('id'),
			dataType: "html",
			success: function(data) {
				var rows;
				$(data).appendTo('#invoice > tbody');
				rows	= $('#invoice > tbody > tr').length;

				$('#invoice > tbody > tr:last > td:first').html(rows);
				update_cost();
			}
		});
		$(this).remove();
	});

	$('#invoice > tbody > tr > td > input').live('change', function() {
		$(this).val($(this).val().replace(",","."));
		var parent, result;
		parent = $(this).parent().parent();
		result	= $(parent).find('input[name="cost[]"]').val() * $(this).val();
		$(parent).find('td:last').html(Math.round(result*100)/100 + '€');

		update_cost();
	});
	
	$('#new_invoice').submit(function() {
		$.ajax({
			url: $(this).attr('action')+'/submit',
			dataType: "html",
			data: $(this).serialize(),
			type: "post",
			success: function(data){
				dialog_action(data);
			},
			error: function(data){
				dialog_action("Es ist ein Fehler aufgetreten! Bitte erneut versuchen!");
			}
		});
		return false;
	});

	function update_cost()
	{
		result	= 0;
		for(var i=0;i<$('#invoice > tbody > tr').length;i++)
		{
			result	= parseFloat($('#invoice > tbody > tr:eq('+i+')').find('input[name="cost[]"]').val()) * parseFloat($('#invoice > tbody > tr:eq('+i+')').find('input[name="amount[]"]').val()) + result;
		}

		$('#cost_all').html(Math.round(result*100)/100 + '€');
		$('input[name="cost_all"]').val(Math.round(result*100)/100);
	}

});
