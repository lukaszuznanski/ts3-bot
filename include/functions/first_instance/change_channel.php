<?php
	/********************************

	Author: Tymoteusz `Razor Meister` Bartnik

	Contact: battnik90@gmail.com

	Function: change_channel()

	********************************/

	function change_channel($cfg)
	{
		global $query;
		global $cache;
		global $logs;
		global $language;
		$function_name = " [change_channel] ";

		$cfg = $cfg['change_channel'];
		
		$name = array();
		$name['channel_name'] = $cfg['channel_name'][$cache];
		$query->channelEdit($cfg['channel_id'],$name);
			
		if($cache+1 == count($cfg['channel_name']))
			$cache=0;
		else
			$cache++;

		unset($query);
		unset($logs);
		unset($language);
	}
?>