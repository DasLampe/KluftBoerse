<?php
// +----------------------------------------------------------------------+
// | Copyright (c) 2011 DasLampe <daslampe@lano-crew.org> |
// | Encoding:  UTF-8 |
// +----------------------------------------------------------------------+
if(!isset($param[1]) || $param[1] == "")
{
	$db			= ImpeesaDb::getConnection();

	$result 	= $db->query("SELECT id, cost, name, description
							FROM item");
?>
<table>
	<tr>
		<th>Beschreibung</th>
		<th>Kosten</th>
	</tr>
<?php
	while($row	= $result->fetch())
	{
?>
	<tr>
		<td><?= nl2br($row['description']); ?></td>
		<td><?= $row['cost'];?> €/<?= $row['name']; ?></td>
	</tr>
<?php
	}
?>
</table>
<p>
	<a href="<?= LINK_MAIN; ?>items/new" class="add">Neuen Textbaustein hinzufügen</a>
</p>
<?php
}
elseif($param[1] == "new")
{
	if(!isset($_POST['submit']) && (!isset($param[2]) || $param[2] == ""))
	{
?>
	<tr>
		<td colspan="2"><form id="new_item" action="<?= LINK_MAIN; ?>items/new" method="post">
		<textarea name="description" cols="30" rows="5"></textarea>
		<input type="text" name="cost" style="width: 50px;" />€ / <input type="text" name="name" style="width: 50px;" /><br/>
			<input type="submit" name="submit" value="Eintragen" />
		</form></td>
	</tr>
<?php
	}
	else
	{
		if(isset($_POST['submit']) || $param[2] == "submit")
		{
			if(items::new_item($_POST['description'], $_POST['cost'], $_POST['name']) === true)
			{
				echo "Erfolgreich eingetragen!";
			}
			else
			{
				echo "Es gab Probleme beim eintragen, bitte erneut versuchen!";
			}
		}
		else
		{
			echo "Irgendetwas ist schief gelaufen!";
		}
	}
}
