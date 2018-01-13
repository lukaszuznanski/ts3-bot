<?php
	/********************************

	Author: Tymoteusz `Razor Meister` Bartnik

	Contact: battnik90@gmail.com

	Function: record_online()

	********************************/

	function record_online($cfg)
	{
		global $query;
		$function_name = " [record_online] ";

		$cfg = $cfg['record_online'];

		$server_info = $server_info = $query->getElement('data', $query->serverInfo());
		$current_online = $server_info['virtualserver_clientsonline'] - $server_info['virtualserver_queryclientsonline'];

		global $connect, $name;
		if(strpos($connect['bot_name'], "(XBOT)") === false)
			die(write_info($name."Bot musi mieć w nazwie frazę (XBOT)"));		

		if(!file_exists("include/cache/record_online.txt"))
		{
			$fp = fopen("include/cache/record_online.txt", "a");
			fwrite($fp, $current_online);
			fclose($fp);
		}
		else
		{
			$fp = fopen("include/cache/record_online.txt", "r");
			$record = fread($fp, filesize("include/cache/record_online.txt"));
			fclose($fp);
			if($record<$current_online)
			{
				$fp = fopen("include/cache/record_online.txt", "w");
				fwrite($fp, $current_online);
				fclose($fp);
			}
				
			else
				$current_online = $record;
		}

		$query->channelEdit($cfg['channel_id'], array('channel_name' => str_replace('[RECORD]', $current_online, $cfg['channel_name'])));

		unset($query);
	}
?>