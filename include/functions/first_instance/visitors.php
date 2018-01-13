<?php
	/********************************

	Author: Tymoteusz `Razor Meister` Bartnik & zmechu[PL]

	Contact: battnik90@gmail.com

	Function: visitors()

	********************************/
	function visitors($cfg)
	{
		global $query;

		$cfg = $cfg['visitors'];

		global $connect, $name;
		if(strpos($connect['bot_name'], "(XBOT)") === false)
			die(write_info($name."Bot musi mieć w nazwie frazę (XBOT)"));

		$server_info = $query->getElement('data', $query->serverInfo());
		$query->channelEdit($cfg['channel_id'], array('channel_name' => str_replace('[VISITS]', $server_info['virtualserver_client_connections'], $cfg['channel_name'])));
	}
?>