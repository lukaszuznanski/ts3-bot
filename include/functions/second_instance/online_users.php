<?php
	/********************************

	Author: Tymoteusz `Razor Meister` Bartnik

	Contact: battnik90@gmail.com

	Function: online_users()

	********************************/

	function online_users($cfg)
	{
		global $query;
		$function_name = " [online_users] ";

		$cfg = $cfg['online_users'];
	

		$server_info = $query->getElement('data', $query->serverInfo());
		$online = $server_info['virtualserver_clientsonline'] - $server_info['virtualserver_queryclientsonline'];
		$query->channelEdit($cfg['channel_id'], array('channel_name' => str_replace('[ONLINE]', $online, $cfg['channel_name'])));

		unset($query);
	}
?>