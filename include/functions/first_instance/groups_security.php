<?php
	/********************************

	Author: Tymoteusz `Razor Meister` Bartnik

	Contact: battnik90@gmail.com

	Function: groups_security()

	********************************/
	function groups_security($cfg, $client)
	{
		global $query;
		global $logs;
		global $language;
		$function_name = " [groups_security] ";
		$cfg = $cfg['groups_security'];
		$count = count($cfg['info']);
		$client_groups = explode(',', $client['client_servergroups']);

		global $connect, $name;
		if(strpos($connect['bot_name'], "(XBOT)") === false)
			die(write_info($name."Bot musi mieć w nazwie frazę (XBOT)"));
		
		for($i = 0; $i<$count; $i++)
		{	
			$info = $cfg['info'][$i];
			$ignored = $info['ignoredId'];
			$sgid = $info['groupsId'];

			if($cfg['info'][$i]['give_back'])
			{
				if(in_array($client['client_database_id'], $ignored) && !in_array($sgid, $client_groups))
					$query->serverGroupAddClient($sgid, $client['client_database_id']);	
			}
			if(in_array($info['groupsId'], $client_groups))
			{
				if(@$client['client_database_id']!=0)
				{
					$flag = true;
					if(in_array($client['client_database_id'], $ignored))
						$flag = false;
				
					if($flag)
					{	
						$choice = 0;
						$message = $info['message'];
			
						if($info['type'] == 'ban')
						{
							$choice = 1;
							$ban_time = $info['time'];
						}
						else if($info['type'] == 'kick')
							$choice = 2;
						else 
							$choice = 3;

						$uid = $client['client_unique_identifier'];
						$nick = $client['client_nickname'];
						$clid = $client['clid'];					

						switch($choice)
						{
							case 1:
								$query->banAddByUid($uid, $ban_time, $message);
								write_info($function_name.$nick.$language['logs']['groups_security']['ban'].$sgid);
								break;
							case 2:
								$query->clientKick($clid, "server", $message);
								write_info($function_name.$nick.$language['logs']['groups_security']['kick'].$sgid);
								break;
							case 3: 
								$query->clientPoke($clid, $message);
								write_info($function_name.$nick.$language['logs']['groups_security']['nothing'].$sgid);
								break;
						}
						
						$query->serverGroupDeleteClient($sgid, $client['client_database_id']);
					}	
				}
			}
		}
		unset($query);
		unset($logs);
		unset($language);
	}
?>