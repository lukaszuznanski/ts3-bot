<?php
	/********************************

	Author: Tymoteusz `Razor Meister` Bartnik

	Contact: battnik90@gmail.com

	Function: anty_vpn()

	********************************/
	

	function has_vpn($ip, $cfg)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,"http://v2.api.iphub.info/ip/".$ip);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$headers = [
   		 'X-Key: '.$cfg['X-Key'],
       		];

		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		$server_output = json_decode(curl_exec($ch));

		curl_close ($ch);
	
		if(isset($server_output->block) && $server_output->block == 1)
			return true;
		else
			return false;
	}

	function has_ignored_rang_antyvpn(array $groups, $cfg)
	{
		foreach($groups as $group)
		{	
			if(in_array($group, $cfg['ignored_groups']))
				return true;
		}
		
		return false;
	}


	function anty_vpn($cfg, $client)
	{
		global $query;

		$cfg = $cfg['anty_vpn'];	
		
		if(!has_ignored_rang_antyvpn(explode(",", $client['client_servergroups']), $cfg) && has_vpn($client['connection_client_ip'], $cfg))
			$query->clientKick($client['clid'], "server", $cfg['message_to_client']);
	}
?>