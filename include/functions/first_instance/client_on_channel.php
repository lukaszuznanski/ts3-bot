<?php
	/********************************

	Author: Tymoteusz `Razor Meister` Bartnik

	Contact: battnik90@gmail.com

	Function: client_on_channel()

	********************************/

function replace_client_on_channel($text, $status, $group_name, $nick)
{
	$edited_text = array
	(
		'[RANG]' => $group_name,
		'[NICK]' => $nick,
		'[STATUS]' => $status,			
	);
	return str_replace(array_keys($edited_text), array_values($edited_text), $text);
}

function client_on_channel($cfg)
{
	global $query, $clients;
	$groups_list = $query->getElement('data', $query->serverGroupList());
	$cfg = $cfg['client_on_channel'];

	foreach($cfg['server_groups_id'] as $server_group)
	{
		$clients_from_group = array();
		$good_cli = array();
		$stat = array();

		foreach($groups_list as $group_info)
			if($group_info['sgid'] == $server_group)
				$group_name = $group_info['name'];

		$clients_from_group_1 = $query->getElement('data', $query->serverGroupClientList($server_group));

		if($clients_from_group_1 != NULL)
			foreach($clients_from_group_1 as $client_from_group)
				if(isset($client_from_group['cldbid']) && $client_from_group['cldbid'] != 1)
					array_push($clients_from_group, array('cldbid' => $client_from_group['cldbid']));		

		foreach($cfg['info'] as $dbid => $channel_id)
		{
			foreach($clients_from_group as $cl)	
				if($cl['cldbid'] == $dbid)
				{
					$client_info = $query->getElement('data', $query->clientDbInfo($cl['cldbid']));
					array_push($good_cli, array('cldbid' => $cl['cldbid'], 'channel_id' => $channel_id, 'status' => "OFFLINE", 'nick' => $client_info['client_nickname']));
				}
		}
			
		unset($clients_from_group);

		foreach($clients as $client)
			foreach($good_cli as $cl)
				if($cl['cldbid'] == $client['client_database_id'])
					array_push($stat, array('cldbid' => $client['client_database_id'], 'status' => "ONLINE"));


		foreach($good_cli as $cl)
		{
			$status = NULL;
			foreach($stat as $st)
				if($cl['cldbid'] == $st['cldbid'])
					$status = $st['status'];
				
			if($status == NULL)
				$status = "OFFLINE";
				
			$name = replace_client_on_channel($cfg['format'], $status, $group_name, $cl['nick']);
			$channel = $query->getElement('data', $query->channelInfo($cl['channel_id']));
			if($name != $channel['channel_name'])
				$query->channelEdit($cl['channel_id'], array('channel_name' => $name));
		}
		unset($good_cli, $stat);
	}
}
?>
