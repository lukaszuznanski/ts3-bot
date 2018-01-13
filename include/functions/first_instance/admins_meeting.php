<?php
	/********************************

	Author: Tymoteusz `Razor Meister` Bartnik

	Contact: battnik90@gmail.com

	Function: admins_meeting()

	********************************/

	function difference($meeting_date, &$flag)
	{
		
		$date_time = explode(" ", $meeting_date);
		$meeting_date = explode(".", $date_time[0]);
		$meeting_time = explode(":", $date_time[1]);


		$current_date[2] = date('Y');
		$current_date[1] = date('m');
		$current_date[0] = date('d');


		if($current_date['2']<$meeting_date['2'])	
			$flag = 1;
		elseif($current_date['2'] == $meeting_date['2'])
		{
			if($current_date['1']<$meeting_date['1'])
				$flag = 1;
			elseif($current_date['1'] == $meeting_date['1'])
			{
				if($current_date['0']<$meeting_date['0'])
					$flag = 1;
				elseif($current_date['0'] == $meeting_date['0'])
				{
					$meeting_time = mktime($meeting_time[0], $meeting_time[1]);
					$current_time = mktime(date('G'), date('i'));

					if($current_time<$meeting_time)
					{
						$difference = $current_time-$meeting_time;
						$flag = 2;

						if($difference<0)
							return -$difference;
						else
							return $difference;

					}
					elseif($current_time == $meeting_time)
					{
						$flag = 5;
						return 0;
					}
					else
						$flag = 3;
				}
				else
					$flag = 3;
			}
			else
				$flag = 3;
		}
		else
			$flag = 3;
	}

	function admins_meeting($cfg)
	{
		global $query, $logs, $language, $cache_poked, $cache_moved;

		$function_name = " [admins_meeting] ";

		$time_good = 0;
		$cfg = $cfg['admins_meeting']['info'];
		
		$channel = $query->getElement('data', $query->channelInfo($cfg['channel_id']));
		$meeting_date = substr($channel['channel_name'], -16);
		
		$different = difference($meeting_date, $time_good);		

		if($time_good == 3)
		{
			if($cache_poked == 1)
				$cache_poked = 0;
			if($cache_moved == 1)
				$cache_moved = 0;

		}
		if($time_good == 2 && $different == $cfg['time_to_meeting'] && $cache_poked==0)
		{
			$clients = $query->getElement('data', $query->clientList("-groups"));
			foreach($clients as $client)
			{
				$client_groups = explode(',', $client['client_servergroups']);
				foreach($client_groups as $client_group)
				{
					if(in_array($client_group, $cfg['admins_server_groups']) && $client['client_database_id'] != 1)
						$query->clientPoke($client['clid'], $client['client_nickname'].$language['admins_meeting']['information']);
				}
			}
			$cache_poked = 1;
		}
		elseif($time_good == 5 && $cfg['move_admins'] && $cache_moved==0)
		{
			$moved_admins = 0;
			$clients = $query->getElement('data', $query->clientList("-groups"));
			foreach($clients as $client)
			{
				$client_groups = explode(',', $client['client_servergroups']);
				foreach($client_groups as $client_group)
				{
					if(in_array($client_group, $cfg['admins_server_groups']) && $client['client_database_id'] != 1)
					{
						$query->clientMove($client['clid'], $cfg['channel_id']);
						$moved_admins++;
					}
				}
			}
			write_info($function_name.$moved_admins.$language['function']['admins_meetin']['moved']);
			$cache_moved = 1;
		}
		
		elseif(($time_good == 1 || $time_good == 2) && $different != $cfg['time_to_meeting'])
		{
			/*$all_clients = $query->getElement('data', $query->clientList());		
		
			$new_clients = array();
			if($cache_old_clients == 0)
				$new_clients = array_diff($all_clients, $clients);
			else
				$new_clients = array_diff($all_clients, $cache_old_clients);

			if($new_clients != 0)
			{
				foreach($new_clients as $new_client)
				{
					$query->clientPoke($new_client['clid'], "cebula");

				}
			}

			$cache_old_clients = $all_clients;*/

			if($cache_poked)
				$cache_poked = 0;
			if($cache_moved)
				$cache_moved = 0;

		}
		

		unset($query);
		unset($logs);
		unset($language);
	}
	




?>