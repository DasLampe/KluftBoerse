<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Bootstrap -->
	<link href="<?= LINK_MAIN; ?>template/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link href="<?= LINK_MAIN; ?>template/lib/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
	{css_files}
	{js_files}
</head>
<body>
	<div class="container">
		<div class="masthead">
			<ul class="nav nav-pills pull-right">
				<li><a href="<?= LINK_MAIN; ?>">Infos</a></li>
				<li><a href="<?= LINK_MAIN; ?>offers/searching/">Gesuche</a></li>
				<li><a href="<?= LINK_MAIN; ?>offers/selling/">Verkäufe</a></li>
			</ul>
			<h1 class="muted">KluftBörse</h1>
		</div>
	</div>
	
	
	<div class="container">
		{page_content}
	</div>
</body>
</html>