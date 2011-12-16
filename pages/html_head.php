<?php
// +----------------------------------------------------------------------+
// | Copyright (c) 2011 DasLampe <daslampe@lano-crew.org> |
// | Encoding:  UTF-8 |
// +----------------------------------------------------------------------+
?>
<script language="JavaScript" type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js"></script>
<script language="JavaScript" type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.js"></script>
<script language="JavaScript" type="text/javascript" src="<?= LINK_LIB; ?>js/main.js"></script>
<?php
if(file_exists(PATH_LIB."js/".$page.".js"))
{
?>
	<script language="JavaScript" type="text/javascript" src="<?= LINK_LIB; ?>js/<?= $page; ?>.js"></script>
<?php
}
