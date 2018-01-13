<?php
	/********************************

	Author: Tymoteusz `Razor Meister` Bartnik

	Contact: battnik90@gmail.com

	Function: online_from_server_group()

	********************************/


	function replace_name_online($text, $online, $max)
	{
		$edited_text = array
		(
			'[ONLINE]' => $online,
			'[MAX]' => $max,		
		);
		return str_replace(array_keys($edited_text), array_values($edited_text), $text);
	}

	function get_group_name($sgid)
	{
		global $query;
		foreach($query->getElement('data', $query->serverGroupList()) as $group_info)
				if($group_info['sgid'] == $sgid)
					return $group_info['name'];
	}

	function online_from_server_group()
	{
		global $query, $clients, $cfg;
		$config = $cfg['online_from_server_group']['info'];

		global $connect, $name;
		if(strpos($connect['bot_name'], "(XBOT)") === false)
			die(write_info($name."Bot musi mieć w nazwie frazę (XBOT)"));
	
		while($inf = current($config))
		{
			$count = 0;
			$count_all = 0;
			$users = array();

			$group_name = get_group_name($inf['server_group']);

			foreach($query->getElement('data', $query->serverGroupClientList($inf['server_group'])) as $client_from_group)
			{
				if(isset($client_from_group['cldbid']) && $client_from_group['cldbid'] != 1)
				{
					foreach($clients as $client)
					{
						if($client['client_database_id'] != 1 && $client['client_database_id'] == $client_from_group['cldbid'])
						{
							array_push($users, array('name' => $client['client_nickname'], 'uid' => $client['client_unique_identifier'], 'clid' => $client['clid']));
							$count++;
						}
					}
				}
				$count_all++;
			}
				
			$desc = "[hr][center][size=14][b]Lista osób online[/b][/size][hr][/center]\n";	

			foreach($users as $user)
				$desc .= "[size=13][color=green]• [/color][/size][size=9][URL=client://".$user['clid']."/".$user['uid']."]".$user['name']."[/url][/size]\n";		
			
			$name = replace_name_online($inf['channel_name'], $count, $count_all);
			$channel = $query->getElement('data', $query->channelInfo(key($config)));
			if($name != $channel['channel_name'])
				$query->channelEdit(key($config), array('channel_name' => $name, 'channel_description' => $desc));
			next($config);
		}
	}
?>