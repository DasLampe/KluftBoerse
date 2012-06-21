<?php
// +----------------------------------------------------------------------+
// | Copyright (c) 2011 DasLampe <daslampe@lano-crew.org> |
// | Encoding:  UTF-8 |
// +----------------------------------------------------------------------+
?>
<h1>Rechnungsübersicht</h1>
<?php
$db		= ImpeesaDb::getConnection();
$result	= $db->query("SELECT invoice_id, invoice_date, client_id
						FROM invoice
						WHERE storno = 0
						ORDER BY invoice_date DESC");
$rows	= $result->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="ym-grid">
	<div class="ym-g80 ym-gl">
		<div class="ym-gbox-left ym-clearfix">
<?php
foreach($rows as $row)
{
	$client = clients::get_all_info($row['client_id']);
?>
	<div class="box <?= (invoice::get_cleared($row['invoice_id']) == "Offen") ? "error" : "success"; ?>" id="invoice_<?= $row['invoice_id']; ?>">
		<h3><a class="invoice_cleared" title="<?= $row['invoice_id']; ?>">Rechnung Nr. <?= $row['invoice_id']; ?> - <?= $client['name']; ?> - <?= invoice::get_cleared($row['invoice_id']); ?></a></h3>
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
			<tr>
				<td colspan="2">
					<table>
						<tr>
							<th>Rechnungsposition</th>
							<th>Anzahl</th>
							<th>Einzelpreis</th>
						</tr>
						<?php foreach(invoice::get_invoice($row['invoice_id']) as $data) { ?>
						<tr>
							<td><?= $data[2]; ?></td>
							<td><?= $data[1]; ?></td>
							<td><?= $data[3]; ?></td>
						</tr>
						<?php } ?>
					</table>
		</table>
	</div>
<?php
}
?>
	</div>
	</div>
		<div class="ym-g20 ym-gr">
		<div class="ym-gbox-right">
			<div class="ym-vlist">
				<ul>
					<?php 
					foreach($rows as $row) {
						$cleared = invoice::get_cleared($row['invoice_id']);
					?>
						<li>
						<a href="#invoice_<?= $row['invoice_id']; ?>"><?= $row['invoice_id']; ?> - <?= $cleared ?></a></li>
					<?php 
					}
					?>
				</ul>
			</div>
		</div>
	</div>
</div>
