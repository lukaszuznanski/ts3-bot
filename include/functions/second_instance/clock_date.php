<?php
	/********************************

	Author: Tymoteusz `Razor Meister` Bartnik

	Contact: battnik90@gmail.com

	Function: clock_date()

	********************************/
	function clock_date($cfg)
	{
		global $query;
		global $logs;
		global $language;
		$cfg = $cfg['clock_date'];


		if($cfg['content']['clock']['enabled'])
		{
			$function = $cfg['content']['clock'];
					
			$channel = array();
			$channel['channel_name'] = str_replace("%clock", date($function['format']), $function['channel_name']);

			$query->channelEdit($function['channel_id'], $channel);
		}

		if($cfg['content']['date']['enabled'])
		{
			$function = $cfg['content']['date'];
					
			$channel = array();
			$channel['channel_name'] = str_replace("%date", date($function['format']), $function['channel_name']);

			$query->channelEdit($function['channel_id'], $channel);
		}

		unset($query);
		unset($logs);
		unset($language);
	}
?>