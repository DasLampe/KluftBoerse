<?php
if(!isset($param[1]) || $param[1] == "")
{
?>
	<h1>Neue Rechnung</h1>
	<form id="new_invoice" action="<?=LINK_MAIN; ?>new_invoice" method="post" class="yform">
		<fieldset>
			<legend>Kunde</legend>
			<div class="type-select">
				<label for="client">Kunden Auswahl</label>
				<select name="client" id="client" size="1">
					<option value="0" selected="selected" disabled="disabled">Bitte auswählen</option>
					<?= clients::get_client_option(); ?>
				</select>
			</div>
			<div id="client_info" style="display: hide;"></div>
		</fieldset>
		<fieldset>
			<legend>Tätigkeiten</legend>
			<a href="#" id="show_items_select">Tätigkeit hinzufügen</a>
			<div id="items_select" style="display: none;">
				<ul>
					<?= items::items2list(); ?>
				</ul>
			</div>
			<table id="invoice">
				<thead>
					<tr>
						<th>Position</th>
						<th>Anzahl</th>
						<th></th>
						<th>Bezeichung</th>
						<th>Einzelpreis</th>
						<th>Gesamtpreis</th>
					</tr>
				</thead>
				<tbody>

				</tbody>
				<tfoot>
					<tr>
						<td colspan="5">Gesamtpreis <input type="hidden" name="cost_all" value="0" /></td>
						<td id="cost_all">0</td>
					</tr>
				</tfoot>
			</table>
		</fieldset>
		<div class="type-button">
			<input type="submit" name="submit" value="Rechnung schreiben" />
		</div>
	</form>
<?
}
elseif($param[1] == "client_info")
{
	echo nl2br(clients::get_info($_POST['client_id']));
}
elseif($param[1] == "item_info")
{
	$item_id	= explode("item_", $param[2]);
	$items		= items::get_info($item_id[1]);
?>
	<tr id="<?= $param[2] ?>">
		<td></td>
		<td><input type="hidden" name="item_id[]" value="<?= $items['id'] ?>" /><input type="text" name="amount[]" value="1" /></td>
		<td><?= $items['name']; ?></td>
		<td><?= nl2br($items['description']); ?></td>
		<td><?= $items['cost']; ?>€ <input type="hidden" name="cost[]" value="<?=$items['cost']; ?>" /></td>
		<td><?= $items['cost']; ?>€</td>
	</tr>
<?php
}
elseif($param[1] == "submit")
{
	if(invoice::insert_invoice($_POST['client'], $_POST['item_id'], $_POST['amount']) === true)
	{
		echo "Rechnung erfolgreich gespeichert!";
	}
	else
	{
		echo "Es ist ein Fehler beim speichern aufgetreten!";
	}
}
