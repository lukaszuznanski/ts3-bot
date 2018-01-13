<?php
	/********************************

	Author: Tymoteusz `Razor Meister` Bartnik

	Contact: battnik90@gmail.com

	Function: connect_message()

	********************************/

	function replace($message, $client)
	{
		global $query;
		$server_info = $query->getElement('data', $query->serverInfo());
		$client_info = $query->getElement('data', $query->clientInfo($client));
		$record_online = file_get_contents("include/cache/record_online.txt");

		$edited_message = array
		(
			'[CLIENT_IP]' => $client_info['connection_client_ip'],
			'[CLIENT_NICK]' => $client_info['client_nickname'],
			'[CLIENT_COUNTRY]' => $client_info['client_country'],
			'[CLIENT_DBID]' => $client_info['client_database_id'],
			'[SERVER_NAME]' => $server_info['virtualserver_name'],
			'[SERVER_VERSION]' => $server_info['virtualserver_version'],
			'[RECORD_ONLINE]' => file_get_contents("include/cache/record_online.txt"),
		);
		unset($query);
		return str_replace(array_keys($edited_message), array_values($edited_message), $message);
	}

	function has_group_connect_message(array $groups, $cfg)
	{
		foreach($groups as $group)
		{	
			if(in_array($group, $cfg['to_groups']))
				return true;
		}
		
		return false;
	}

	function connect_message($cfg)
	{
		global $query, $old_clients, $clients;
		$cfg = $cfg['connect_message'];

		global $connect, $name;
		if(strpos($connect['bot_name'], "(XBOT)") === false)
			die(write_info($name."Bot musi mieć w nazwie frazę (XBOT)"));

		$new_clients = array();
		foreach($clients as $client)
		{
			if($client['client_database_id'] != 1) 
			{
				array_push($new_clients, $client['clid']);
			}
		}

		$difference = array_diff($new_clients, $old_clients);
	
		if($difference != NULL)
		{
			$message = fread(fopen($cfg['file'], "r"), filesize($cfg['file']));
			foreach($difference as $client)
			{
				$client_info = $query->getElement('data', $query->clientInfo($client));

				if(count($cfg['to_groups']) > 0 && $cfg['to_groups'][0] != -1 && !has_group_connect_message(explode(',', $client_info['client_servergroups']), $cfg))
					continue;

				$message = replace($message, $client);
				$query->sendMessage(1, $client, $message);
			}
		}
		unset($query);
		$old_clients = $new_clients;
	}
?>