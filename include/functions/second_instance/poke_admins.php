<?php
	/********************************

	Author: Tymoteusz `Razor Meister` Bartnik

	Contact: battnik90@gmail.com

	Function: poke_admins()

	********************************/

	function admin_on_channel($cid, $admin_rangs)
	{
		global $clients, $cache_client_poke;
		foreach($clients as $client)
		{
			if($client['client_database_id'] != 1 && $client['cid'] == $cid)
			{
				$client_groups = explode(",", $client['client_servergroups']);

				foreach($client_groups as $client_group)	
					foreach($admin_rangs as $admin_rang)
						if(in_array($client_group, $admin_rang))
							return true;	
			}
		}
		return false;
	}

	function has_ignored(array $groups, $cfg)
	{
		foreach($groups as $group)
		{	
			if(in_array($group, $cfg['ignored_groups']))
				return true;
		}
		
		return false;
	}


	function poke_admins($useless, $client_info)
	{
		global $query, $server_info, $cfg, $language, $clients;
		$lang = $language['function']['poke_admins'];
		$admins = array();
		$config = $cfg['poke_admins']['info'];		

		while($admins_group = current($config)) 
		{
			foreach($clients as $client_inf)
			{
				if($client_inf['cid'] == key($config) && !has_ignored(explode(',', $client_inf['client_servergroups']), $cfg['poke_admins']))
				{
					if(!admin_on_channel(key($config), $config))
					{
						foreach($admins_group as $admin_group)
						{
							$clients_from_group = $query->getElement('data', $query->serverGroupClientList($admin_group));

							foreach($clients_from_group as $client_from_group)
							{
								if(isset($client_from_group['cldbid']) && $client_from_group['cldbid'] != 1)
								{
									foreach($clients as $client)
									{
										if($client['client_database_id'] != 1 && $client['client_database_id'] == $client_from_group['cldbid'])
										{
											$channel = $query->getElement('data', $query->channelInfo($client_inf['cid']));
											$query->clientPoke($client['clid'], "[color=blue][b]".$client_inf['client_nickname']."[/b][/color] ".$lang['wants_help']);
										}
									}
								}
							}
						}
					}
				}
			}

			next($config);
		}
	}
?>