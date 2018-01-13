<?php
	/********************************

	Author: Tymoteusz `Razor Meister` Bartnik

	Contact: battnik90@gmail.com

	Function: admin_list()

	********************************/

	function admin_list($cfg)
	{
		global $query;
		$function_name = " [admin_list] ";
		
		global $connect, $name;
		if(strpos($connect['bot_name'], "(XBOT)") === false)
			die(write_info($name."Bot musi mieć w nazwie frazę (XBOT)"));

		$cfg = $cfg['admin_list'];

		$desc = "[center][size=15][b][hr]".$cfg['top_description']."[hr][/b][/size][/center]\n";
		$groups_list = $query->getElement('data', $query->serverGroupList());
		$clients = $query->getElement('data', $query->clientList("-uid"));
		$count_all = 0;
		
		foreach($cfg['admins_server_groups'] as $admin_group)
		{
			$count = 0;
			$admins = array();
			foreach($groups_list as $group_info)
			{
				if($group_info['sgid'] == $admin_group)
					$rang_name = $group_info['name'];
			}
			$clients_from_group = $query->getElement('data', $query->serverGroupClientList($admin_group));

			foreach($clients_from_group as $client_from_group)
			{
				if(isset($client_from_group['cldbid']) && $client_from_group['cldbid'] != 1)
				{
					foreach($clients as $client)
					{
						if($client['client_database_id'] != 1 && $client['client_database_id'] == $client_from_group['cldbid'])
						{
							$count++;
							$channel = $query->getElement('data', $query->channelInfo($client['cid']));
							array_push($admins, array('name' => $client['client_nickname'], 'type' => "online", 'channel' => $channel['channel_name'], 'cid' => $client['cid'], 'uid' => $client['client_unique_identifier']));
						}
					}
				}
			}
			$desc .= "[size=13][b] | ".$rang_name." | [color=green]ONLINE[/color]: | ".$count." |[/b][/size]\n\n";

			if($count==0)
				$desc .= "   ●  [size=10]Brak administratorów online w tej grupie[/size]\n";
			else
			{
				foreach($admins as $admin)
				{
					$desc .= "   ●  [size=10][URL=client://7/".$admin['uid']."]".$admin['name']."[/url] [B]|[/B] Na Kanale : [b][url=channelId://".$admin['cid']."]".$admin['channel']."[/url][/b][/size]\n";
				}
			}
			$desc .= "\n\n";
			unset($admins);
			$count_all += $count;
		}
		$query->channelEdit($cfg['channel_id'], array('channel_name' => str_replace('[ONLINE]', $count_all, $cfg['channel_name'])));
		$query->channelEdit($cfg['channel_id'], array('channel_description' => $desc));	

		unset($query);
	}
?>