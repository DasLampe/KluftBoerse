<?php
// +----------------------------------------------------------------------+
// | Copyright (c) 2011 DasLampe <daslampe@lano-crew.org> |
// | Encoding:  UTF-8 |
// +----------------------------------------------------------------------+
class items
{
	public static function new_item($description, $cost, $name)
	{
		$db		= ImpeesaDb::getConnection();

		$insert	= $db->prepare("INSERT INTO item
								(description, cost, name)
								VALUES
								(:description, :cost, :name)");
		$insert->bindParam(":description",	$description);
		$insert->bindParam(":cost",			$cost, PDO::PARAM_INT);
		$insert->bindParam(":name",			$name);

		if($insert->execute())
		{
			return true;
		}
		return false;
	}

	public static function items2list()
	{
		$db		= ImpeesaDb::getConnection();

		$result	= $db->query("SELECT id, name, cost, description
							FROM item");
		$return	= "";
		while($row = $result->fetch())
		{
			$return .= '<li class="box" id="item_'.$row["id"].'">'.nl2br($row["description"]).'</li>';
		}
		return $return;
	}

	public static function get_info($item_id)
	{
		$db		= ImpeesaDb::getConnection();

		$result	= $db->prepare("SELECT id, name, cost, description
							FROM item
							WHERE id = :item_id");
		$result->execute(array(":item_id" => $item_id));

		$row	= $result->fetch(PDO::FETCH_ASSOC);

		return $row;
	}
}
