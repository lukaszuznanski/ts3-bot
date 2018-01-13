<?php
	/********************************

	Author: Tymoteusz `Razor Meister` Bartnik

	Contact: battnik90@gmail.com

	Function: channels_checker()

	********************************/

	function creat_free_channel($number, $order, $cfg)
	{
		global $query, $language;

		$lang = $language['function']['channels_guard'];
		$desc = "[center][size=15][b]".$lang['private_channel'].$number.$lang['empty']."[/b][/size][/center]\n\n[size=11]".$lang['how_to_get']."[/size]\n\n\n".$language['function']['down_desc'];
		
		$query->channelCreate(array
		(
			'channel_name' => $number.". ".$cfg['free_channel_name'],
			'channel_topic' => $cfg['empty_channel_topic'],
			'cpid' => $cfg['channels_zone'],
			'channel_flag_semi_permanent' => 0,
			'channel_flag_permanent' => 1,
			'channel_flag_maxclients_unlimited' => 0,
			'channel_flag_maxfamilyclients_unlimited' => 0,
			'channel_flag_maxfamilyclients_inherited' => 0,
			'channel_maxclients' => 0,
			'channel_maxfamilyclients' => 0,
			'channel_order' => $order,
			'channel_description' => $desc,
		));
	}

	function channels_checker($cfg)
	{
		global $query, $language;
		

		$cfg = $cfg['channels_checker'];
		$lang = $language['function']['channels_guard'];
		
		$num = 0;
		$order = 0;

		foreach($channels = $query->getElement('data', $query->channelList("-topic -limits -flags")) as $channel)
		{
			if($channel['pid'] == $cfg['channels_zone'])
			{	
				$num++;			

				if($channel['channel_topic'] != $cfg['empty_channel_topic'])
				{
					if((!preg_match("/^[0-9]{2}\-[0-9]{2}\-[0-9]{4}$/", $channel['channel_topic']) || ($cfg['new_date_if_user'] && 	$channel['total_clients'] > 0)) && $channel['channel_topic'] != date('d-m-Y'))
						$query->channelEdit($channel['cid'], array('channel_topic' => date('d-m-Y')));

					elseif($channel['channel_topic'] != date('d-m-Y'))
					{
													
						$channel_date = explode("-", $channel['channel_topic']);
						$time_delete = mktime(0,0,0,$channel_date[1],$channel_date[0] + $cfg['time_interval_delete'],$channel_date[2]);

						if(time() >= $time_delete)
						{
							$query->channelDelete($channel['cid']);
							creat_free_channel($num, $order, $cfg);
						}
					}
				}

				$order = $channel['cid'];
			}
		}
	}
?>