<?php
	/********************************

	Author: Tymoteusz `Razor Meister` Bartnik

	Contact: battnik90@gmail.com

	Function: get_vip_channel()

	********************************/

	function find_number($text, $phrase)
	{
		for($i = 0; $i<strlen($text); $i++)
		{
			$flag = true;
			if($text[$i] == $phrase['0'])
			{
				for($j=1; $j<strlen($phrase); $j++)
				{
					if($text[$i+$j] != $phrase[$j])
					{	
						$flag = false;
						break;
					}
				}
				if($flag)
				{	
					$number = null;
					for($k = $i+$j; $k<strlen($text); $k++)
						$number=$number.$text[$k];	

					return $number;
				}
				
			}
		}
	}

	function get_vip_channel($cfg, $useless)
	{
		global $query;
		global $cache;
		global $logs;

		global $connect, $name;
		if(strpos($connect['bot_name'], "(XBOT)") === false)
			die(write_info($name."Bot musi mieć w nazwie frazę (XBOT)"));
		
		global $language;
		$function_name = " [get_vip_channel] ";

		$cfg = $cfg['get_vip_channel']['info'];
		$how_many = count($cfg);

		for($i=0; $i<$how_many; $i++)
		{
			$clients = $query->getElement('data', $query->clientList("-ip"));
				
			$is_owner = false;
			$ip = true;
			$has_vip = false;
			$amount = 0;
			$number = 0;
			$current_ip = 0;
			
			foreach($clients as $client)
			{
				if($client['cid'] == $cfg[$i]['channel_id'])
				{
					$current_has_vip = false;
					$client_server_groups = $query->getElement('data', $query->serverGroupsByClientID($client['client_database_id']));

					foreach($client_server_groups as $client_server_group)
						if($client_server_group['sgid'] == $cfg[$i]['vip_server_group'])
						{
							$has_vip = true;
							$current_has_vip = true;
							$last_client_clid = $client['clid'];
							break;
						}

					if(!$current_has_vip && !$is_owner && strstr($client['client_nickname'], $cfg[$i]['owner_nick'])==true )
					{
						if($current_ip != $client['connection_client_ip'])
							$current_ip = $client['connection_client_ip'];
						else
							$ip = false;


						$client_number = find_number($client['client_nickname'], $cfg[$i]['owner_nick']);
						if($number == 0)
							$number = $client_number;

						if($number != 0 && $number == $client_number)
							$amount++;
						
						$is_owner = true;
						$owner['nick'] = $client['client_nickname'];
						$owner['clid'] = $client['clid'];
						$owner['dbid'] = $client['client_database_id'];
					}
					elseif(!$current_has_vip && strstr($client['client_nickname'], $cfg[$i]['nicks'])==true)
					{
						if($current_ip != @$client['connection_client_ip'])
							$current_ip = @$client['connection_client_ip'];
						else
							$ip = false;

						$client_number = find_number($client['client_nickname'], $cfg[$i]['nicks']);
						if($number == 0)
							$number = $client_number;

						if($number != 0 && $number == $client_number)
							$amount++;
					
						if(!$is_owner)
							$last_client_clid = $client['clid'];
					}
					else
						$last_client_clid = $client['clid'];
				}
			}
			unset($current_ip);
			unset($client_number);

			if(!$has_vip && $is_owner && $amount>=$cfg[$i]['how_many_peoples'] && $ip)
			{
				$channel_name = str_replace("[x]", $number, $cfg[$i]['empty_channels_names']);
				$channels = $query->getElement('data', $query->channelList("-topic"));
				$succes = false;
				
				foreach($channels as $channel)
				{
					if($channel['channel_name'] == $channel_name  && $channel['channel_topic'] == $cfg[$i]['topic'])
					{
						$query->sendMessage(1, $owner['clid'], $language['function']['get_vip_channel']['message'].$number);
						$query->clientMove($owner['clid'], $channel['cid']);
						$query->setClientChannelGroup($cfg[$i]['vip_channel_group'], $channel['cid'], $owner['dbid']);
						$query->serverGroupAddClient($cfg[$i]['vip_server_group'], $owner['dbid']);
						$desc = "[center][size=15]VIP[/size][/center]\n[size=10]\n● ".$language['function']['get_vip_channel']['desc_owner']."[b][color=green]".$owner['nick']."[/color][/b]\n● ".$language['function']['get_vip_channel']['desc_date']."[b][color=green]".date('d.m.Y')."[/color][/b][/size]";
						$desc .= $language['function']['down_desc'];
						$query->channelEdit($channel['cid'], array('channel_description' => $desc, 'channel_flag_maxclients_unlimited'=> 1, 'channel_flag_maxfamilyclients_unlimited'=> 1, 'channel_flag_maxfamilyclients_inherited'=> 0, 'channel_topic'=> date('d-m-Y')));
						
						for($j=1; $j<=$cfg[$i]['sub_channels']; $j++)
							$query->channelCreate(array('channel_flag_permanent' => 1, 'cpid' => $channel['cid'], 'channel_name' => ''.$j.'. Podkanal', 'channel_flag_maxclients_unlimited'=>1, 'channel_flag_maxfamilyclients_unlimited'=>1));
						
						$query->clientPoke($owner['nick'], $language['function']['get_vip_channel']['succes'].$owner['nick']);
						write_info($function_name.$language['function']['get_vip_channel']['succes'].$owner['nick']);
						$succes = true;
					}
				}
				
				if(!$succes)
				{
					$query->clientPoke($owner['clid'], $language['function']['get_vip_channel']['error_not_empty']);
					write_info($function_name.$language['function']['get_vip_channel']['error_not_empty']);

				}
			}
			elseif($has_vip)
			{
				$query->clientPoke($last_client_clid, $language['function']['get_vip_channel']['error_has_vip']);
				write_info($function_name.$language['function']['get_vip_channel']['error_has_vip']);
			}
			elseif(!$is_owner)
			{
				$query->clientPoke($last_client_clid, $language['function']['get_vip_channel']['error_owner'].$cfg[$i]['owner_nick']);
				write_info($function_name.$language['function']['get_vip_channel']['error_owner'].$cfg[$i]['owner_nick']);
			}
			elseif($amount != 0 && $amount<$cfg[$i]['how_many_peoples'])
			{
				$query->clientPoke($owner['clid'], $language['function']['get_vip_channel']['error_people']);
				write_info($function_name.$language['function']['get_vip_channel']['error_people']."  Owner: ".$owner['nick']);
			}
			elseif(!$ip)
			{
				$query->clientPoke($owner['clid'], $language['function']['get_vip_channel']['error_ip']);
				write_info($function_name.$language['function']['get_vip_channel']['error_ip']."  Owner: ".$owner['nick']);
			}
		}
		unset($query);
		unset($logs);
		unset($language);
	}
?>