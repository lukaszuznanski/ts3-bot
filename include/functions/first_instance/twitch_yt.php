<?php
	/********************************

	Author: Tymoteusz `Razor Meister` Bartnik

	Contact: battnik90@gmail.com

	Function: twitch_yt()

	********************************/

	function twitch_yt($cfg)
	{
		global $query;
		global $logs;
		global $language;
		$function_name = " [twitch_yt] ";
		$cfg = $cfg['twitch_yt']['info'];

		while($twitch_channel = current($cfg['twitch'])) 
		{
			key($cfg['twitch']);
			$channels_api = 'https://api.twitch.tv/kraken/users/';
 			$channel_name = $twitch_channel;
 			$client_id = $cfg['twitch_api_key'];
 			$ch = curl_init();
 
 			curl_setopt_array
			(
				$ch, array
				(
   		 			CURLOPT_HTTPHEADER => array
					(
      		 				'Client-ID: ' . $client_id
   		 			),
   					CURLOPT_RETURNTRANSFER => true,
    					CURLOPT_URL => $channels_api . $channel_name
 				)
			);
 			$response = curl_exec($ch);
			curl_close($ch);
			$twitch_user = json_decode($response);


			$channels_api = 'https://api.twitch.tv/kraken/streams/';
 			$ch = curl_init();
 
 			curl_setopt_array
			(
				$ch, array
				(
   		 			CURLOPT_HTTPHEADER => array
					(
      		 				'Client-ID: ' . $client_id
   		 			),
   					CURLOPT_RETURNTRANSFER => true,
    					CURLOPT_URL => $channels_api . $channel_name
 				)
			);
 
 			$response = curl_exec($ch);
			curl_close($ch);
			$twitch_stream = json_decode($response);

			if(@$twitch_stream->error != NULL)
			{	
				$desc = "ERROR";
				write_info($function_name."ERROR");
			}
			elseif($twitch_stream->stream != NULL)
			{
				$desc = "[center][size=22][color=purple][b]Twitch[/b][/color][/size]\n[size=20]".$twitch_user->display_name."[color=green] [ONLINE][/color][/size][/center]\n\n";
				$desc .= "[size=12][b]".$language['function']['twitch_yt']['info']."[/b]".$twitch_user->bio."[/size]\n\n";
				$desc .= $language['function']['down_desc'];
				/*more coming soon*/
			}
			else
			{
				$desc = "[center][size=22][color=purple][b]Twitch[/b][/color][/size]\n[size=20]".$twitch_user->display_name."[color=red] [OFFLINE][/color][/size][/center]\n\n";
				$desc .= "[size=12][b]".$language['function']['twitch_yt']['info']."[/b]".$twitch_user->bio."[/size]\n\n";
				$desc .= $language['function']['down_desc'];

			}
			$query->channelEdit(key($cfg['twitch']), array('channel_description' => $desc));
			next($cfg['twitch']);
		}

		$key = $cfg['youtube_api_key'];
		while($yt_channel = current($cfg['youtube'])) 
		{
			$yt_user = json_decode(file_get_contents('https://www.googleapis.com/youtube/v3/channels?part=snippet,statistics&id='.$yt_channel.'&key='.$key));;

			if(isset($yt_user->error))
			{	
				$desc = "ERROR";
				write_info($function_name."ERROR");
			}
			else
			{
				$desc = "[center][size=22][color=red][b]YouTube[/b][/color][/size]\n[size=20]".$yt_user->items[0]->snippet->title."[/size][/center]\n\n";
				$desc .= "[size=12][b]".$language['function']['twitch_yt']['info']."[/b]".$yt_user->items[0]->snippet->description."[/size]\n\n";
				$desc .= "[size=12][b]".$language['function']['twitch_yt']['subs']."[/b]".$yt_user->items[0]->statistics->subscriberCount."[/size]";
				$desc .= $language['function']['down_desc'];
			}
				
			$query->channelEdit(key($cfg['youtube']), array('channel_description' => $desc));
			next($cfg['youtube']);
		}


	}
?>