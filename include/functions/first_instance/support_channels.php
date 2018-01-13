<?php
	/********************************

	Author: Tymoteusz `Razor Meister` Bartnik

	Contact: battnik90@gmail.com

	Function: support_channels()

	********************************/
	function support_channels($cfg)
	{
		global $query;
		global $logs;
		global $language;
		$cfg = $cfg['support_channels'];

		foreach($cfg['content'] as $info)
		{
			$time_open = explode(":", $info['time_open']);
			$time_close = explode(":", $info['time_close']);
			$clock_open = mktime($time_open[0], $time_open[1], 0, date('m'), date('d'), date('Y'));
			$clock_close = mktime($time_close[0], $time_close[1], 0, date('m'), date('d'), date('Y'));

			$channel = array();

			if(time()>=$clock_open && time()<$clock_close)
			{
				$channel['channel_name'] = $info['channel_name_open'];
				$channel['channel_flag_maxclients_unlimited'] = 1;
				$channel['channel_maxclients'] = '-1';
			}
			else
			{
				$channel['channel_name'] = $info['channel_name_close'];
				$channel['channel_flag_maxclients_unlimited'] = 0;
				$channel['channel_maxclients'] = '0';
			}

			$query->channelEdit($info['channelId'], $channel);
		}
	}
?>