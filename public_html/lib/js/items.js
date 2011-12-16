$(document).ready(function () {
	$('a[class="add"]').click(function() {
		var link=$(this).attr("href");
		$.ajax({
			url: link,
			dataType: "html",
			success: function(data) {
				$(data).appendTo('table');
			},
			error: function(data) {
				alert("Leider ist ein Fehler aufgetreten!");
			}
		});
		return false;
	});

	$('#new_item').live("submit", function() {
		$.ajax({
			url: $(this).attr('action')+"/submit",
			dataType: "html",
			type: "post",
			data: $(this).serialize(),
			success: function(data) {
				var description, cost, name;
				dialog_action(data);

				description = $('textarea[name="description"]').val();
				cost		= $('input[name="cost"]').val();
				name		= $('input[name="name"]').val();

				$('tr:last').remove();
				$('<tr><td>'+description+'</td><td>'+cost+'€/'+name+'</td></tr>').appendTo('table');
			},
			error: function(data) {
				alert("Leider ist ein Fehler aufgetreten");
			}
		});
		return false;
	});
});
