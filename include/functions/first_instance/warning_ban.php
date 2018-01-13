<?php 
	/********************************

	Author: Tymoteusz `Razor Meister` Bartnik

	Contact: battnik90@gmail.com

	Function: warning_ban()

	********************************/
	function warning_ban($cfg, $client)
	{
		global $query;
		global $logs;
		global $language;
		$function_name = " [warning_ban] ";

		$cfg = $cfg['warning_ban'];
		$ile = count($cfg['warning_id']);
		$dbid = array();
		$uid = array();
		$ban = array();

		for($j=0; $j<$ile; $j++)
			$ban[$j] = false;
		
		$flag = true;
		$c = 1;

		$groups = explode(',', $client['client_servergroups']);
		foreach($groups as $gr)
		{
			for($k=1; $k<$ile; $k++)
			{
				if($gr == $cfg['warning_id'][$k])
					$ban[$k] = true;
			}
		}

		for($k=1; $k<$ile; $k++)
		{	
			if(!$ban[$k])
			{
				$flag = false;
				break;
			}
		}

		if($flag)
		{
			write_info($function_name.$language['function']['warning_ban']['user_banned'].$client['client_nickname']);
			$query->banAddByUid($client['client_unique_identifier'], $cfg['ban_time'], $cfg['ban_message']);
			for($k=0; $k<$ile; $k++)
				$query->serverGroupDeleteClient($cfg['warning_id'][$k],$client['client_database_id']);		
		}

		unset($query);
		unset($logs);
		unset($language);
	}
?>