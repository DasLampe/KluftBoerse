<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Bootstrap -->
	<link href="<?= LINK_MAIN; ?>template/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link href="<?= LINK_MAIN; ?>template/lib/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
	<link href="<?= LINK_MAIN; ?>template/css/style.css" rel="stylesheet">
	{css_files}
	
	<script language="JavaScript" type="text/javascript" src="<?= LINK_MAIN; ?>template/lib/jquery/jquery.min.js"></script>
	<script language="JavaScript" type="text/javascript" src="<?= LINK_MAIN; ?>template/js/webtoolkit.base64.js"></script>
	<script language="JavaScript" type="text/javascript" src="<?= LINK_MAIN; ?>core/helper/ramverkNotification/ramverkNotification.js"></script>
	<script type="text/javascript">
		$(document).ready(function () {
			$("a").each(function() {
				var href, mailaddress;
				href = $(this).attr("href");
		
				if(href.search(/mailto:/) != -1)
				{
					mailaddress = href.substr(6);
					mailaddress	= Base64.decode(mailaddress);
					$(this).attr("href", "mailto:"+mailaddress);
					
					if($(this).html().search(/ät|at|[ät]|[at]|{at}|{ät}/) != -1)
					{
						$(this).html(mailaddress);
					}
				}
			});
		});
	</script>
	
	{js_files}
</head>
<body>
	<div class="container">
		{page_content}
	</div>
	{ramverkNotification}
</body>
</html>