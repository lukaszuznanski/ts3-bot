<?php
	/********************************

	Author: Tymoteusz `Razor Meister` Bartnik

	Contact: battnik90@gmail.com

	Function: get_server_group()

	********************************/

function get_server_group($cfg, $client)
{
	global $query;

	$config = $cfg['get_server_group']['info'];
	$groups = explode(',', $client['client_servergroups']);

	foreach($config as $ch_id => $server_group)
	{
		if($client['cid'] == $ch_id)
		{
			if(!in_array($server_group, $groups))
				$query->serverGroupAddClient($server_group, $client['client_database_id']);
			elseif(in_array($server_group, $groups))
				$query->serverGroupDeleteClient($server_group, $client['client_database_id']);

			$query->clientKick($client['clid'], "channel");
		}
	}
}
?>