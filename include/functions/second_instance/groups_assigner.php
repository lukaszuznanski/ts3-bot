<?php
	/********************************

	Author: Tymoteusz `Razor Meister` Bartnik

	Contact: battnik90@gmail.com

	Function: groups_assigner()

	********************************/

	function groups_assigner($cfg, $client)
	{
		global $query, $language;
		$function_name = " [groups_assigner] ";
		$cfg = $cfg['groups_assigner'];
		$has_register_rang = false;
		
		global $connect, $name;
		if(strpos($connect['bot_name'], "(XBOT)") === false)
			die(write_info($name."Bot musi mieć w nazwie frazę (XBOT)"));

		$client_groups =  explode(',', $client['client_servergroups']);
		foreach($cfg['register_groups'] as $group)
		{
			if(in_array($group, $client_groups))
			{
				$has_register_rang = true;
				$query->clientKick($client['clid'], "channel", $language['function']['groups_assigner']['has_rang']);
				break;
			}
		}

		if(!$has_register_rang)
		{
			while($sgid = current($cfg['info']))
			{
				if(key($cfg['info']) == $client['cid'])
				{
					$query->serverGroupAddClient($sgid, $client['client_database_id']);
					$query->clientKick($client['clid'], "channel", $language['function']['groups_assigner']['received_rang']);

				}
				next($cfg['info']);
			}
		}
		unset($query);
		unset($language);
	}
?>