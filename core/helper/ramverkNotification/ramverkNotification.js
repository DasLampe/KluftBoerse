$(document).ready(function() {
	//Remove info msg, if created by ramverkNotification
	$('#ramverkNotification_wrapper').each(function() {
		setTimeout("$('#ramverkNotification_wrapper').fadeOut('slow')", 5000);
		setTimeout("$('#ramverkNotification_wrapper').remove()", 6000); //Hack to remove container, but show nice fade out.
	});	
});

/*
 * Message handling
 * Show Info messages, like error or success
 */
function show_msg(msg, status) {
	$('body').append('<dic id="ramverkNotification_wrapper"><div class="ramverkNotification_msg"></div></div>');
	$('#ramverkNotifiction_wrapper > .msg').addClass(status).html(msg);
	setTimeout("$('#ramverkNotification_wrapper').fadeOut('slow')", 5000);
	setTimeout("$('ramverkNotification_wrapper').remove()", 6000); //Hack to remove container, but show nice fade out.
}