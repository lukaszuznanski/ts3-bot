<?php
	/********************************

	Author: Tymoteusz `Razor Meister` Bartnik

	Contact: battnik90@gmail.com

	Function: get_private_channel()

	********************************/

	function get_private_channel($cfg, $client)
	{
		global $query, $language;
		$cfg = $cfg['get_private_channel'];

		global $connect, $name;
		if(strpos($connect['bot_name'], "(XBOT)") === false)
			die(write_info($name."Bot musi mieć w nazwie frazę (XBOT)"));

		$has_rang = false;
		$has_channel = false;
		$give_channel = false;
		$number = 0;

		if($cfg['send_messages'] == 'poke')
			$poke = true;
		else
			$poke = false;

		$client_groups = explode(',', $client['client_servergroups']);

		foreach($client_groups as $client_group)
		{
			if(in_array($client_group, $cfg['needed_server_group']))
				$has_rang = true;
		}

		if($has_rang)
		{
			$cgcl = $query->getElement('data', $query->channelGroupClientList(NULL, $client['client_database_id']));
			foreach($cgcl as $once_cgcl)
			{
				if($once_cgcl['cldbid'] == $client['client_database_id'] && $once_cgcl['cgid'] == $cfg['head_channel_admin'])
				{
					$has_channel = true;
					if($poke)
						$query->clientPoke($client['clid'], $language['function']['get_private_channel']['has_channel']);
					else
						$query->sendMessage(1, $client['clid'], $language['function']['get_private_channel']['has_channel']);

					$query->clientMove($client['clid'], $once_cgcl['cid']);

					break;
				}
			}
			if(!$has_channel)
			{
				$channels = $query->getElement('data', $query->channelList("-topic -limits -flags"));
				foreach($channels as $channel)
				{
					if($channel['pid'] == $cfg['channels_zone'])
					{
						$number++;			
	
						if(!$give_channel && $channel['channel_topic'] == $cfg['empty_channel_topic'])
						{
							if($poke)
								$query->clientPoke($client['clid'], $language['function']['get_private_channel']['get_channel']);
							else
								$query->sendMessage(1, $client['clid'], $language['function']['get_private_channel']['get_channel']);
						
							$data = date('d-m-Y');
							$query->clientMove($client['clid'], $channel['cid']);
							$query->setClientChannelGroup($cfg['head_channel_admin'], $channel['cid'], $client['client_database_id']);
							$query->channelEdit($channel['cid'], array
							(
								'channel_name' => $number.". ".$language['function']['get_private_channel']['channel_name'].$client['client_nickname'],
								'channel_description' => "[center][size=13]".$client['client_nickname']."[/size][/center]\n[color=green]".$language['function']['get_private_channel']['created']."[/color]".$data."\n".$language['function']['down_desc'],
								'channel_topic' => $data,
								'channel_flag_maxclients_unlimited'=>1, 
								'channel_flag_maxfamilyclients_unlimited'=>1, 
								'channel_flag_maxfamilyclients_inherited'=>0,
							));
						
							for($i=0; $i<$cfg['sub_channels']; $i++)
							{
								$num = $i;
								$num++;
								$query->channelCreate(array
								(
									'channel_flag_permanent' => 1, 
									'cpid' => $channel['cid'], 
									'channel_name' => $num.$language['function']['get_private_channel']['sub_channel'], 
									'channel_flag_maxclients_unlimited' => 1, 
									'channel_flag_maxfamilyclients_unlimited' => 1
								));
							}

							$give_channel = true;
							break;
						}
					}
				}
				if(!$give_channel)
				{
					if($poke)
						$query->clientPoke($client['clid'], $language['function']['get_private_channel']['no_empty']);
					else
						$query->sendMessage(1, $client['clid'], $language['function']['get_private_channel']['no_empty']);

					$query->clientKick($client['clid'], "channel");
				}
			}
		}
		elseif(!$has_rang)
		{
			if($poke)
				$query->clientPoke($client['clid'], $language['function']['get_private_channel']['hasnt_rang']);
			else
				$query->sendMessage(1, $client['clid'], $language['function']['get_private_channel']['hasnt_rang']);

			$query->clientKick($client['clid'], "channel");
		}



		unset($query);
		unset($language);
	}
?>