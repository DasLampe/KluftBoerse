<?php
class clients
{
	static public function get_client_option()
	{
		$db		= impeesaDb::getConnection();

		$result = $db->query("SELECT id,name
					FROM client");
		$return = "";
		while($row = $result->fetch())
		{
			$return .= '<option value="'.$row['id'].'">'.$row['name'].'</option>';
		}
		return $return;
	}
	
	static public function get_all_info($client_id)
	{
		$db		= impeesaDB::getConnection();
		
		$result = $db->prepare("SELECT name,address
								FROM client
								WHERE id = :client_id");
		$result->execute(array(":client_id" => $client_id));
		
		$row	= $result->fetch();
		return $row;
	}

	static public function get_info($client_id)
	{
		$db		= impeesaDB::getConnection();

		$result = $db->prepare("SELECT address
								FROM client
								WHERE id = :client_id");
		$result->execute(array(":client_id" => $client_id));

		$row	= $result->fetch();
		return $row['address'];
	}
}
