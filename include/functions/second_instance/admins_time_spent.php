<?php
	/********************************

	Author: Tymoteusz `Razor Meister` Bartnik

	Contact: battnik90@gmail.com

	Function: record_online()

	********************************/

	function client_in_group(array $groups, $cfg)
	{
		foreach($groups as $group)
		{	
			if(in_array($group, $cfg['admins_groups']))
				return true;
		}
		
		return false;
	}

	function get_cache()
	{
		return json_decode(file_get_contents("include/cache/statistics.txt"), true);
	}

	function set_cache($cache)
	{
		file_put_contents("include/cache/statistics.txt", json_encode($cache));
	}

	function tip_of_words($num, $for1, $for234, $for_others)
	{
		$text = " ".$num." ";
		if($num == 1)
			return $text.$for1;
		elseif(in_array($num%10, array(2,3,4)))
			return $text.$for234;
		else return $text.$for_others; 
	}

	function convert_to_time($seconds)
	{
		global $language;

		$lang = $language['function'];

		$text = "";
		$uptime['d']=floor($seconds / 86400);
		$uptime['h']=floor(($seconds - ($uptime['d'] * 86400)) / 3600);
		$uptime['m']=floor(($seconds - (($uptime['d'] * 86400)+($uptime['h']*3600))) / 60);
		$uptime['s']=floor(($seconds - (($uptime['d'] * 86400)+($uptime['h']*3600)+($uptime['m'] * 60))));

		
		if($uptime['d'] != 0)
			$text .= tip_of_words($uptime['d'], $lang['one_day'], $lang['2_days'], $lang['other_days']);
		if($uptime['h'] != 0)
			$text .= tip_of_words($uptime['h'], $lang['one_hour'], $lang['2_hours'], $lang['other_hours']);
		if($uptime['m'] != 0)
			$text .= tip_of_words($uptime['m'], $lang['one_minute'], $lang['2_minutes'], $lang['other_minutes']);
		if($text == '') 
			$text .= $uptime['s'].' '.$lang['seconds'].' ';


		return $text;
	}


	function admins_time_spent($cfg)
	{
		global $query, $clients, $language;
		
		global $connect, $name;
		if(strpos($connect['bot_name'], "(XBOT)") === false)
			die(write_info($name."Bot musi mieć w nazwie frazę (XBOT)"));
		
		$cfg = $cfg['admins_time_spent'];

		$admins = array();
		
		$interval = convert_to_seconds($cfg['time_interval']);

		/*foreach($clients as $client)
		{
			if(client_in_group(explode(",", $client['client_servergroups']), $cfg))
				$admins[$client['client_database_id']] = $client;
		}*/


		$result = get_cache();
		foreach($clients as $client)
		{
			if($client['client_type'] == 1)
				continue;
			
			$clients_groups = explode(',', $client['client_servergroups']);
			
			foreach($cfg['admins_groups'] as $group)
			{
				if(in_array($group, $clients_groups))
				{
					if(isset($result[$client['client_database_id']]))
					{
						$result[$client['client_database_id']]['time_day_time'] += $interval;
						$result[$client['client_database_id']]['time_week_time'] += $interval;
						$result[$client['client_database_id']]['time_month_time'] += $interval;
						$result[$client['client_database_id']]['time_total_time'] += $interval;
					}
					else
					{
						$result[$client['client_database_id']]['database_id'] = $client['client_database_id'];
						$result[$admin['database_id']]['time_day_start'] = date('d');
						$result[$admin['database_id']]['time_week_start'] = date('W');
						$result[$admin['database_id']]['time_month_start'] = date('F');
						$result[$client['client_database_id']]['time_day_time'] = $interval;
						$result[$client['client_database_id']]['time_week_time'] = $interval;
						$result[$client['client_database_id']]['time_month_time'] = $interval;
						$result[$client['client_database_id']]['time_total_time'] = $interval;
					}
					break;				
				}
			}
		}
		

		foreach($result as $admin)
		{
			$status = false;
			
			foreach($query->getElement('data', $query->serverGroupsByClientID($admin['database_id'])) as $group)
				if(in_array($group['sgid'], $cfg['admins_groups']))
				{
					$status = true;
					break;
				}
	
			if(!$status)
			{
				unset($result[$admin['database_id']]);
				continue;
			}
			
			if($result[$admin['database_id']]['time_day_start'] !== date('d')) 
			{
				$result[$admin['database_id']]['time_day_start'] = date('d');
				$result[$admin['database_id']]['time_day_time'] = 0;
			}
			if($result[$admin['database_id']]['time_week_start'] !== date('W'))
			{
				$result[$admin['database_id']]['time_week_start'] = date('W');
				$result[$admin['database_id']]['time_week_time'] = 0;
			}
			if($result[$admin['database_id']]['time_month_start'] !== date('F'))
			{
				$result[$admin['database_id']]['time_month_start'] = date('F');
				$result[$admin['database_id']]['time_month_time'] = 0;
			}	
		}

		set_cache($result);

		$lang = $language['function']['admins_time_spent'];
		$i = 0;
		$time_spent_desc = "[hr][center]".$cfg['top_description']."[/center][hr]";
		$total = count($result);
				
		foreach($result as $client)
		{
			$client_info = $query->getElement('data', $query->clientDbInfo($client['database_id']));
			if($client_info)
			{
				$i++;

				$time_spent_desc .= str_replace(['[num]', '[client]', '[today]', '[weekly]', '[monthly]', '[total]', '[off_today]', '[off_weekly]', '[off_monthly]', '[off_total]'], [$i, "[url=client://0/".$client_info['client_unique_identifier']."]".$client_info['client_nickname']."[/url]", convert_to_time($client['time_day_time']), convert_to_time($client['time_week_time']), convert_to_time($client['time_month_time']), convert_to_time($client['time_total_time'])], $lang['time_spent']);	
		
				if($i != $total)
					$time_spent_desc .= "[hr]";
			}
		}

		$time_spent_desc .= $language['function']['down_desc'];
		
		$query->channelEdit($cfg['channelid'], array('channel_description' => $time_spent_desc));

	}
?>