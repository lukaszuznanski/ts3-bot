<?php
	/********************************

	Author: Tymoteusz `Razor Meister` Bartnik

	Contact: battnik90@gmail.com

	Function: multi_function()

	********************************/
	function multi_function($cfg)
	{
		global $query;
		global $logs;
		global $language;
		$cfg = $cfg['multi_function'];
		
		global $connect, $name;
		if(strpos($connect['bot_name'], "(XBOT)") === false)
			die(write_info($name."Bot musi mieć w nazwie frazę (XBOT)"));

		$server_info = $query->getElement('data', $query->serverInfo());

		if($cfg['content']['total_ping']['enabled'])
		{
			$ping = $server_info['virtualserver_total_ping'];
			$function = $cfg['content']['total_ping'];
			if($function['integer'])
			{
				$ping = explode(".", $ping);
				$ping = $ping[0];
			}
						
			$channel = array();
			$channel['channel_name'] = str_replace("%ping", "$ping", $function['channel_name']);

			$query->channelEdit($function['channel_id'], $channel);
		}

		if($cfg['content']['packet_loss']['enabled'])
		{
			$packet_loss = $server_info['virtualserver_total_packetloss_total'];
			$function = $cfg['content']['packet_loss'];
			if($function['integer'])
			{
				$packet_loss = explode(".", $packet_loss);
				$packet_loss = $packet_loss[0];
			}
		
			$channel = array();
			$channel['channel_name'] = str_replace("%packetloss", "$packet_loss", $function['channel_name']);

			$query->channelEdit($function['channel_id'], $channel);
		}

		unset($query);
		unset($logs);
		unset($language);
	}
?>