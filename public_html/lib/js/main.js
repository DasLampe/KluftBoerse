function dialog_action(text)
{
	text = ' <span>' + text + '</span>';
	$('#dialog-action').html(text);
	$('#dialog-action').show('blind');
	setTimeout("$('#dialog-action').hide('blind')", 5000);
}

