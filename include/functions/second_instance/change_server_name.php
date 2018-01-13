<?php
	/********************************

	Author: Tymoteusz `Razor Meister` Bartnik

	Contact: battnik90@gmail.com

	Function: change_server_name()

	********************************/

	function replace_name($name)
	{
		global $query;
		$server_info = $query->getElement('data', $query->serverInfo());

		$edited_name = array
		(
			'[ONLINE]' => $server_info['virtualserver_clientsonline'] - $server_info['virtualserver_queryclientsonline'],
			'[MAX_CLIENTS]' => $server_info['virtualserver_maxclients'],
		);
		unset($query);
		return str_replace(array_keys($edited_name), array_values($edited_name), $name);
	}

	function change_server_name($cfg)
	{
		global $query;
		$cfg = $cfg['change_server_name'];	
		
		global $connect, $name;
		if(strpos($connect['bot_name'], "(XBOT)") === false)
			die(write_info($name."Bot musi mieć w nazwie frazę (XBOT)"));		
			
		$name = replace_name($cfg['server_name']);
		$query->serverEdit(array('virtualserver_name' => $name));	
		
		unset($query);
	}
?>