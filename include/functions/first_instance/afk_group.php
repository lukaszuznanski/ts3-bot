<?php
	/********************************

	Author: Tymoteusz `Razor Meister` Bartnik

	Contact: battnik90@gmail.com

	Function: afk_group()

	********************************/

function has_ignored_rang(array $groups, $cfg)
{
	foreach($groups as $group)	
		if(in_array($group, $cfg['ignored_groups']))
			return true;
		
	return false;
}


function afk_group($cfg, $client)
{
	global $query, $clients;

	$cfg = $cfg['afk_group'];
	
	$client_info = $query->getElement('data', $query->clientInfo($client['clid']));
	$server_groups = explode(",", $client_info['client_servergroups']);
		
	if(!has_ignored_rang(explode(',', $client['client_servergroups']), $cfg) && (($cfg['set_group_if_away'] && $client_info['client_away'] == 1) || $client_info['client_idle_time'] >= 1000 * $cfg['idle_time']))
	{
		if(!in_array($cfg['afk_group_id'], $server_groups))
			$query->serverGroupAddClient($cfg['afk_group_id'], $client['client_database_id']);

		return;
	}
	elseif(in_array($cfg['afk_group_id'], $server_groups))	
		$query->serverGroupDeleteClient($cfg['afk_group_id'], $client['client_database_id']);
}
?>