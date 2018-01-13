<?php
	/********************************

	Author: Tymoteusz `Razor Meister` Bartnik

	Contact: battnik90@gmail.com

	Function: advertisement_message()

	********************************/

	function advertisement_message($cfg)
	{
		global $query;
		global $cache;
		global $logs;
		global $language;
		$function_name = " [advertisement_message] ";
		
		global $connect, $name;
		if(strpos($connect['bot_name'], "(XBOT)") === false)
			die(write_info($name."Bot musi mieć w nazwie frazę (XBOT)"));

		$cfg = $cfg['advertisement_message'];
		$server_info = $query->getElement('data', $query->serverInfo());		

		$message = fread(fopen($cfg['file'], "r"), filesize($cfg['file']));
			
		$query->sendMessage(3, $server_info['virtualserver_id'], $message);
		
		unset($query);
		unset($logs);
		unset($language);
	}
?>