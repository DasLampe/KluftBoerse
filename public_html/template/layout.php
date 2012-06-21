<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<title>NixMuss Rechungen</title>
<!-- add your meta tags here -->
<?php include_once(PATH_PAGES."html_head.php"); ?>
<link href="<?= LINK_TPL; ?>css/my_layout.css" rel="stylesheet" type="text/css" />
</head>
<body>
		<div class="ym-skiplinks">
			<a class="skip" title="ym-skip" href="#navigation">Skip to the navigation</a><span class="hideme">.</span>
			<a class="skip" title="ym-skip" href="#content">Skip to the content</a><span class="hideme">.</span>
		</div>
<div class="ym-wrapper">
	<div class="ym-wbox">
	<header>
		<h1>NixMuss Rechnungen</h1>
	</header>
	<nav id="nav">
		<a id="navigation" name="navigation"></a>
		<div class="ym-hlist">
			<?php
				include_once(PATH_PAGES."menu.php");
			?>
		</div>
	</div>
	<div id="main">
		<div class="ym-wbox">
			<section class="ym-grid">
				<div class="ym-g20 ym-gl box">
					<div class="ym-gbox-left">
						<?php
							include_once(PATH_PAGES."col3.php");
						?>
					</div>
				</div>
				<div class="ym-g75 ym-gr content">
					<div class="ym-gbox-right ym-clearfix">
						<div id="dialog-action"></div>
						<?php
							include_once(PATH_PAGES.$page.".php");
						?>
					</div>
				</div>
			</section>
		</div>
		
		<div id="footer">Layout based on <a href="http://www.yaml.de/">YAML</a></div>
	</div>
</div>
</body>
</html>
