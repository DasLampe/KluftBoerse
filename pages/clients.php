<?php
// +----------------------------------------------------------------------+
// | Copyright (c) 2011 DasLampe <daslampe@lano-crew.org> |
// | Encoding:  UTF-8 |
// +----------------------------------------------------------------------+
?>
<h1>Kunden</h1>
<?php
if(!isset($param[1]) || $param[1] == "")
{
	$db		= ImpeesaDb::getConnection();
	
	$result	= $db->prepare("SELECT id, name, address
							FROM client
							ORDER BY name ASC");
	$result->execute();


	while($row = $result->fetch())
	{
		$invoice	= invoice::get_invoice_by_client($row['id']);
?>
<div class="box info">
	<h2><?= $row['name']; ?></h2>
	<div class="ym-grid">
		<div class="ym-g33 ym-gl">
			<div class="ym-gbox-left">
				<h3>Adresse</h3><br/>
				<address><?= nl2br($row['address']); ?></address>
			</div>
		</div>
		<div class="ym-g33 ym-gl">
			<div class="ym-gbox-left">
				<h3>Letzte Rechnung</h3>
				<p><?= date("d.m.Y", $invoice['invoice_date']); ?></p>
			</div>
		</div>
		<div class="ym-g33 ym-gr">
			<div class="ym-gbox-right">
				<h3>Umsatz</h3>
			</div>
		</div>
	</div>
</div>
<?php
	}
}