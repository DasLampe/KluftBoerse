<?php
// +----------------------------------------------------------------------+
// | Copyright (c) 2011 DasLampe <daslampe@lano-crew.org> |
// | Encoding:  UTF-8 |
// +----------------------------------------------------------------------+
class invoice
{
	public static function insert_invoice($client_id, array $item_id, array $amount, array $description)
	{
		$db		= ImpeesaDb::getConnection();

		$insert	= $db->prepare("INSERT INTO invoice
								(client_id, invoice_date)
								VALUES
								(:client_id, :invoice_date)");
		$timestamp = time();
		$insert->bindParam(":client_id",	$client_id, PDO::PARAM_INT);
		$insert->bindParam(":invoice_date",	$timestamp, PDO::PARAM_INT);
		$insert->execute();


		$invoice_id	= $db->lastInsertId();

		$insert = $db->prepare("INSERT INTO invoice_item
							(invoice_id, item_id, amount, description)
							VALUES
							(:invoice_id, :item_id, :amount, :description)");
		$insert->bindParam(":invoice_id",	$invoice_id, PDO::PARAM_INT);

		for($x=0;$x<count($item_id);$x++)
		{
			$insert->bindParam(":item_id",		$item_id[$x], PDO::PARAM_INT);
			$insert->bindParam(":amount",		$amount[$x], PDO::PARAM_INT);
			$insert->bindParam(":description",	$description[$x], PDO::PARAM_STR);
			$insert->execute();
		}

		return true;
	}


	public static function get_invoice_by_client($client_id)
	{
		$db			= ImpeesaDb::getConnection();

		$result 	= $db->prepare("SELECT invoice_date, invoice_id
									FROM invoice
									WHERE client_id = :client_id
									ORDER BY invoice_date DESC
									LIMIT 1");
		$result->bindParam(":client_id", $client_id);
		$result->execute();
		$row		= $result->fetch();
		return $row;
	}

	public static function get_invoice_gain($invoice_id)
	{
		$db		= impeesaDB::getConnection();

		$result = $db->prepare("SELECT invoice.item_id, invoice.amount, item.cost
								FROM invoice_item as invoice
								INNER JOIN item as item
								WHERE invoice_id = :invoice_id
								AND item.id = invoice.item_id");
		$result->bindParam(":invoice_id",	$invoice_id, PDO::PARAM_INT);
		$result->execute();

		$return = 0;
		while($row = $result->fetch())
		{
			$return += $row['cost'] * $row['amount'];
		}
		return sprintf("%.2f",$return);
	}

	public static function get_gain_last_time($timestamp_start, $timestamp_end)
	{
		$db		= impeesaDB::getConnection();

		$result = $db->prepare("SELECT invoice.item_id, invoice.amount, item.cost
										FROM invoice_item as invoice
										INNER JOIN item as item
										WHERE invoice_id IN (SELECT invoice_id
											FROM invoice
											WHERE invoice_date > :time_start
											AND invoice_date < :time_end)
										AND item.id = invoice.item_id");
		$result->bindParam(":time_start",	$timestamp_start, PDO::PARAM_INT);
		$result->bindParam(":time_end",		$timestamp_end, PDO::PARAM_INT);
		$result->execute();

		$return = 0;
		while($row = $result->fetch())
		{
			$return += $row['cost'] * $row['amount'];
		}
		return sprintf("%.2f",$return);
	}

	public static function get_client($invoice_id)
	{
		$db		= impeesaDB::getConnection();

		$result	= $db->prepare("SELECT client_id
								FROM invoice
								WHERE invoice_id = :invoice_id");
		$result->execute(array(":invoice_id" => $invoice_id));

		$row	= $result->fetch();
		return $row['client_id'];
	}

	public static function get_invoice($invoice_id)
	{
		$db		= impeesaDB::getConnection();

		$result	= $db->prepare("SELECT invoice.item_id, invoice.amount, item.cost, item.name, item.description as default_description, invoice.description
								FROM invoice_item as invoice
								INNER JOIN item as item
								WHERE invoice.invoice_id = :invoice_id
									AND item.id = invoice.item_id");
		$result->bindParam(":invoice_id",	$invoice_id, PDO::PARAM_INT);
		$result->execute();

		$return	= array();
		$x		= 1;
		while($row = $result->fetch())
		{
			if(empty($row['description']))
			{
				$row['description']	= $row['default_description'];
			}
			$return[]	= array(
								$x,
								$row['amount'].' '.$row['name'],
								$row['description'],
								sprintf("%.2f",$row['cost']),
								sprintf("%.2f",($row['cost'] * $row['amount'])),
								);
			$x++;
		}

		return $return;
	}

	public static function get_invoice_date($invoice_id)
	{
		$db			= ImpeesaDb::getConnection();

		$result 	= $db->prepare("SELECT invoice_date
									FROM invoice
									WHERE invoice_id = :invoice_id");
		$result->bindParam(":invoice_id", $invoice_id);
		$result->execute();
		$row		= $result->fetch();
		return $row['invoice_date'];
	}
	
	public static function get_cleared($invoice_id)
	{
		$db			= ImpeesaDb::getConnection();
		$result		= $db->prepare("SELECT cleared
									FROM invoice
									WHERE invoice_id = :invoice_id");
		$result->bindParam(":invoice_id", $invoice_id);
		$result->execute();
		$row		= $result->fetch();
		
		if($row['cleared'] == 1)
		{
			return "Bezahlt";
		}
		else
		{
			return "Offen";
		}
	}
	
	public static function set_cleared($invoice_id)
	{
		$db			= ImpeesaDb::getConnection();
		$result		= $db->prepare("UPDATE invoice SET
									cleared = 1
									WHERE invoice_id = :invoice_id");
		$result->bindParam(":invoice_id", $invoice_id);
		$result->execute();
		return true;
	}
}
