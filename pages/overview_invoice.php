<?php
// +----------------------------------------------------------------------+
// | Copyright (c) 2011 DasLampe <daslampe@lano-crew.org> |
// | Encoding:  UTF-8 |
// +----------------------------------------------------------------------+
?>
<h1>Rechnungsübersicht</h1>
<div id="accordion">
<?php
$db		= ImpeesaDb::getConnection();
$result	= $db->query("SELECT invoice_id, invoice_date, client_id
						FROM invoice
						ORDER BY invoice_date DESC");
while($row	= $result->fetch())
{
	$client = clients::get_all_info($row['client_id']);
?>
<h3 class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top"><a href="#">Rechnung Nr. <?= $row['invoice_id']; ?></a></h3>
	<div id="invoice_<?= $row['invoice_id']; ?>">
		<table style="width:75%">
			<tr>
				<td style="width:50%;">Kunde:</td>
				<td><?= $client['name']; ?>
			</tr>
			<tr>
				<td style="width:50%;">Rechnungsdatum:</td>
				<td><?= date("d.m.Y", $row['invoice_date']); ?></td>
			</tr>
			<tr>
				<td style="width:50%;">Rechnungsbetrag:</td>
				<td><?= invoice::get_invoice_gain($row['invoice_id']); ?> €</td>
			</tr>
			<tr>
				<td><a href="<?= LINK_MAIN; ?>print_invoice/<?= $row['invoice_id']; ?>">Rechnung drucken</a></td>
				<td><a href="<?= LINK_MAIN; ?>print_invoice/<?= $row['invoice_id']; ?>/save">Rechnung speichern</a></td>
			</tr>
		</table>
	</div>
<?php
}
?>
</div>
