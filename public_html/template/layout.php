<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<title>NixMuss Rechungen</title>
<!-- add your meta tags here -->
<?php include_once(PATH_PAGES."html_head.php"); ?>
<link href="<?= LINK_TPL; ?>css/my_layout.css" rel="stylesheet" type="text/css" />
<!--[if lte IE 7]>
<link href="<?= LINK_TPL; ?>css/patches/patch_my_layout.css" rel="stylesheet" type="text/css" />
<![endif]-->
</head>
<body>
  <div class="page_margins">
    <div class="page">
      <div id="header">
        <div id="topnav">
          <!-- start: skip link navigation -->
          <a class="skip" title="skip link" href="#navigation">Skip to the navigation</a><span class="hideme">.</span>
          <a class="skip" title="skip link" href="#content">Skip to the content</a><span class="hideme">.</span>
        </div>
        <h1>NixMuss Rechnungen</h1>
      </div>
      <div id="nav">
        <!-- skiplink anchor: navigation -->
        <a id="navigation" name="navigation"></a>
        <div class="hlist">
          <!-- main navigation: horizontal list -->
			<?php
				include_once(PATH_PAGES."menu.php");
			?>
        </div>
      </div>
      <div id="main">
        <div id="col1">
		  <div id="col1_content" class="clearfix">
			<div id="dialog-action"></div>
            <?php
            	include_once(PATH_PAGES.$page.".php");
            ?>
          </div>
        </div>
        <div id="col3">
          <div id="col3_content" class="clearfix">
            <?php
            	include_once(PATH_PAGES."col3.php");
            ?>
          </div>
          <!-- IE Column Clearing -->
          <div id="ie_clearing"> &#160; </div>
        </div>
      </div>
      <!-- begin: #footer -->
      <div id="footer">Layout based on <a href="http://www.yaml.de/">YAML</a>
      </div>
    </div>
  </div>
</body>
</html>
