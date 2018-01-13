<?php
	/********************************

	Author: Tymoteusz `Razor Meister` Bartnik

	Contact: battnik90@gmail.com

	Function: ban_list()

	********************************/

	function tip_of_words($num, $for1, $for234, $for_others)
	{
		$text = " ".$num." ";
		if($num == 1)
			return $text.$for1;
		elseif(in_array($num%10, array(2,3,4)))
			return $text.$for234;
		else return $text.$for_others; 
	}


	function convert_to_time($seconds)
	{
		global $language;

		$lang = $language['function'];

		$text = "";
		$uptime['d']=floor($seconds / 86400);
		$uptime['h']=floor(($seconds - ($uptime['d'] * 86400)) / 3600);
		$uptime['m']=floor(($seconds - (($uptime['d'] * 86400)+($uptime['h']*3600))) / 60);
		
		if($uptime['d'] != 0)
			$text .= tip_of_words($uptime['d'], $lang['one_day'], $lang['2_days'], $lang['other_days']);
		if($uptime['h'] != 0)
			$text .= tip_of_words($uptime['h'], $lang['one_hour'], $lang['2_hours'], $lang['other_hours']);
		if($uptime['m'] != 0)
			$text .= tip_of_words($uptime['m'], $lang['one_minute'], $lang['2_minutes'], $lang['other_minutes']);

		return $text;
	}


	function ban_list($cfg)
	{
		global $query, $language;

		$cfg = $cfg['ban_list'];
		$lang = $language['function']['ban_list'];
		
		
		$ban_list = $query->getElement('data', $query->banList());
		$list = "";
		$i = 0;
		$j = 0;

		foreach($ban_list as $single_ban)
			if($single_ban['uid'] != '')
				$i++;
		
		$list .= "[hr][center][size=18]".$lang['header'].$i."[/size][/center][hr]\n";

		if($cfg['how_many'] > $i)
			$cfg['how_many'] = 0;     

		foreach($ban_list as $single_ban)
		{
			if($j<($i-$cfg['how_many']))
			{
				if($single_ban['uid'] == '')
					continue;			

				$j++;

				if($single_ban['duration'] == 0)
					$time = $lang['permament'];
				else
					$time = convert_to_time($single_ban['duration']);

				$list .= "[center][color=blue][b][size=15]".$j."[/size][/b][/color][/center][list][*]".$lang['user'].": ".$single_ban['lastnickname']."\n[*]".$lang['time'].": ".$time."\n[*]".$lang['reason'].": ".$single_ban['reason']."\n[*]".$lang['invoker'].": [color=blue]".$single_ban['invokername']."[/color]\n[*]".$lang['date'].": ".date('d-m-Y G:i', $single_ban['created'])."[/list]\n";
			}
			
		}

		$list .= $language['function']['down_desc'];
		
		$query->channelEdit($cfg['channel_id'], array('channel_description' => $list));
	}
?>